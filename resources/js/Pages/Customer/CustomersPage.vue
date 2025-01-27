<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router} from "@inertiajs/vue3";
import {computed, ref} from "vue";

const search = ref(null);

const props = defineProps({
    customers: {
        type: Array,
        required: true
    }
})

const customerItems = computed(() => {
    return props.customers.map(customer => customer.company_name);
});

const filteredCustomers = computed(() => {
    if (!search.value) return props.customers;

    const searchTerm = search.value.toLowerCase();
    return props.customers.filter(customer =>
        customer.company_name.toLowerCase().includes(searchTerm) ||
        customer.email.toLowerCase().includes(searchTerm) ||
        customer.phone.toLowerCase().includes(searchTerm)
    );
});

const customersHeaders = [
    {title: 'Company Name', key: 'company_name', sortable: false},
    {title: 'Phone', key: 'phone', sortable: false},
    {title: 'Email', key: 'email', sortable: false},
    {title: 'Account Manager', key: 'user.name', sortable: false},
    {title: 'Created At', key: 'created_at', sortable: false},
    {title: 'Actions', key: 'actions', sortable: false},
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

                <v-card-text>
                    <v-row class="mt-2">
                        <v-col cols="12" md="3">
                            <v-autocomplete
                                v-model="search"
                                :items="customerItems"
                                variant="underlined"
                                label="Search Company"
                                clearable

                            />
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>

            <v-card>
                <v-card-text>
                    <v-data-table
                        :headers="customersHeaders"
                        :items="filteredCustomers"
                    >
                        <template v-slot:item.created_at="{ item }">
                            {{ new Date(item.created_at).toLocaleString('en-GB') }}
                        </template>
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
