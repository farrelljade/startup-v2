<script setup>
import {ref} from 'vue';
import {useForm} from '@inertiajs/vue3';

const props = defineProps({
    prospect: {
        type: Object,
        required: true
    }
})

const loading = ref(false);

const emit = defineEmits(['close']);

const form = useForm({
    prospect_id: props.prospect.id,
    note: null
})

const submit = () => {
    loading.value = true;
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
        <v-card>
            <v-card-title class="bg-success d-flex justify-space-between align-center">
                Add Note
            </v-card-title>
            <v-card-text>
                <v-textarea
                    v-model="form.note"
                    label="Note"
                    outlined
                    rows="5"
                ></v-textarea>
            </v-card-text>

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
                    :loading="loading"
                ></v-btn>
            </v-card-actions>
        </v-card>
    </form>
</template>
