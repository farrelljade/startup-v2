<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';

defineProps({
    prospects: Object
})

const prospectsHeaders = [
    { title: 'Name', key: 'company_name', sortable: false},
    { title: 'Account Manager', key: 'user.name', sortable: false},
    { title: 'Lead Source', key: 'lead_source.name', sortable: false},
    { title: 'Action', key: 'actions', sortable: false}
]

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Prospects" />

        <v-container fluid>
            <v-card class="mb-3 pa-3">
                <v-card-title class="bg-success d-flex justify-space-between align-center">
                    Prospects Page
                </v-card-title>
            </v-card>

            <v-card>
                <v-card-text>
                    <v-data-table
                        :headers="prospectsHeaders"
                        :items="prospects"
                    >
                        <template v-slot:item.actions="{ item }">
                            <v-btn
                                variant="text"
                                icon="mdi-location-enter"
                                color="warning"
                                @click="router.visit(route('prospect.enquiry', item.id ))"
                            />
                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card>
        </v-container>
    </AuthenticatedLayout>
</template>
