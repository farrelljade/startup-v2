<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, router} from '@inertiajs/vue3';

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
            <v-card class="mb-3 pa-1">
                <v-card-title class="bg-success d-flex justify-space-between align-center">
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
                                @click="router.visit(route('users.show', item.id ))"
                            />
                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card>
        </v-container>
    </AuthenticatedLayout>
</template>
