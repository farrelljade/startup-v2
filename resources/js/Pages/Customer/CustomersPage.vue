<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router} from "@inertiajs/vue3";

const props = defineProps({
    customers: {
        type: Array,
        required: true
    }
})

const customersHeaders = [
    { title: 'Company Name', key: 'company_name', sortable: false },
    { title: 'Phone', key: 'phone', sortable: false },
    { title: 'Email', key: 'email', sortable: false },
    { title: 'Account Manager', key: 'user.name', sortable: false },
    { title: 'Actions', key: 'actions', sortable: false },
]
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Customers" />

        <v-container fluid>
            <v-card class="mb-3 pa-3">
                <v-card-title class="bg-green-darken-1 d-flex justify-space-between align-center">
                    Customers Page
                </v-card-title>
            </v-card>

            <v-card>
                <v-card-text>
                    <v-data-table
                        :headers="customersHeaders"
                        :items="customers"
                    >
                        <template v-slot:item.actions="{ item }">
                            <v-btn
                                variant="text"
                                icon="mdi-location-enter"
                                color="warning"
                                @click="router.visit(route('company.profile', item.id ))"
                            />
                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card>
        </v-container>
    </AuthenticatedLayout>
</template>
