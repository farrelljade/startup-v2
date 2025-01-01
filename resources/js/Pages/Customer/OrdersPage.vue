<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router} from "@inertiajs/vue3";
import {ref} from "vue";
import AddNewOrder from "@/Pages/Customer/Components/AddNewOrder.vue";

const addOrderDialog = ref(false);

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

function closeDialog() {
    addOrderDialog.value = false;
}
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Orders" />

        <v-container fluid>
            <v-card class="mb-3 pa-3">
                <v-card-title class="bg-green-darken-1 d-flex justify-space-between align-center">
                    Orders Page

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
                                @click="router.visit(route('company.profile', item.id ))"
                            />
                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card>
        </v-container>

        <v-dialog
            v-model="addOrderDialog"
            max-width="auto"
        >
            <AddNewOrder
                :prospectId="prospect.id"
                :products="products"
                @close="closeDialog"
            />
        </v-dialog>
    </AuthenticatedLayout>
</template>
