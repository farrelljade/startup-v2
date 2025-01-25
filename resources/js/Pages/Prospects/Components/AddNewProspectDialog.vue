<script setup>

import {useForm} from "@inertiajs/vue3";
import {computed} from "vue";

const props = defineProps({
    users: {
        type: Object,
        required: true
    },
    leadSource: {
        type: Object,
        required: true
    }
})

const emit = defineEmits(['close', 'success']);

const form = useForm({
    user_id: null,
    company_name: null,
    email: null,
    lead_source_id: null,
    contact_name: null,
    contact_role: null,
    phone: null,
    line_1: null,
    line_2: null,
    line_3: null,
    city: null,
    county: null,
    postal_code: null,
    status: 'prospect'
})

const leadSourceItems = computed(() => {
    return props.leadSource.map(item => ({
        id: item.id,
        name: item.name
    }))
})

const contactRoles = computed(() => {
    return [
        'Owner',
        'Site Contact',
        'Engineer',
        'Driver'
    ]
})

const submit = () => {
    form.post(route('prospects.store'), {
        preserveScroll: true,
        onSuccess: () => {
            emit('success');
            emit('close');
        }
    })
}
</script>

<template>
    <form @submit.prevent="submit">
        <v-card class="pa-1">
            <v-card-title class="bg-green-darken-1 d-flex justify-space-between align-center">
                Add New Prospect

                <v-btn
                    variant="text"
                    icon="mdi-close-circle"
                    @click="emit('close')"
                />
            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col cols="12" sm="6">
                        <v-autocomplete
                            v-model="form.user_id"
                            :items="users"
                            item-title="name"
                            item-value="id"
                            label="Account Manager"
                            variant="underlined"
                            :error-messages="form.errors.user_id"

                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="form.company_name"
                            label="Company Name"
                            variant="underlined"
                            :error-messages="form.errors.company_name"
                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="form.email"
                            label="Email"
                            variant="underlined"
                            :error-messages="form.errors.email"
                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-autocomplete
                            v-model="form.lead_source_id"
                            :items="leadSourceItems"
                            item-title="name"
                            item-value="id"
                            label="Lead Source"
                            variant="underlined"
                            :error-messages="form.errors.lead_source_id"
                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="form.contact_name"
                            label="Contact Name"
                            variant="underlined"
                            :error-messages="form.errors.contact_name"
                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-autocomplete
                            v-model="form.contact_role"
                            :items="contactRoles"
                            label="Contact Role"
                            variant="underlined"
                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="form.phone"
                            label="Phone"
                            variant="underlined"
                            :error-messages="form.errors.phone"
                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="form.line_1"
                            label="Line 1"
                            variant="underlined"
                            :error-messages="form.errors.line_1"
                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="form.line_2"
                            label="Line 2"
                            variant="underlined"
                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="form.line_3"
                            label="Line 3"
                            variant="underlined"
                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="form.city"
                            label="city"
                            variant="underlined"
                            :error-messages="form.errors.city"
                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="form.county"
                            label="County"
                            variant="underlined"
                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="form.postal_code"
                            label="Post Code"
                            variant="underlined"
                            :error-messages="form.errors.postal_code"
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
                    text="Create Prospect"
                    @click="submit"
                    :loading="form.processing"
                />
            </v-card-actions>
        </v-card>
    </form>
</template>
