<script setup>
import {ref} from 'vue';
import {useForm} from '@inertiajs/vue3';
import DatePicker from "@/Components/DatePicker.vue";

const props = defineProps({
    prospect: {
        type: Object,
        required: true
    }
})

const emit = defineEmits(['close']);

const form = useForm({
    prospect_id: props.prospect.id,
    note: null,
    next_contact_date: null
})

const submit = () => {
    form.post(route('notes.store', { prospect: props.prospect.id }), {
        onSuccess: () => {
            form.reset();
            emit('noteSuccess');
            emit('close');
        }
    });
}
</script>

<template>
    <form @submit.prevent="submit">
        <v-card class="pa-1">
            <v-card-title class="bg-success d-flex justify-space-between align-center">
                Add Note

                <v-btn
                    variant="text"
                    icon="mdi-close-circle"
                    @click="emit('close')"
                />
            </v-card-title>
            <v-card-text>
                <v-textarea
                    v-model="form.note"
                    label="Note"
                    outlined
                    rows="5"
                    :error-messages="form.errors.note"
                ></v-textarea>
            </v-card-text>

            <v-col cols="12">
                <date-picker
                    :label="'Next Contact Date'"
                    :input-date="form.next_contact_date"
                    @date-updated="form.next_contact_date = $event"
                    :error-messages="form.errors.next_contact_date"
                />
            </v-col>

            <v-card-actions>
                <v-btn
                    variant="tonal"
                    color="error"
                    text="Cancel"
                    @click="emit('close')"
                ></v-btn>
                <v-spacer></v-spacer>
                <v-btn
                    variant="tonal"
                    color="success"
                    text="Add Note"
                    @click="submit"
                    :loading="form.processing"
                ></v-btn>
            </v-card-actions>
        </v-card>
    </form>
</template>
