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

const emit = defineEmits(['close']);

const form = useForm({
    status: null
})

const statuses = computed(() => {
    return [
    'Requested',
    'In Progress',
    'Completed',
    ]
})

console.log('Prospect:', props.prospect);

const updateForm = () => {
    form.patch(route('tank-sales.update', {
        prospect: props.prospect.id,
        tankSale: props.tankSale.id
    }), {
        onSuccess: () => {
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
                        <v-autocomplete
                            v-model="form.status"
                            :items="statuses"
                            label="Status"
                            variant="underlined"
                            clearable
                            :error-messages="form.errors.status"
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
