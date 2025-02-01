<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router} from "@inertiajs/vue3";
import {computed, ref} from "vue";
import {getData} from "@/helpers/helpers.js";

const props = defineProps({
    customers: {
        type: Array,
        required: true
    },
    users: {
        type: Array,
        required: true
    }
})

const companyName = ref(null);
const userId = ref(null);

const filteredCustomers = ref(props.customers);

const customerItems = computed(() => {
    return props.customers.map(customer => customer.company_name);
});

const customersHeaders = [
    {title: 'Company Name', key: 'company_name', sortable: false},
    {title: 'Phone', key: 'phone', sortable: false},
    {title: 'Email', key: 'email', sortable: false},
    {title: 'Account Manager', key: 'user.name', sortable: false},
    {title: 'Created At', key: 'created_at', sortable: false},
    {title: 'Actions', key: 'actions', sortable: false},
]

const searchCustomers = async () => {
    const params = {
        company_name: companyName.value,
        user_id: userId.value
    };

    await getData(route('customers.search'), params, (response) => {
        filteredCustomers.value = response.data;
    });
}
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
                                v-model="companyName"
                                :items="customerItems"
                                variant="underlined"
                                label="Search Company"
                                @update:model-value="searchCustomers"
                                clearable
                            />
                        </v-col>
                        <v-col cols="12" md="3">
                            <v-autocomplete
                                v-model="userId"
                                :items="users"
                                item-value="id"
                                item-title="name"
                                variant="underlined"
                                label="Users"
                                @update:model-value="searchCustomers"
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
                                @click="router.visit(route('company.profile', item.prospect.id ))"
                            />
                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card>
        </v-container>
    </AuthenticatedLayout>
</template>
