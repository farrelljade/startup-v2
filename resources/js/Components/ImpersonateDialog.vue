<script setup>

import {computed, ref} from "vue";
import {usePage} from "@inertiajs/vue3";
import {createCookie} from "@/helpers/helpers.js";

const dialog = defineModel('dialog', {
    type: Boolean,
    default: false
});

const emit = defineEmits(['close']);

const selectedUser = ref(null);
const loading = ref(false);

const users = computed(() => {
    return usePage().props.users || [];
})

const cancelImpersonate = () => {
    selectedUser.value = null;
    emit('close');
}

const impersonateUser = () => {
    if (selectedUser.value) {
        loading.value = true;
        createCookie('impersonate', selectedUser.value, 1);
        window.location.reload();
    }
}
</script>

<template>
    <v-dialog
        v-model="dialog"
        transition="dialog-bottom-transition"
        persistent
        width="60vh"
    >
        <v-card class="pa-1">
            <v-toolbar
                color="green-darken-1"
            >
                <v-toolbar-title>Impersonate User</v-toolbar-title>
            </v-toolbar>
                <v-spacer/>
            <v-card-text class="text-center">
                <v-row>
                    <v-col cols="12">
                        <v-autocomplete
                            v-model="selectedUser"
                            :items="users"
                            item-value="id"
                            item-title="name"
                            label="Select User"
                            variant="underlined"
                            clearable
                        ></v-autocomplete>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-divider/>
            <v-card-actions>
                <v-btn
                    color="error"
                    @click="cancelImpersonate"
                    variant="tonal"
                >
                    Cancel
                </v-btn>
                <v-spacer/>
                <v-btn
                    color="success"
                    @click="impersonateUser"
                    :loading="loading"
                    variant="tonal"
                >
                    Impersonate
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
