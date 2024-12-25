<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from '@inertiajs/vue3';
import ProspectTabs from "@/Pages/Prospects/Components/ProspectTabs.vue";

const props = defineProps({
    prospect: {
        type: Object,
        required: true
    }
})

const prospect_notes = 'prospect_notes';
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Notes" />
        <v-container fluid>
            <v-card class="mb-3 pa-2">
                <v-card-title class="bg-success d-flex justify-space-between align-center">
                    {{ prospect.company_name }}
                </v-card-title>
            </v-card>

            <ProspectTabs :prospect="prospect" :selected_tab="prospect_notes"/>


                <v-timeline align="start">
                    <v-timeline-item>
                        <template v-slot:opposite>
                            Opposite content
                        </template>
                        <div>
                            <div class="text-h6">Content title</div>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            </p>
                        </div>
                    </v-timeline-item>

                    <v-timeline-item>
                        <template v-slot:opposite>
                            Opposite content
                        </template>
                        <div>
                            <div class="text-h6">Content title</div>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            </p>
                        </div>
                    </v-timeline-item>

                    <v-timeline-item>
                        <template v-slot:opposite>
                            Opposite content
                        </template>
                        <div>
                            <div class="text-h6">Content title</div>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            </p>
                        </div>
                    </v-timeline-item>
                </v-timeline>

        </v-container>
    </AuthenticatedLayout>
</template>
