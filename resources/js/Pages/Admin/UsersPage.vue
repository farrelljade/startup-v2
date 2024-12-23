<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    users: Object
})

const usersHeaders = [
    { title: 'Name', key: 'name', sortable: false},
    { title: 'Email', key: 'email', sortable: false},
    { title: 'Action', key: 'actions', sortable: false}
]

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Users" />
        <v-container fluid>
            <v-card class="mb-2 pa-3">
                <v-card-title class="bg-success mb-5 d-flex justify-space-between align-center">
                    Users Page
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
                        />
                    </template>
                </v-data-table>
                </v-card-text>
            </v-card>
        </v-container>
    </AuthenticatedLayout>
</template>
