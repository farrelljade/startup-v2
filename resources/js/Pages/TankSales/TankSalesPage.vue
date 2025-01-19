<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, usePage} from '@inertiajs/vue3';
import ProspectTabs from "@/Pages/Prospects/Components/ProspectTabs.vue";
import AddTankRequestDialog from "@/Pages/TankSales/Components/AddTankRequestDialog.vue";
import UpdateTankRequestDialog from "@/Pages/TankSales/Components/UpdateTankRequestDialog.vue";
import {ref} from "vue";
import {userHasPermission} from "@/helpers/helpers.js";

const addTankRequestDialog = ref(false);

const selectedTankSale = ref(null);
const updateTankRequestDialog = ref(false);

const props = defineProps({
    prospect: {
        type: Object,
        required: true
    }
})

const openUpdateDialog = (tankSale) => {
    selectedTankSale.value = tankSale;
    updateTankRequestDialog.value = true;
}

const closeDialog = (dialog) => {
    switch(dialog) {
        case 'add':
            addTankRequestDialog.value = false;
            break;
        case 'update':
            updateTankRequestDialog.value = false;
            break;
    }
}

const tankSaleHeaders = [
    { title: 'Requested By', key: 'requested_by', sortable: false },
    { title: 'Contact Name', key: 'contact_name', sortable: false },
    { title: 'Contact Email', key: 'contact_email', sortable: false },
    { title: 'Phone', key: 'contact_phone', sortable: false },
    { title: 'Urgent Requirement', key: 'requirement_urgent', sortable: false },
    { title: 'Fuel Type', key: 'fuel_type', sortable: false },
    { title: 'Tank Type', key: 'tank_type', sortable: false },
    { title: 'Tank Size', key: 'tank_size', sortable: false },
    { title: 'Status', key: 'status', sortable: false },
    { title: 'Other Quotes', key: 'quotes', sortable: false },
    { title: '', key: 'actions', sortable: false }
]

const tank_sales = 'tank_sales';
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Tank Sales"/>

        <v-container fluid>
            <v-card class="mb-3 pa-1">
                <v-card-title class="bg-green-darken-1"
                >
                    {{ prospect.company_name }}

                    <v-btn
                        size="small"
                        class="float-right"
                        variant="elevated"
                        @click="addTankRequestDialog = true"
                    >Tank Request
                    </v-btn>
                </v-card-title>
            </v-card>

            <ProspectTabs :prospect="prospect" :selected_tab="tank_sales"/>

            <v-card class="mt-4 pa-1">
                <v-card-title class="bg-green-lighten-1 d-flex justify-space-between align-center">
                    Tank Requests
                </v-card-title>
                <v-card-text>
                    <v-data-table
                        :headers="tankSaleHeaders"
                        :items="prospect.tank_sales"
                    >
                        <template v-slot:item.requirement_urgent="{ item }">
                            <v-chip
                                :color="Number(item.requirement_urgent) === 1 ? 'error' : 'green'"
                            >
                                {{ Number(item.requirement_urgent) === 1 ? 'Yes' : 'No' }}
                            </v-chip>
                        </template>
                        <template v-if="userHasPermission(usePage().props.auth.user, 'Update Tank Request')" v-slot:item.actions="{ item }">
                            <v-row>
                                <v-tooltip text="Update Request">
                                    <template v-slot:activator="{ props }">
                                        <v-col cols="3">
                                            <v-btn
                                                variant="text"
                                                small
                                                color="yellow-darken-1"
                                                icon="mdi-pencil"
                                                :="props" @click="openUpdateDialog(item)"
                                            ></v-btn>
                                        </v-col>
                                    </template>
                                </v-tooltip>
                                <v-tooltip text="Trash Request">
                                    <template v-slot:activator="{ props }">
                                        <v-col cols="3">
                                            <v-btn
                                                variant="text"
                                                small
                                                color="red"
                                                icon="mdi-delete"
                                                :="props"
                                            ></v-btn>
                                        </v-col>
                                    </template>
                                </v-tooltip>
                            </v-row>
                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card>
        </v-container>

        <v-dialog
            v-model="addTankRequestDialog"
            width="50vw"
            persistent
        >
            <AddTankRequestDialog
                :prospect="prospect"
                @close="closeDialog('add')"
            />
        </v-dialog>

        <v-dialog
            v-model="updateTankRequestDialog"
            width="50vw"
            persistent
        >
            <UpdateTankRequestDialog
                :prospect="prospect"
                :tank-sale="selectedTankSale"
                @close="closeDialog('update')"
            />
        </v-dialog>
    </AuthenticatedLayout>
</template>
