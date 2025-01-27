<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, usePage} from '@inertiajs/vue3';
import ProspectTabs from "@/Pages/Prospects/Components/ProspectTabs.vue";
import {computed, reactive, ref} from "vue";
import {logPhoneViewedAt, updateRecord, userHasPermission} from "@/helpers/helpers.js";
import AddNewOrder from "@/Pages/Customer/Components/AddNewOrder.vue";

const addOrderDialog = ref(false);
const showOrderDialog = ref(false);
const selectedOrder = ref(null);

const page = usePage()

const props = defineProps({
    prospect: {
        type: Object,
        required: true
    },
    products: {
        type: Array,
        required: true
    },
    orders: {
        type: Array,
        required: true
    }
})

const ordersHeaders = [
    { title: 'Order ID', key: 'order_number' },
    { title: 'Product', key: 'product.name' },
    { title: 'Quantity', key: 'quantity' },
    { title: 'Total', key: 'total' },
    { title: 'Actions', key: 'actions' }
]

const showOrderHeaders = [
    { title: 'Order ID', key: 'order_number' },
    { title: 'Product', key: 'product.name' },
    { title: 'Quantity', key: 'quantity' },
    { title: 'PPL Sell', key: 'ppl_sell' },
    { title: 'PPL Cost', key: 'ppl_cost'},
    { title: 'Nett Total', key: 'nett_total' },
    { title: 'VAT', key: 'vat' },
    { title: 'Total', key: 'total' },
    { title: 'PPL Profit', key: 'ppl_profit' },
    { title: 'Total Profit', key: 'total_profit' },
]

const snackbar = ref(false);
const snackbarMessage = ref('');

const showNumber = ref(false);

const form = reactive({
    phone: props.prospect.phone
})

const user = computed(() => page.props.auth.user);

const closeDialog = () => {
    addOrderDialog.value = false;
}

const toggleNumber = () => {
    showNumber.value = !showNumber.value;

    logPhoneViewedAt(
        props.prospect.id,
        showNumber.value,
        'prospects.update',
        'phone_viewed_at'
    )
}

function handleOrderSuccess() {
    snackbar.value = true;
    snackbarMessage.value = 'Order created successfully!';
}

function showOrder(order) {
    selectedOrder.value = order;
    showOrderDialog.value = true;
}

const selected_tab = 'prospect_enquiry';
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Profile" />
        <v-container fluid>
            <v-card class="mb-3 pa-1">
                <v-card-title class="bg-green-darken-1 d-flex justify-space-between align-center">
                    {{ prospect.company_name }}
                </v-card-title>
            </v-card>

            <ProspectTabs :prospect="prospect" :selected_tab="selected_tab"/>

            <v-row>
                <v-col cols="12" md="6">
                    <v-card class="pa-1">
                        <v-card-title class="bg-green-lighten-1 d-flex justify-space-between align-center">
                            Details
                        </v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col md="6">
                                    <v-text-field
                                        v-model="prospect.company_name"
                                        label="Company Name"
                                        readonly
                                    />
                                </v-col>
                                <v-col md="6">
                                    <v-text-field
                                        v-model="prospect.user.name"
                                        label="Account Manager"
                                        readonly
                                    />
                                </v-col>
                                <v-col md="6">
                                    <v-text-field
                                        v-model="prospect.line_1"
                                        label="Address Line 1"
                                        readonly
                                    />
                                </v-col>
                                <v-col v-if="prospect.line_2" md="6">
                                    <v-text-field
                                        v-model="prospect.line_2"
                                        label="Address Line 2"
                                        readonly
                                    />
                                </v-col>
                                <v-col v-if="prospect.line_3" md="6">
                                    <v-text-field
                                        v-model="prospect.line_3"
                                        label="Address Line 3"
                                        readonly
                                    />
                                </v-col>
                                <v-col v-if="prospect.city" md="6">
                                    <v-text-field
                                        v-model="prospect.city"
                                        label="City"
                                        readonly
                                    />
                                </v-col>
                                <v-col v-if="prospect.county" md="6">
                                    <v-text-field
                                        v-model="prospect.county"
                                        label="County"
                                        readonly
                                    />
                                </v-col>
                                <v-col md="6">
                                    <v-text-field
                                        v-model="form.phone"
                                        variant="underlined"
                                        :type="showNumber ? 'text' : 'password'"
                                        :append-inner-icon="form.phone ? (showNumber ? 'mdi-eye' : 'mdi-eye-off') : ''"
                                        @click:append-inner="toggleNumber"
                                        label="Phone"
                                        @change="updateRecord(route('prospects.update', prospect.id), 'phone', form.phone)"
                                        :readonly="!userHasPermission(user, 'Update Prospect')"
                                    />
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-col>

                <v-col cols="12" md="6">
                    <v-card class="pa-1">
                        <v-card-title class="bg-green-lighten-1 d-flex justify-space-between align-center mb-4">
                            Orders

                            <v-btn
                                density="compact"
                                @click="addOrderDialog = true"
                            >
                                New Order
                            </v-btn>
                        </v-card-title>
                        <v-card-text>
                            <v-data-table
                                :headers="ordersHeaders"
                                :items="orders"
                                :items-per-page="5"
                                class="elevation-3"
                            >
                                <template v-slot:item.quantity="{ item }">
                                    {{ item.quantity.toLocaleString() }}
                                </template>
                                <template v-slot:item.total="{ item }">
                                    £{{ item.total.toLocaleString() }}
                                </template>
                                <template v-slot:item.actions="{ item }">
                                    <v-btn
                                        variant="text"
                                        color="warning"
                                        icon="mdi-eye"
                                        @click="showOrder(item)"
                                    >
                                    </v-btn>
                                </template>
                            </v-data-table>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>

            <v-dialog
                v-model="addOrderDialog"
                width="60vw"
                persistent
            >
                <AddNewOrder
                    :prospectId="prospect.id"
                    :products="products"
                    @close="closeDialog"
                    @orderSuccess="handleOrderSuccess"
                />
            </v-dialog>

            <v-dialog
                v-model="showOrderDialog"
                max-width="1100"
            >
                <v-card v-if="selectedOrder">
                    <v-card-title class="bg-green-darken-1">
                        Order Details
                    </v-card-title>
                    <v-data-table
                        :headers="showOrderHeaders"
                        :items="[selectedOrder]"
                        class="elevation-3"
                    >
                        <template v-slot:item.order_number="{ item }">
                            {{ item.order_number }}
                        </template>

                    </v-data-table>
                </v-card>

            </v-dialog>

            <v-snackbar
                v-model="snackbar"
                :timeout="3000"
                color="success"
            >
                {{ snackbarMessage }}
            </v-snackbar>
        </v-container>
    </AuthenticatedLayout>
</template>
