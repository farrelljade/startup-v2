<script setup>

import {useForm} from "@inertiajs/vue3";
import {computed} from "vue";

const props = defineProps({
    prospect: {
        type: Object,
        required: true
    },
    tankSale: {
        type: Object,
        required: true
    }
})

const emit = defineEmits(['close', 'updateSuccess']);

const form = useForm({
    contact_name: props.tankSale.contact_name,
    status: props.tankSale.status,
    requirement_urgent: Number(props.tankSale.requirement_urgent) === 1,
})

const statuses = computed(() => {
    return [
    'Requested',
    'In Progress',
    'Completed',
    ]
})

const updateForm = () => {
    form.patch(route('tank-sales.update', {
        prospect: props.prospect.id,
        tankSale: props.tankSale.id
    }), {
        onSuccess: () => {
            emit('updateSuccess');
            emit('close');
        }
    });
}
</script>

<template>
    <form @submit.prevent="updateForm">
        <v-card>
            <v-card-title class="bg-green-darken-1">
                Update Tank Request
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
                        <v-autocomplete
                            v-model="form.status"
                            :items="statuses"
                            label="Status"
                            variant="underlined"
                            clearable
                            :error-messages="form.errors.status"
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
                    text="Update Request"
                    @click="updateForm"
                    :loading="form.processing"
                />
            </v-card-actions>
        </v-card>
    </form>
</template>
