<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, usePage} from '@inertiajs/vue3';
import ProspectTabs from "@/Pages/Prospects/Components/ProspectTabs.vue";
import {computed, reactive, ref} from "vue";
import {updateProspect, userHasPermission} from "@/helpers/helpers.js";
import AddNewOrder from "@/Pages/Customer/Components/AddNewOrder.vue";

const addOrderDialog = ref(false);

function closeDialog() {
    addOrderDialog.value = false;
}

const page = usePage()
const user = computed(() => page.props.auth.user)

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
    { title: 'Order ID', key: 'order_number', align: 'start' },
    { title: 'Product', key: 'product.name', align: 'start' },
    { title: 'Quantity', key: 'quantity', align: 'end' },
    { title: 'Total', key: 'total', align: 'end' },
    { title: 'Actions', key: 'actions', align: 'center' }
]

const snackbar = ref(false);
const snackbarMessage = ref('');

const form = reactive({
    phone: props.prospect.phone
})

function handleUpdate() {
    updateProspect(props.prospect.id, form, () => {
        snackbar.value = true;
        snackbarMessage.value = 'Updated successfully!';
    });
}

function handleOrderSuccess() {
    snackbar.value = true;
    snackbarMessage.value = 'Order created successfully!';
}

const selected_tab = 'prospect_enquiry';
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Profile" />
        <v-container fluid>
            <v-card class="mb-3 pa-2">
                <v-card-title class="bg-green-darken-1 d-flex justify-space-between align-center">
                    {{ prospect.company_name }}
                </v-card-title>
            </v-card>

            <ProspectTabs :prospect="prospect" :selected_tab="selected_tab"/>

            <v-row>
                <v-col cols="12" md="6">
                    <v-card>
                        <v-card-title class="bg-green-darken-1 d-flex justify-space-between align-center">
                            Details

                            <v-tooltip text="New Order">
                                <template v-slot:activator="{ props }">
                                    <v-btn
                                        density="compact"
                                        color="green-darken-1"
                                        icon="mdi-plus"
                                        :="props"
                                        @click="addOrderDialog = true"
                                    >
                                    </v-btn>
                                </template>
                            </v-tooltip>
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
                                        label="Phone"
                                        @change="handleUpdate"
                                        :readonly="!userHasPermission(user, 'Update Prospect')"
                                    />
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-col>

                <v-col cols="12" md="6">
                    <v-card>
                        <v-card-title class="bg-green-darken-1 d-flex justify-space-between align-center">
                            Orders
                        </v-card-title>
                        <v-card-text>
                            <v-data-table
                                :headers="ordersHeaders"
                                :items="orders"
                                :items-per-page="5"
                                class="elevation-3"
                            >
                            </v-data-table>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>

            <v-dialog
                v-model="addOrderDialog"
                max-width="auto"
            >
                <AddNewOrder
                    :prospectId="prospect.id"
                    :products="products"
                    @close="closeDialog"
                    @order-success="handleOrderSuccess"
                />
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
