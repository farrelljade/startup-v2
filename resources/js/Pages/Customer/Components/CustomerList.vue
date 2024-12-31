<script setup>
import {router} from '@inertiajs/vue3';

const props = defineProps({
    customers: {
        type: Array,
        required: true
    }
})

const customerHeaders = [
    {title: 'Company Name', key: 'company_name', sortable: false},
    {title: 'Email', key: 'email', sortable: false},
    {title: 'Actions', key: 'actions', sortable: false},
]
</script>

<template>
    <v-data-table
        :headers="customerHeaders"
        :items="customers"
        :items-per-page="5"
        class="elevation-3"
    >
        <template v-slot:item.actions="{ item }">
            <v-btn
                variant="text"
                icon="mdi-location-enter"
                color="warning"
                @click="router.visit(route('company.profile', item.id ))"
            />
        </template>
    </v-data-table>
</template>
