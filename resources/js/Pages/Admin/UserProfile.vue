<script setup>
import {computed, ref} from 'vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, usePage} from '@inertiajs/vue3';

const props = defineProps({
    user: {
        type: Object,
        required: true
    }
})
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Profile" />
        <v-container fluid>
            <v-card class="mb-3 pa-2">
                <v-card-title class="bg-success d-flex justify-space-between align-center">
                    User Profile
                </v-card-title>
            </v-card>

            <v-row>
                <v-col cols="12" md="6">
                    <v-card>
                        <v-card-title class="bg-success d-flex justify-space-between align-center">
                            First Card
                        </v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col md="6">
                                    <v-text-field
                                        v-model="user.name"
                                        label="Name"
                                        readonly
                                    />
                                </v-col>
                                <v-col md="6">
                                    <v-text-field
                                        v-model="user.email"
                                        label="Email"
                                        readonly
                                    />
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-col>

                <v-col cols="12" md="6">
                    <v-card>
                        <v-card-title class="bg-success d-flex justify-space-between align-center">Permissions</v-card-title>
                        <v-card-text>
                            Content for second card
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </AuthenticatedLayout>
</template>
