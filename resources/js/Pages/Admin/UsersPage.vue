<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AddNewUserDialog from '@/Pages/Admin/Components/AddNewUserDialog.vue';
import {Head, router} from '@inertiajs/vue3';
import {ref} from "vue";

const snackbar = ref(false);
const snackbarMessage = ref('');

const addNewUserDialog = ref(false);

defineProps({
    users: Object
})

const usersHeaders = [
    { title: 'Name', key: 'name', sortable: false},
    { title: 'Email', key: 'email', sortable: false},
    { title: 'Action', key: 'actions', sortable: false}
]

const closeDialog = () => {
    addNewUserDialog.value = false;
}

const openAddNewUserDialog = () => {
    addNewUserDialog.value = true;
}

const handleSuccess = () => {
    snackbar.value = true;
    snackbarMessage.value = 'User successfully created'
}

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Users" />

        <v-container fluid>
            <v-card class="mb-3 pa-1">
                <v-card-title class="bg-success d-flex justify-space-between align-center">
                    Users Page

                    <v-btn
                        size="small"
                        variant="elevated"
                        @click="openAddNewUserDialog"
                    >
                        Add User
                    </v-btn>
                </v-card-title>
            </v-card>

            <v-card>
                <v-card-text>
                    <v-data-table
                        :headers="usersHeaders"
                        :items="users"
                    >
                        <template v-slot:item.actions="{ item }">
                            <v-btn
                                variant="text"
                                icon="mdi-location-enter"
                                color="warning"
                                @click="router.visit(route('users.show', item.id ))"
                            />
                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card>
        </v-container>

        <v-dialog
            v-model="addNewUserDialog"
            width="60vw"
            persistent
        >
            <AddNewUserDialog
                @close="closeDialog"
                @success="handleSuccess"
            />
        </v-dialog>
    </AuthenticatedLayout>
</template>
