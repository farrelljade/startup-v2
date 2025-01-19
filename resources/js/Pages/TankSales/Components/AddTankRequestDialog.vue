<script setup>

import {useForm, usePage} from "@inertiajs/vue3";
import {computed} from "vue";
import ProductsEnum from "@/enums/ProductsEnum.js";
import TankTypeEnum from "@/enums/TankTypeEnum.js";

const props = defineProps({
    prospect: {
        type: Object,
        required: true
    }
})

const emit = defineEmits(['close']);

const form = useForm({
    prospect_id: props.prospect.id,
    customer_id: props.prospect?.customer?.id,
    requested_by: usePage().props.auth.user.name,
    requested_by_email: usePage().props.auth.user.email,
    requested_at: new Date().toISOString(),
    contact_name: null,
    contact_email: null,
    contact_phone: null,
    requirement_urgent: null,
    timeline: null,
    fuel_type: null,
    tank_type: null,
    tank_type_other: null,
    tank_size: null,
    tank_location: null,
    additional_requirements: null,
    quotes: null,
})

const fuelTypes = computed(() => {
    return Object.values(ProductsEnum);
})

const tankTypes = computed(() => {
    return Object.values(TankTypeEnum);
})

const tankSizes = computed(() => {
    return [
        '500-999',
        '1000-2499',
        '2500-4999',
        '5000+'
    ]
})

const tankLocation = computed(() => {
    return [
        'New',
        'Existing'
    ]
})

const submit = () => {
    form.post(route('tank-sales.store', { prospect: props.prospect.id}), {
        onSuccess: () => {
            form.reset();
            emit('close');
        }
    });
}
</script>

<template>
    <form @submit.prevent="submit">
        <v-card>
            <v-card-title class="bg-green-darken-1">
                Add Tank Request
            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="form.contact_name"
                            label="Contact Name"
                            variant="underlined"
                            clearable
                            :error-messages="form.errors.contact_name"
                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="form.contact_email"
                            label="Contact Email"
                            variant="underlined"
                            clearable
                            :error-messages="form.errors.contact_email"
                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="form.contact_phone"
                            label="Contact Phone"
                            variant="underlined"
                            clearable
                            :error-messages="form.errors.contact_phone"
                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-checkbox
                            v-model="form.requirement_urgent"
                            label="Urgent Requirement"
                            color="green-darken-1"
                            hint="e.g. Is the tank leaking, damaged, or faulty?"
                            persistent-hint
                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="form.timeline"
                            label="Timeline"
                            variant="underlined"
                            clearable
                            :error-messages="form.errors.timeline"
                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-autocomplete
                            v-model="form.fuel_type"
                            :items="fuelTypes"
                            label="Fuel Type"
                            variant="underlined"
                            clearable
                            :error-messages="form.errors.fuel_type"
                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-autocomplete
                            v-model="form.tank_type"
                            :items="tankTypes"
                            label="Tank Type"
                            variant="underlined"
                            clearable
                            :error-messages="form.errors.tank_type"
                        />
                    </v-col>
                    <v-col v-if="form.tank_type === 'Other'" cols="12" sm="6">
                        <v-text-field
                            v-model="form.tank_type_other"
                            label="Tank Type (Other)"
                            variant="underlined"
                            clearable
                            :error-messages="form.errors.tank_type_other"
                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-autocomplete
                            v-model="form.tank_size"
                            :items="tankSizes"
                            label="Tank Size"
                            variant="underlined"
                            clearable
                            :error-messages="form.errors.tank_size"
                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-autocomplete
                            v-model="form.tank_location"
                            :items="tankLocation"
                            label="Tank Location"
                            variant="underlined"
                            clearable
                            :error-messages="form.errors.tank_location"
                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="form.additional_requirements"
                            label="Additional Requirements"
                            variant="underlined"
                            clearable
                            :error-messages="form.errors.additional_requirements"
                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="form.quotes"
                            label="Other Quotes"
                            variant="underlined"
                            prefix="£"
                            clearable
                            :error-messages="form.errors.quotes"
                        />
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions>
                <v-btn
                    variant="tonal"
                    color="error"
                    text="Cancel"
                    @click="emit('close')"
                />
                <v-spacer/>
                <v-btn
                    variant="tonal"
                    color="success"
                    text="Submit Request"
                    @click="submit"
                    :loading="form.processing"
                />
            </v-card-actions>
        </v-card>
    </form>
</template>
