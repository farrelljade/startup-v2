<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
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
    { title: 'Quantity', key: 'quantity' },
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
