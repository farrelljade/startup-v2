<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {format} from "date-fns";
import AddProspectNote from "@/Pages/Prospects/Components/AddProspectNote.vue";
import {ref} from "vue";

const snackbar = ref(false);
const snackbarMessage = ref('');

const props = defineProps({
    notes: {
        type: Array
    }
})

const addNoteDialog = ref(false);
const selectedProspect = ref(null);

const openDialog = (prospect) => {
    selectedProspect.value = prospect;
    addNoteDialog.value = true;
};

const closeDialog = () => {
    addNoteDialog.value = false;
    selectedProspect.value = null;
}

const handleNoteSuccess = () => {
    snackbarMessage.value = 'Note added successfully!';
    snackbar.value = true;
}

const formatDate = (date) => {
    return format(new Date(date), 'MMMM d, yyyy')
}

const avatarColors = ['blue-lighten-1', 'green-lighten-1', 'purple-lighten-1', 'orange-lighten-1'];

const getAvatarColor = (prospect) => {
    return avatarColors[prospect.id % avatarColors.length];
}
</script>

<template>
    <authenticated-layout>
        <v-container fluid>
            <v-card class="mb-3 pa-1">
                <v-card-title class="bg-green-darken-1">
                    Calendar
                </v-card-title>
                <v-list>

                    <template v-for="note in notes" :key="note.id">
                        <v-list-subheader>
                            {{ formatDate(note.next_contact_date) }}
                        </v-list-subheader>

                        <v-list-item
                            :title="note.prospect.company_name"
                            :subtitle="note.note"
                        >
                            <template v-slot:prepend>
                                <v-avatar :color="getAvatarColor(note.prospect)">
                                    {{ note.prospect.company_name[0] }}
                                </v-avatar>
                            </template>

                            <template v-slot:append>
                                <v-btn icon="mdi-phone" variant="text"></v-btn>
                                <v-btn icon="mdi-check" variant="text" color="success" @click=openDialog(note.prospect)></v-btn>
                            </template>
                        </v-list-item>

                        <v-divider thickness="3"></v-divider>
                    </template>
                </v-list>
            </v-card>
        </v-container>

        <v-dialog
            v-model="addNoteDialog"
            max-width="600"
            persistent
        >
            <AddProspectNote
                v-if="selectedProspect"
                :prospect="selectedProspect"
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
    </authenticated-layout>
</template>
