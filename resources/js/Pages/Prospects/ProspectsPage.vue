<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, router, usePage} from '@inertiajs/vue3';
import {getData, userHasPermission} from "@/helpers/helpers.js";
import {computed, ref} from "vue";
import AddNewProspectDialog from "@/Pages/Prospects/Components/AddNewProspectDialog.vue";

const snackbar = ref(false);
const snackbarMessage = ref('');

const addNewProspectDialog = ref(false);

const page = usePage()
const auth = computed(() => page.props.auth.user)

const props = defineProps({
    prospects: {
        type: Object,
        required: true
    },
    users: {
        type: Object,
        required: true
    },
    leadSource: {
        type: Object,
        required: true
    }
})

const companyName = ref(null);
const userId = ref(null);
const leadSourceId = ref(null);


const filteredProspects = ref(props.prospects);

const prospectsHeaders = [
    { title: 'Company Name', key: 'company_name', sortable: false},
    { title: 'Account Manager', key: 'user.name', sortable: false},
    { title: 'Lead Source', key: 'lead_source.name', sortable: false},
    { title: 'Action', key: 'actions', sortable: false}
]

const openAddNewProspectDialog = () => {
    addNewProspectDialog.value = true;
}
const closeDialog = () => {
    addNewProspectDialog.value = false;
}

const handleSuccess = () => {
    snackbarMessage.value = 'Prospect created successfully!'
    snackbar.value = true;
}

const searchProspects = async () => {
    const params = {
        company_name: companyName.value,
        user_id: userId.value,
        lead_source_id: leadSourceId.value
    };


    await getData(route('prospects.search'), params, (response) => {
        filteredProspects.value = response.data;
    })
}

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Prospects" />

        <v-container fluid>
            <v-card class="mb-3 pa-1">
                <v-card-title class="bg-green-darken-1 d-flex justify-space-between align-center">
                    Prospects Page

                    <v-btn
                        size="small"
                        class="float-right"
                        variant="elevated"
                        @click="openAddNewProspectDialog"
                    >Add Prospect
                    </v-btn>
                </v-card-title>

                <v-card-text>
                    <v-row class="mt-2">
                        <v-col cols="12" sm="3">
                            <v-text-field
                                v-model="companyName"
                                variant="underlined"
                                label="Company Name"
                                @input="searchProspects"
                            />
                        </v-col>
                        <v-col cols="12" sm="3">
                            <v-autocomplete
                                v-model="userId"
                                :items="users"
                                variant="underlined"
                                label="Account Manager"
                                item-value="id"
                                item-title="name"
                                clearable
                                @update:model-value="searchProspects"
                            />
                        </v-col>
                        <v-col cols="12" sm="3">
                            <v-autocomplete
                                v-model="leadSourceId"
                                :items="leadSource"
                                variant="underlined"
                                label="Lead Source"
                                item-value="id"
                                item-title="name"
                                clearable
                                @update:model-value="searchProspects"
                            />
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>

            <v-card>
                <v-card-text>
                    <v-data-table
                        :headers="prospectsHeaders"
                        :items="filteredProspects"
                    >
                        <template v-slot:item.user.name="{ item }">
                            <template v-if="userHasPermission(auth, 'View User Dashboard')">
                                <Link
                                    :href="route('dashboard', { user: item.user.id })"
                                    class="text-blue-500 hover:text-blue-700 text-decoration-none"
                                >
                                    {{ item.user.name }}
                                </Link>
                            </template>
                            <template v-else>
                                {{ item.user.name }}
                            </template>
                        </template>
                        <template v-slot:item.actions="{ item }">
                            <v-btn
                                variant="text"
                                icon="mdi-location-enter"
                                color="warning"
                                @click="router.visit(route('company.profile', item.id ))"
                            />
                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card>
        </v-container>

        <v-dialog
            v-model="addNewProspectDialog"
            width="70vw"
            persistent
        >
            <AddNewProspectDialog
                :users="users"
                :leadSource="leadSource"
                @close="closeDialog"
                @success="handleSuccess"
            />
        </v-dialog>

        <v-snackbar
            v-model="snackbar"
            :timeout="2000"
            color="success"
        >
            {{ snackbarMessage }}
        </v-snackbar>
    </AuthenticatedLayout>
</template>
