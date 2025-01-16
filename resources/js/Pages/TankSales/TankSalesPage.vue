<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from '@inertiajs/vue3';
import ProspectTabs from "@/Pages/Prospects/Components/ProspectTabs.vue";

const props = defineProps({
    prospect: {
        type: Array,
        required: true
    }
})

const tank_sales = 'tank_sales';
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Tank Sales"/>

        <v-container fluid>
            <v-card class="mb-3 pa-2">
                <v-card-title class="bg-green-darken-1 d-flex justify-space-between align-center">
                    Tank Sales Page
                </v-card-title>
            </v-card>

            <ProspectTabs :prospect="prospect" :selected_tab="tank_sales"/>
        </v-container>
    </AuthenticatedLayout>
</template>
