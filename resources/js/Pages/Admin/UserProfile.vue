<script setup>
import {computed, ref} from 'vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, useForm, usePage} from '@inertiajs/vue3';
import {updateUser, updateUserPermissions, userHasPermission} from "@/helpers/helpers.js";

const props = defineProps({
    user: {
        type: Object,
        required: true
    },
    availablePermissions: {
        type: Array,
        required: true
    },
    users: {
        type: Object,
        required: true
    }
})

const snackbar = ref(false);
const snackbarMessage = ref('');

const form = useForm({
    email: props.user.email,
    manager_id: props.user.manager_id
})

const authUser = computed(() => usePage().props.auth.user);

const filteredUsers = computed(() => {
    return props.users
        .filter(user => user.id !== props.user.id)
        .map(user => ({
            title: user.name,
            value: user.id,
            props: { disabled: user.id === props.user.manager_id }
        }));
});

function handleUpdate() {
    updateUser(props.user.id, form, () => {
        snackbar.value = true;
        snackbarMessage.value = 'User updated!';
    });
}

// Create a reactive object to track permissions
const selectedPermissions = ref(
    props.user.permissions?.map(p => p.name) || []
);

function handlePermissionChange(permissionName) {
    updateUserPermissions(
        props.user.id,
        selectedPermissions.value,
        () => {
            snackbar.value = true;
            snackbarMessage.value = 'Updated successfully!';
        }
    );
}

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Profile" />
        <v-container fluid>
            <v-card class="mb-3 pa-1">
                <v-card-title class="bg-success d-flex justify-space-between align-center">
                    User Profile
                </v-card-title>
            </v-card>

            <v-row>
                <v-col cols="12" md="6">
                    <v-card class="pa-1">
                        <v-card-title class="bg-success d-flex justify-space-between align-center">
                            First Card
                        </v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col md="6">
                                    <v-text-field
                                        v-model="user.name"
                                        label="Name"
                                        readonly
                                    />
                                </v-col>
                                <v-col md="6">
                                    <v-text-field
                                        v-model="form.email"
                                        label="Email"
                                        @change="handleUpdate"
                                        :readonly="!userHasPermission(authUser, 'Edit User')"
                                    />
                                </v-col>
                                <v-col cols="6">
                                    <v-select
                                        v-model="form.manager_id"
                                        variant="underlined"
                                        label="Manager"
                                        :items="filteredUsers"
                                        @update:modelValue="handleUpdate"
                                        :readonly="!userHasPermission(authUser, 'Edit User')"
                                    />
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-col>

                <v-col cols="12" md="6">
                    <v-card class="pa-1">
                        <v-card-title class="bg-success d-flex justify-space-between align-center">Permissions</v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col cols="12" md="4" sm="4">
                                    <v-checkbox
                                        v-for="permission in availablePermissions"
                                        :key="permission.id"
                                        v-model="selectedPermissions"
                                        :value="permission.name"
                                        :label="permission.name"
                                        @change="handlePermissionChange(permission.name)"
                                        color="success"
                                        hide-details
                                    ></v-checkbox>
                                </v-col>
                            </v-row>
                        </v-card-text>

                        <v-snackbar
                            v-model="snackbar"
                            :timeout="3000"
                            color="success"
                        >
                            {{ snackbarMessage }}
                        </v-snackbar>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </AuthenticatedLayout>
</template>
