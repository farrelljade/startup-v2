<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router} from "@inertiajs/vue3";
import DatePicker from "@/Components/DatePicker.vue";

const props = defineProps({
    orders: {
        type: Array,
        required: true
    }
})

const ordersHeaders = [
    { title: 'Order Number', key: 'order_number' },
    { title: 'Company Name', key: 'customer.company_name' },
    { title: 'Product', key: 'product.name' },
    { title: 'Quantity', key: 'quantity' },
    { title: 'PPL Sell', key: 'ppl_sell' },
    { title: 'Total', key: 'total' },
    { title: 'Created At', key: 'created_at' },
    { title: 'Actions', key: 'actions' }
]
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Orders" />

        <v-container fluid>
            <v-card class="mb-3 pa-1">
                <v-card-title class="bg-green-darken-1 d-flex justify-space-between align-center">
                    Orders Page
                </v-card-title>

                <v-card-text>
                    <v-row class="mt-2">
                        <v-col cols="12" sm="3">
                            <DatePicker :label="'Date From'"/>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>

            <v-card>
                <v-card-text>
                    <v-data-table
                        :headers="ordersHeaders"
                        :items="orders"
                    >
                        <template v-slot:item.total="{ item }">
                            £{{ item.total.toLocaleString() }}
                        </template>
                        <template v-slot:item.created_at="{ item }">
                            {{ new Date(item.created_at).toLocaleString('en-GB') }}
                        </template>
                        <template v-slot:item.actions="{ item }">
                            <v-btn
                                variant="text"
                                icon="mdi-location-enter"
                                color="warning"
                                @click="router.visit(route('company.profile', item.customer.prospect.id ))"
                            />
                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card>
        </v-container>
    </AuthenticatedLayout>
</template>
