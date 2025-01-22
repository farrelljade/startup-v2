<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from '@inertiajs/vue3';

const props = defineProps({
    users: {
        type: Object,
        required: true
    }
})


</script>

<template>
    <AuthenticatedLayout>
        <Head title="User Targets"/>

        <v-container fluid>
            <v-card class="mb-3 pa-1">
                <v-card-title class="bg-green-darken-1">
                    User Targets Page
                </v-card-title>
            </v-card>
        </v-container>
    </AuthenticatedLayout>
</template>
