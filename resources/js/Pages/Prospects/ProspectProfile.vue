<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, usePage} from '@inertiajs/vue3';
import ProspectTabs from "@/Pages/Prospects/Components/ProspectTabs.vue";
import {computed, reactive, ref} from "vue";
import {updateProspect, userHasPermission} from "@/helpers/helpers.js";

const page = usePage()
const user = computed(() => page.props.auth.user)

const props = defineProps({
    prospect: {
        type: Object,
        required: true
    }
})

const snackbar = ref(false);
const snackbarMessage = ref('');

const form = reactive({
    phone: props.prospect.phone
})

function handleUpdate() {
    updateProspect(props.prospect.id, form, () => {
        snackbar.value = true;
        snackbarMessage.value = 'Updated successfully!';
    });
}

const selected_tab = 'prospect_enquiry';
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Profile" />
        <v-container fluid>
            <v-card class="mb-3 pa-2">
                <v-card-title class="bg-green-darken-1 d-flex justify-space-between align-center">
                    {{ prospect.company_name }}
                </v-card-title>
            </v-card>

            <ProspectTabs :prospect="prospect" :selected_tab="selected_tab"/>


                <v-row>
                    <v-col cols="12" md="6">
                        <v-card>
                            <v-card-title class="bg-green-darken-1 d-flex justify-space-between align-center">
                                Details
                            </v-card-title>
                            <v-card-text>
                                <v-row>
                                    <v-col md="6">
                                        <v-text-field
                                            v-model="prospect.company_name"
                                            label="Company Name"
                                            readonly
                                        />
                                    </v-col>
                                    <v-col md="6">
                                        <v-text-field
                                            v-model="prospect.user.name"
                                            label="Account Manager"
                                            readonly
                                        />
                                    </v-col>
                                    <v-col md="6">
                                        <v-text-field
                                            v-model="prospect.line_1"
                                            label="Address Line 1"
                                            readonly
                                        />
                                    </v-col>
                                    <v-col v-if="prospect.line_2" md="6">
                                        <v-text-field
                                            v-model="prospect.line_2"
                                            label="Address Line 2"
                                            readonly
                                        />
                                    </v-col>
                                    <v-col v-if="prospect.line_3" md="6">
                                        <v-text-field
                                            v-model="prospect.line_3"
                                            label="Address Line 3"
                                            readonly
                                        />
                                    </v-col>
                                    <v-col v-if="prospect.city" md="6">
                                        <v-text-field
                                            v-model="prospect.city"
                                            label="City"
                                            readonly
                                        />
                                    </v-col>
                                    <v-col v-if="prospect.county" md="6">
                                        <v-text-field
                                            v-model="prospect.county"
                                            label="County"
                                            readonly
                                        />
                                    </v-col>
                                    <v-col md="6">
                                        <v-text-field
                                            v-model="form.phone"
                                            label="Phone"
                                            @change="handleUpdate"
                                            :readonly="!userHasPermission(user, 'Update Prospect')"
                                        />
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-col>

                    <v-col cols="12" md="6">
                        <v-card>
                            <v-card-title class="bg-green-darken-1 d-flex justify-space-between align-center">
                                Second Card
                            </v-card-title>

                        </v-card>
                    </v-col>

                    <v-snackbar
                        v-model="snackbar"
                        :timeout="3000"
                        color="success"
                    >
                        {{ snackbarMessage }}
                    </v-snackbar>
                </v-row>

        </v-container>
    </AuthenticatedLayout>
</template>
