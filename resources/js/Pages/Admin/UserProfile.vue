<script setup>
import {computed, ref} from 'vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, usePage} from '@inertiajs/vue3';

const tab = ref('one');

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Profile" />
        <v-container fluid>
            <v-card>
                <v-card class="mb-3 pa-2">
                    <v-card-title class="bg-success d-flex justify-space-between align-center">
                        User Profile
                    </v-card-title>
                </v-card>

                <v-tabs
                    v-model="tab"
                    bg-color="primary"
                >
                    <v-tab value="one">Item One</v-tab>
                    <v-tab value="two">Item Two</v-tab>
                    <v-tab value="three">Item Three</v-tab>
                </v-tabs>

                <v-card-text>
                    <v-tabs-window v-model="tab">
                        <v-tabs-window-item value="one">
                            One
                        </v-tabs-window-item>

                        <v-tabs-window-item value="two">
                            Two
                        </v-tabs-window-item>

                        <v-tabs-window-item value="three">
                            Three
                        </v-tabs-window-item>
                    </v-tabs-window>
                </v-card-text>
            </v-card>
        </v-container>
    </AuthenticatedLayout>
</template>
