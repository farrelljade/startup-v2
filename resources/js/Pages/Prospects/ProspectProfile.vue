<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import ProspectTabs from "@/Pages/Prospects/Components/ProspectTabs.vue";

const props = defineProps({
    prospect: {
        type: Object,
        required: true
    }
})

const selected_tab = 'prospect_enquiry';
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Profile" />
        <v-container fluid>
            <v-card class="mb-3 pa-2">
                <v-card-title class="bg-success d-flex justify-space-between align-center">
                    {{ prospect.company_name }}
                </v-card-title>
            </v-card>

            <ProspectTabs :prospect="prospect" :selected_tab="selected_tab"/>

            <v-card class="mb-3 pa-2">
                <v-row cols="">
                    <v-col cols="6" md="3">
                        <v-text-field
                            v-model="prospect.company_name"
                            label="Company Name"
                            readonly
                        />
                    </v-col>
                    <v-col cols="6" md="3">
                        <v-text-field
                            v-model="prospect.user.name"
                            label="Account Manager"
                            readonly
                        />
                    </v-col>
                </v-row>
            </v-card>
        </v-container>
    </AuthenticatedLayout>
</template>
