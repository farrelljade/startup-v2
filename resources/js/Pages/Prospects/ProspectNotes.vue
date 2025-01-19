<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from '@inertiajs/vue3';
import ProspectTabs from "@/Pages/Prospects/Components/ProspectTabs.vue";
import AddProspectNote from "@/Pages/Prospects/Components/AddProspectNote.vue";
import {ref} from "vue";

const snackbar = ref(false);
const snackbarMessage = ref('');

const addNoteDialog = ref(false);

const props = defineProps({
    prospect: {
        type: Object,
        required: true
    }
})

const closeDialog = () => {
    addNoteDialog.value = false;
}

const handleNoteSuccess = () => {
    snackbarMessage.value = 'Note added successfully!';
    snackbar.value = true;
}

const prospect_notes = 'prospect_notes';
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Notes" />
        <v-container fluid>
            <v-card class="mb-3 pa-1">
                <v-card-title class="bg-green-darken-1">
                    {{ prospect.company_name }}

                    <v-btn
                        size="small"
                        class="float-right"
                        variant="elevated"
                        @click="addNoteDialog = true"
                    >New Note
                    </v-btn>
                </v-card-title>
            </v-card>

            <ProspectTabs :prospect="prospect" :selected_tab="prospect_notes"/>

            <v-card>
                <v-timeline density="comfortable" align="start">
                    <v-timeline-item
                        v-for="note in prospect.notes"
                        :key="note.id"
                        dot-color="green-darken-1"
                        icon="mdi-note-text"
                        elevation="2"
                    >
                        <v-card elevation="2" class="pa-1" variant="text">
                            <v-card-title class="bg-green-darken-1">
                                {{ note.user.name }} @ {{ new Date(note.created_at).toLocaleString('gb') }}
                            </v-card-title>
                            <v-card-text elevation="2" class="pa-2">
                                {{ note.note }}
                            </v-card-text>
                        </v-card>
                    </v-timeline-item>
                </v-timeline>
            </v-card>
        </v-container>

        <v-dialog
            v-model="addNoteDialog"
            max-width="600"
            persistent
        >
            <AddProspectNote
                :prospect="prospect"
                @close="closeDialog"
                @noteSuccess="handleNoteSuccess"
            />
        </v-dialog>

        <v-snackbar
            v-model="snackbar"
            :timeout="3000"
            color="success"
        >
            {{ snackbarMessage }}
        </v-snackbar>
    </AuthenticatedLayout>
</template>
