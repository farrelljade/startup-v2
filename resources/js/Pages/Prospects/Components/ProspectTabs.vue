<script setup>
import {router} from "@inertiajs/vue3";

const props = defineProps({
    prospect: {
        type: Object,
    },
    selected_tab: {
        type: String,
        required: true
    }
})
function goToTab(routeName) {
    router.visit(route(routeName, { prospect: props.prospect.id }));
}

</script>

<template>
    <v-card class="mb-2">
    <v-tabs
        :model-value="selected_tab"
        bg-color="blue-grey-darken-2"
    >
        <v-tab value="prospect_enquiry" @click="goToTab('prospect.enquiry')">Profile</v-tab>
        <v-tab value="prospect_notes" @click="goToTab('prospect.notes')">Notes</v-tab>
    </v-tabs>
    </v-card>
</template>
