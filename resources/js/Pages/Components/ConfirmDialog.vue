<script setup>

import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    note: {
        type: Object,
        required: true
    },
    prospect: {
        type: Object,
        required: true
    },
    routeName: {
        type: String,
        required: true
    },
    title: {
        type: String,
        default: 'Confirm'
    },
    text: {
        type: String,
        default: 'Mark Contact as Complete'
    }
})
console.log(props.prospect);

const emit = defineEmits(['close']);

const form = useForm({
    note_id: props.note.id,
    note_complete: true
})

const submit = () => {
    form.patch(route(props.routeName, { note: props.note.id }), {
        onSuccess: () => {
            emit('close');
            window.location.reload();
        }
    })
}
</script>

<template>
    <form @submit.prevent="submit">
        <v-card class="pa-1">
            <v-card-title class="bg-success d-flex justify-space-between align-center">
                {{ title }}

                <v-btn
                    variant="text"
                    icon="mdi-close-circle"
                    @click="emit('close')"
                />
            </v-card-title>

            <v-card-text class="d-flex justify-center">
                {{ text }}
            </v-card-text>
            <v-divider/>

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
                    text="Confirm"
                    @click="submit"
                    :loading="form.processing"
                ></v-btn>
            </v-card-actions>
        </v-card>
    </form>
</template>
