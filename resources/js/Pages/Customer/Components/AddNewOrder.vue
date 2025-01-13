<script setup>
import {watch} from "vue";
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    prospectId: {
        type: [Number, String],
        required: true
    },
    products: {
        type: Array,
        required: true
    }
});

const productItems = props.products.map(product => ({
    id: product.id,
    name: product.name
}));

const pricing = {
    'DERV': { threshold: 10000, low: 1.10, high: 1.05 },
    'IHO': { threshold: 10000, low: 0.70, high: 0.65 },
    'Kerosene': { threshold: 10000, low: 0.68, high: 0.63 },
    'Gas Oil': { threshold: 10000, low: 0.85, high: 0.80 },
    'AdBlue': { threshold: 10000, low: 0.35, high: 0.30 },
};

const emit = defineEmits(['close']);

const form = useForm({
    product_id: null,
    product_type: null,
    quantity: 1,
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

watch(() => form.ppl_sell, () => {
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
    const selectedProduct = productItems.find(p => p.id === productId);
    if (selectedProduct) {
        form.product_type = selectedProduct.name;

        form.ppl_sell = pricing[selectedProduct.name].low;
        calculateCostPrice();
        calculateTotals();
    }
}

const submitForm = () => {
    form.post(route('orders.store', { prospect: props.prospectId }), {
        onSuccess: () => {
            emit('close');
            emit('orderSuccess');
        }
    });
}
</script>

<template>
    <form @submit.prevent="submitForm">
        <v-card>
            <v-card-title class="bg-green-darken-1 d-flex justify-space-between align-center">
                Add New Order
            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col md="4">
                        <v-autocomplete
                            v-model="form.product_id"
                            :items="productItems"
                            item-title="name"
                            item-value="id"
                            label="Select Product"
                            variant="underlined"
                            @update:model-value="onProductSelect"
                        />
                    </v-col>
                    <v-col md="4">
                        <v-text-field
                            v-model="form.quantity"
                            type="number"
                            label="Quantity"
                            variant="underlined"
                            :hint="`Price breaks at ${pricing[form.product_type]?.threshold.toLocaleString()} litres`"
                            :persistent-hint="!!form.product_type"
                        />
                    </v-col>
                    <v-col md="4">
                        <v-text-field
                            v-model="form.ppl_sell"
                            type="number"
                            label="PPL Sell"
                            variant="underlined"
                            prefix="£"
                            :hint="`Current price: £${form.ppl_cost?.toFixed(2)}`"
                            :persistent-hint="!!form.product_type"
                        />
                    </v-col>
                    <v-col md="4">
                        <v-text-field
                            :model-value="form.ppl_cost?.toFixed(2)"
                            type="number"
                            label="PPL Cost"
                            variant="underlined"
                            prefix="£"
                            readonly
                        />
                    </v-col>
                    <v-col md="4">
                        <v-text-field
                            :model-value="form.nett_total?.toFixed(2)"
                            type="number"
                            label="Nett Total"
                            variant="underlined"
                            prefix="£"
                            readonly
                        />
                    </v-col>
                    <v-col md="4">
                        <v-text-field
                            :model-value="form.vat?.toFixed(2)"
                            type="number"
                            label="VAT"
                            variant="underlined"
                            prefix="£"
                            readonly
                        />
                    </v-col>
                    <v-col md="4">
                        <v-text-field
                            :model-value="form.total?.toFixed(2)"
                            type="number"
                            label="Total"
                            variant="underlined"
                            prefix="£"
                            readonly
                        />
                    </v-col>
                    <v-col md="4">
                        <v-text-field
                            :model-value="form.ppl_profit?.toFixed(2)"
                            type="number"
                            label="PPL Profit"
                            variant="underlined"
                            prefix="£"
                            readonly
                        />
                    </v-col>
                    <v-col md="4">
                        <v-text-field
                            :model-value="form.total_profit?.toFixed(2)"
                            type="number"
                            label="Total Profit"
                            variant="underlined"
                            prefix="£"
                            readonly
                        />
                    </v-col>

                </v-row>
            </v-card-text>
            <v-card-actions>
                <v-btn
                    text="Cancel"
                    @click="emit('close')"
                ></v-btn>
                <v-spacer></v-spacer>
                <v-btn
                    text="Add Order"
                    @click="submitForm"
                ></v-btn>
            </v-card-actions>

            <v-snackbar
                v-model="snackbar"
                :timeout="3000"
                color="success"
            >
                {{ snackbarMessage }}
            </v-snackbar>
        </v-card>
    </form>
</template>
