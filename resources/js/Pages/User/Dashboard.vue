<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router, usePage} from '@inertiajs/vue3';
import {computed, ref} from 'vue';
import CustomerList from "@/Pages/Customer/Components/CustomerList.vue";
import SheetInformation from "@/Pages/User/Components/SheetInformation.vue";

const tab = ref('customers');

const showOrderDialog = ref(false);
const selectedOrder = ref(null);

const props = defineProps({
    prospects: {
        type: Array,
        required: true
    },
    customers: {
        type: Array,
        required: true
    },
    userProfitThisMonth: {
        type: Number,
        required: true
    },
    prospectsToCustomers: {
        type: Array,
        required: true
    },
    userTargets: {
        type: Array,
        required: true
    },
    userOrders: {
        type: Array,
        required: true
    }
});

const prospectHeaders = [
    {title: 'Company Name', key: 'company_name', sortable: false},
    {title: 'Email', key: 'email', sortable: false},
    {title: 'Actions', key: 'actions', sortable: false},
]

const recentOrderHeaders = [
    {title: 'Company Name', key: 'customer.company_name', sortable: false},
    {title: 'Total', key: 'total', sortable: false},
    {title: 'Order Date', key: 'created_at', sortable: false},
    {title: 'Actions', key: 'actions', sortable: false}
]

function showOrder(order) {
    selectedOrder.value = order;
    showOrderDialog.value = true;
}

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <Head title="Home" />
        <v-container fluid>
            <v-row>
                <v-col cols="12">
                    <v-card>
                        <SheetInformation
                            :userProfitThisMonth="userProfitThisMonth"
                            :prospectsToCustomers="prospectsToCustomers"
                            :userTargets="userTargets"
                        />
                    </v-card>
                </v-col>
            </v-row>

            <v-row>
                <v-col cols="12" md="6">
                    <v-card class="pa-1">
                        <v-tabs
                            v-model="tab"
                            bg-color="success"
                        >
                            <v-tab value="customers">Customers</v-tab>
                            <v-tab value="prospects">Prospects</v-tab>
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
                    <v-card class="pa-1">
                        <v-card-title class="bg-green-darken-1">
                            Recent Orders
                        </v-card-title>
                        <v-card-text>
                            <v-data-table
                                :headers="recentOrderHeaders"
                                :items="userOrders"
                                :items-per-page="5"
                            >
                                <template v-slot:item.total="{ item }">
                                    £{{ item.total.toLocaleString() }}
                                </template>
                                <template v-slot:item.created_at="{ item }">
                                    {{ new Date(item.created_at).toLocaleDateString() }}
                                </template>
                                <template v-slot:item.actions="{ item }">
                                    <v-tooltip text="View Order">
                                        <template v-slot:activator="{ props }">
                                            <v-btn
                                                variant="text"
                                                icon="mdi-eye"
                                                color="warning"
                                                :="props"
                                                @click="showOrder(item)"
                                            />
                                        </template>
                                    </v-tooltip>
                                </template>
                            </v-data-table>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>

            <v-dialog
                v-model="showOrderDialog"
                width="60vw"
            >
                <v-card v-if="selectedOrder">
                    <v-card-title class="bg-green-darken-1">
                        Order Details
                    </v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col cols="6" md="2">
                                <v-text-field
                                    v-model="selectedOrder.order_number"
                                    label="Order ID"
                                    readonly
                                    variant="underlined"
                                />
                            </v-col>
                            <v-col cols="6" md="2">
                                <v-text-field
                                    v-model="selectedOrder.product.name"
                                    label="Product"
                                    readonly
                                    variant="underlined"
                                />
                            </v-col>
                            <v-col cols="6" md="2">
                                <v-text-field
                                    v-model="selectedOrder.quantity"
                                    label="Quantity"
                                    readonly
                                    variant="underlined"
                                />
                            </v-col>
                            <v-col cols="6" md="2">
                                <v-text-field
                                    v-model="selectedOrder.ppl_sell"
                                    label="PPL Sell"
                                    readonly
                                    variant="underlined"
                                    prefix="£"
                                />
                            </v-col>
                            <v-col cols="6" md="2">
                                <v-text-field
                                    v-model="selectedOrder.ppl_cost"
                                    label="PPL Cost"
                                    readonly
                                    variant="underlined"
                                    prefix="£"
                                />
                            </v-col>
                            <v-col cols="6" md="2">
                                <v-text-field
                                    v-model="selectedOrder.nett_total"
                                    label="Nett Total"
                                    readonly
                                    variant="underlined"
                                    prefix="£"
                                />
                            </v-col>
                            <v-col cols="6" md="2">
                                <v-text-field
                                    v-model="selectedOrder.vat"
                                    label="VAT"
                                    readonly
                                    variant="underlined"
                                    prefix="£"
                                />
                            </v-col>
                            <v-col cols="6" md="2">
                                <v-text-field
                                    v-model="selectedOrder.total"
                                    label="Total"
                                    readonly
                                    variant="underlined"
                                    prefix="£"
                                />
                            </v-col>
                            <v-col cols="6" md="2">
                                <v-text-field
                                    v-model="selectedOrder.ppl_profit"
                                    label="PPL Profit"
                                    readonly
                                    variant="underlined"
                                    prefix="£"
                                />
                            </v-col>
                            <v-col cols="6" md="2">
                                <v-text-field
                                    v-model="selectedOrder.total_profit"
                                    label="Total Profit"
                                    readonly
                                    variant="underlined"
                                    prefix="£"
                                />
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer/>
                        <v-btn
                            variant="tonal"
                            color="error"
                            @click="showOrderDialog = false"
                        >
                            Close
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-container>
    </AuthenticatedLayout>
</template>
