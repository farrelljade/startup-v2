<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router} from "@inertiajs/vue3";
import DatePicker from "@/Components/DatePicker.vue";
import {ref} from "vue";
import {getData} from "@/helpers/helpers.js";

const props = defineProps({
    orders: {
        type: Array,
        required: true
    },
    products: {
        type: Array,
        required: true
    }
})

const orderNumber = ref(null);
const product = ref(null);
const orderFrom = ref(null);
const orderTo = ref(null);

const filteredOrders = ref(props.orders);

const ordersHeaders = [
    { title: 'Order Number', key: 'order_number' },
    { title: 'Company Name', key: 'customer.company_name' },
    { title: 'Product', key: 'product.name' },
    { title: 'Quantity', key: 'quantity' },
    { title: 'PPL Sell', key: 'ppl_sell' },
    { title: 'Total', key: 'total' },
    { title: 'Created At', key: 'created_at' },
    { title: 'Actions', key: 'actions' }
];

const resetFilters = () => {
    orderNumber.value = null;
    product.value = null;
    orderFrom.value = null;
    orderTo.value = null;
    searchOrders();
}
const searchOrders = async () => {
    const params = {
        order_number: orderNumber.value,
        product: product.value,
        order_from: orderFrom.value,
        order_to: orderTo.value
    };

    await getData(route('orders.search'), params, (response) => {
        filteredOrders.value = response.data;
    });
}

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
                            <v-text-field
                                v-model="orderNumber"
                                variant="underlined"
                                label="Order Number"
                                @input="searchOrders"
                            />
                        </v-col>
                        <v-col cols="12" sm="3">
                            <v-autocomplete
                                v-model="product"
                                :items="products"
                                item-value="id"
                                item-title="name"
                                variant="underlined"
                                label="Product"
                                @update:model-value="searchOrders"
                            />
                        </v-col>
                        <v-col cols="12" sm="3">
                            <date-picker
                                :label="'Date From'"
                                :input-date="orderFrom"
                                @date-updated="orderFrom = $event"
                            />
                        </v-col>
                        <v-col cols="12" sm="3">
                            <date-picker
                                :label="'Date To'"
                                :input-date="orderTo"
                                @date-updated="orderTo = $event"
                            />
                        </v-col>
                        <v-spacer/>
                        <v-card-actions>
                            <v-btn
                                variant="tonal"
                                class="mr-2"
                                @click="resetFilters"
                            >
                                Reset Filters
                            </v-btn>
                            <v-btn
                                variant="tonal"
                                class="bg-success"
                                @click="searchOrders"
                            >
                                Search
                            </v-btn>
                        </v-card-actions>
                    </v-row>
                </v-card-text>
            </v-card>

            <v-card>
                <v-card-text>
                    <v-data-table
                        :headers="ordersHeaders"
                        :items="filteredOrders"
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
