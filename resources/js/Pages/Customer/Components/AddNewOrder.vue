<script setup>
import ProductsEnum from './ProductsEnum';
import {reactive, watch} from "vue";
import {router} from "@inertiajs/vue3";

const pricing = {
    'DERV': { threshold: 10000, low: 1.10, high: 1.05 },
    'IHO': { threshold: 10000, low: 0.70, high: 0.65 },
    'Kerosene': { threshold: 10000, low: 0.68, high: 0.63 },
    'Gas Oil': { threshold: 10000, low: 0.85, high: 0.80 },
    'AdBlue': { threshold: 10000, low: 0.35, high: 0.30 },
};

const emit = defineEmits(['close']);

const form = reactive({
    product_id: null,
    product_type: null,
    quantity: null,
    ppl_sell: null,
    ppl_cost: null,
    vat: null,
    nett_total: null,
    total: null,
    ppl_profit: null,
    total_profit: null,
})

// Calculate cost price based on quantity and product type
function calculateCostPrice() {
    if (!form.product_type || !form.quantity) return;

    const priceInfo = pricing[form.product_type];
    if (!priceInfo) return;

    // Set PPL cost based on quantity threshold
    form.ppl_cost = form.quantity >= priceInfo.threshold ?
        priceInfo.high :
        priceInfo.low;
}

// Watch for quantity changes to update pricing
watch(() => form.quantity, () => {
    calculateCostPrice();
    calculateTotals();
});

function calculateTotals() {
    form.nett_total = form.quantity * form.ppl_sell;
    form.vat = form.nett_total * 0.20;
    form.total = form.nett_total + form.vat;
    form.ppl_profit = form.ppl_sell - form.ppl_cost;
    form.total_profit = form.ppl_profit * form.quantity;
}

function onProductSelect(productId) {
    const product = props.products.find(p => p.id === productId);
    if (product) {
        form.product_type = product.type; // Assuming your products have a type field
        form.ppl_sell = product.selling_price;
        calculateCostPrice();
        calculateTotals();
    }
}

function submit() {
    router.post(route('orders.store', { prospect: props.prospect.id }), form, {
        onSuccess: () => {
            emit('close');
        }
    });
}
</script>

<template>
    <form @submit.prevent="submit">
        <v-card>
            <v-card-title class="bg-green-darken-1 d-flex justify-space-between align-center">
                Add New Order
            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col md="6">
                        <v-autocomplete
                            v-model="form.product_id"
                            :items="products"
                            item-title="name"
                            item-value="id"
                            label="Select Product"
                            @update:model-value="onProductSelect"
                        />
                    </v-col>
                    <v-col md="6">
                        <v-text-field
                            v-model.number="form.quantity"
                            type="number"
                            label="Quantity"
                            :hint="`Price breaks at ${pricing[form.product_type]?.threshold.toLocaleString()} litres`"
                            :persistent-hint="!!form.product_type"
                        />
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions>
                <v-btn
                    text="Cancel"
                    @click="close"
                ></v-btn>
                <v-spacer></v-spacer>
                <v-btn
                    text="Add Order"
                    @click="submit"
                ></v-btn>
            </v-card-actions>
        </v-card>
    </form>
</template>
