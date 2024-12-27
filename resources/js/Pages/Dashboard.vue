<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';

const props = defineProps({
    user: {
        type: Object,
        required: true
    }
});

const prospectHeaders = [
    {title: 'Company Name', key: 'company_name', sortable: false},
    {title: 'Email', key: 'email', sortable: false},
    {title: 'Actions', key: 'actions', sortable: false},
]
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <Head title="Home" />
        <v-container fluid>
            <v-card class="mb-3 pa-2">
                <v-card-title class="bg-success d-flex justify-space-between align-center">
                    {{ user.name }}
                </v-card-title>
            </v-card>

            <v-row>
                <v-col cols="12" md="6">
                    <v-card>
                        <v-card-title class="bg-success d-flex justify-space-between align-center">
                            Prospects
                        </v-card-title>
                        <v-card-text class="mt-2">
                            <v-data-table
                                :headers="prospectHeaders"
                                :items="user.prospects"
                                :items-per-page="5"
                                class="elevation-3"
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
                </v-col>

                <v-col cols="12" md="6">
                    <v-card>
                        <v-card-title>Second Card</v-card-title>
                        <v-card-text>
                            Content for second card
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </AuthenticatedLayout>
</template>
