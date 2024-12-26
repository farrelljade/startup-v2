<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from '@inertiajs/vue3';
import ProspectTabs from "@/Pages/Prospects/Components/ProspectTabs.vue";
import AddProspectNote from "@/Pages/Prospects/Components/AddProspectNote.vue";
import {ref} from "vue";

const addNoteDialog = ref(false);

const props = defineProps({
    prospect: {
        type: Object,
        required: true
    }
})

console.log(props.prospect);

function closeDialog() {
    addNoteDialog.value = false;
}

const prospect_notes = 'prospect_notes';
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Notes" />
        <v-container fluid>
            <v-card class="mb-3 pa-2">
                <v-card-title class="bg-success d-flex justify-space-between align-center">
                    {{ prospect.company_name }}

                    <v-tooltip text="New Order">
                        <template v-slot:activator="{ props }">
                            <v-btn
                                density="compact"
                                color="success"
                                icon="mdi-plus"
                                :="props"
                                @click="addNoteDialog = true"
                            >
                            </v-btn>
                        </template>
                    </v-tooltip>
                </v-card-title>
            </v-card>

            <ProspectTabs :prospect="prospect" :selected_tab="prospect_notes"/>

            <v-card>
                <v-timeline>
                    <v-timeline-item
                        v-for="note in prospect.notes"
                        :key="note.id"
                        dot-color="info"
                        icon="mdi-note-text"
                        elevation="2"

                    >
                        <v-card elevation="2" class="pa-2">
                            <v-card-title class="bg-info">
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
        >
            <AddProspectNote
                :prospect="prospect"
                @close="closeDialog"
            />
        </v-dialog>
    </AuthenticatedLayout>
</template>
