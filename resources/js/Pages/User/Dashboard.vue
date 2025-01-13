<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router, usePage} from '@inertiajs/vue3';
import {computed, ref} from 'vue';
import CustomerList from "@/Pages/Customer/Components/CustomerList.vue";

const tab = ref('prospects');

const props = defineProps({
    prospects: {
        type: Array,
        required: true
    },
    customers: {
        type: Array,
        required: true
    }
});

const prospectHeaders = [
    {title: 'Company Name', key: 'company_name', sortable: false},
    {title: 'Email', key: 'email', sortable: false},
    {title: 'Actions', key: 'actions', sortable: false},
]

const user = computed(() => usePage().props.auth.user);
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
                        <v-tabs
                            v-model="tab"
                            bg-color="success"
                        >
                            <v-tab value="prospects">Prospects</v-tab>
                            <v-tab value="customers">Customers</v-tab>
                        </v-tabs>
                        <v-card-title>
                            <v-tabs-window v-model="tab">
                                <v-tabs-window-item value="prospects">
                                    <v-card-text class="mt-2">
                                        <v-data-table
                                            :headers="prospectHeaders"
                                            :items="prospects"
                                            :items-per-page="5"
                                            class="elevation-3"
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
                                </v-tabs-window-item>

                                <v-tabs-window-item value="customers">
                                    <v-card-text class="mt-2">
                                        <CustomerList :customers="customers" />
                                    </v-card-text>
                                </v-tabs-window-item>
                            </v-tabs-window>
                        </v-card-title>
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
