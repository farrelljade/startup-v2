<script setup>
import { reactive } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    prospect: {
        type: Object,
        required: true
    }
})

const emit = defineEmits(['close']);

const form = reactive({
    prospect_id: props.prospect.id,
    note: null
})

function submit() {
    router.post(route('notes.store', { prospect: props.prospect.id }),
        form,
        {
            onSuccess: () => {
                form.note = null;
                emit('close');
            }
        }
    );
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
                <v-spacer></v-spacer>

                <v-btn
                    text="Add Note"
                    @click="submit"
                ></v-btn>
            </v-card-actions>
        </v-card>
    </form>
</template>
