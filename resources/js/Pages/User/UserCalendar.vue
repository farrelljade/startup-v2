<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {format} from "date-fns";
import AddProspectNote from "@/Pages/Prospects/Components/AddProspectNote.vue";
import ConfirmDialog from "@/Pages/Components/ConfirmDialog.vue";
import {ref} from "vue";
import DatePicker from "@/Components/DatePicker.vue";
import {getData} from "@/helpers/helpers.js";

const snackbar = ref(false);
const snackbarMessage = ref('');

const dateFrom = ref(null);
const dateTo = ref(null);

const props = defineProps({
    notes: {
        type: Array
    }
})

const addNoteDialog = ref(false);
const selectedProspect = ref(null);

const selectedNote = ref(null);
const confirmDialog = ref(false);

const filteredNotes = ref(props.notes);

const openDialog = (prospect) => {
    selectedProspect.value = prospect;
    addNoteDialog.value = true;
};
const closeDialog = () => {
    addNoteDialog.value = false;
    selectedProspect.value = null;
}

const openConfirmDialog = (note) => {
    selectedNote.value = note;
    confirmDialog.value = true;
};
const closeConfirmDialog = () => {
    confirmDialog.value = false;
    selectedProspect.value = null;
};

const handleNoteSuccess = () => {
    snackbarMessage.value = 'Note added successfully!';
    snackbar.value = true;
}

const formatDate = (date) => {
    return format(new Date(date), 'MMMM d, yyyy')
}

const resetFilters = () => {
    dateFrom.value = null;
    dateTo.value = null;
    searchCalendar();
}
const searchCalendar = async () => {
    const params = {
        date_from: dateFrom.value,
        date_to: dateTo.value
    };

    await getData(route('user-calendar.search'), params, (response) => {
        filteredNotes.value = response.data;
    })
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

                <v-card-text>
                    <v-row class="mt-2">
                        <v-col cols="12" sm="3">
                            <date-picker
                                :label="'From Date'"
                                :input-date="dateFrom"
                                @date-updated="dateFrom = $event"
                            />
                        </v-col>
                        <v-col cols="12" sm="3">
                            <date-picker
                                :label="'To Date'"
                                :input-date="dateTo"
                                @date-updated="dateTo = $event"
                            />
                        </v-col>
                        <v-spacer/>
                        <v-card-actions>
                            <v-btn
                                variant="tonal"
                                class="mr-2"
                                @click="resetFilters"
                            >
                                Reset Filters
                            </v-btn>
                            <v-btn
                                variant="tonal"
                                class="bg-success"
                                @click="searchCalendar"
                            >
                                Search
                            </v-btn>
                        </v-card-actions>
                    </v-row>
                </v-card-text>
                <v-list>
                    <template v-for="note in filteredNotes" :key="note.id">
                        <v-list-subheader>
                            {{ formatDate(note.next_contact_date) }}
                        </v-list-subheader>

                        <v-list-item
                            :title="note.prospect.company_name"
                            :subtitle="note.note"
                        >
                            <template v-slot:prepend>
                                <v-btn variant="flat">
                                    <v-avatar :color="getAvatarColor(note.prospect)">
                                        {{ note.prospect.company_name[0] }}
                                    </v-avatar>
                                </v-btn>
                            </template>

                            <template v-slot:append>
                                <v-tooltip text="Call Customer">
                                    <template v-slot:activator="{ props }">
                                        <v-btn icon="mdi-phone" variant="text" :="props"></v-btn>
                                    </template>
                                </v-tooltip>
                                <v-tooltip text="Add Note">
                                    <template v-slot:activator="{ props }">
                                        <v-btn icon="mdi-note-text" variant="text" :="props" color="info" @click=openDialog(note.prospect)></v-btn>
                                    </template>
                                </v-tooltip>
                                <v-tooltip text="Confirm Contact">
                                    <template v-slot:activator="{ props }">
                                        <v-btn icon="mdi-check" variant="text" :="props" color="success" @click=openConfirmDialog(note)></v-btn>
                                    </template>
                                </v-tooltip>
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

        <v-dialog
            v-model="confirmDialog"
            max-width="600"
            persistent
        >
            <confirm-dialog
                v-if="selectedNote"
                :note="selectedNote"
                :prospect="selectedNote.prospect"
                :routeName="'user-calendar.update'"
                @close="closeConfirmDialog"
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
