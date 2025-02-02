<script setup>
import {router} from "@inertiajs/vue3";
import {computed} from "vue";

const props = defineProps({
    prospect: {
        type: Object,
    },
    selected_tab: {
        type: String,
        required: true
    }
})

const hasActiveTankRequests = computed(() => {
    return props.prospect?.tank_sales?.some(sale =>
        sale.status === 'Requested' || sale.status === 'In Progress'
    );
});

function goToTab(routeName) {
    router.visit(route(routeName, { prospect: props.prospect.id }));
}

</script>

<template>
    <v-card class="mb-2">
    <v-tabs
        :model-value="selected_tab"
        bg-color="transparent"
        slider-color="green"
    >
        <v-tab value="prospect_enquiry" @click="goToTab('company.profile')">Profile</v-tab>
        <v-tab value="prospect_notes" @click="goToTab('prospect.notes')">Notes</v-tab>

        <v-tab value="tank_sales" @click="goToTab('tank-sales')">
            <v-badge
                color="info"
                dot
                :model-value="hasActiveTankRequests"
            >
                Tank Sales
            </v-badge>
        </v-tab>
    </v-tabs>
    </v-card>
</template>
