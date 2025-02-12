<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import {computed, ref} from "vue";

const searchInput = ref("");
const selectedSicCodes = ref([]);
const searchResult = ref(null);
const loading = ref(false);
const error = ref(null);

const headers = [
    {title: "Company Name", key: "title", sortable: false},
    {title: "Company Number", key: "company_number", sortable: false},
    {title: "Status", key: "company_status", sortable: false},
    {title: "SIC Codes", key: "sic_codes", sortable: false}
];

const customerTableData = computed(() => {
    if (searchResult.value && Array.isArray(searchResult.value)) {
        return searchResult.value.map(item => ({
            title: item.title || 'N/A',
            company_number: item.company_number || 'N/A',
            company_status: item.company_status || 'N/A',
            sic_codes: item.sic_codes?.map(sic => sic.code).join(', ') || 'N/A'
        }));
    }
    return [];
});

const resetFilters = () => {
    searchInput.value = "";
    searchResult.value = [];
    error.value = null;
}

const searchCompanies = async () => {
    if (!searchInput.value) return;

    loading.value = true;
    error.value = null;

    try {
        const response = await axios.get('/customer-data/search', {
            params: { q: searchInput.value }
        });

        searchResult.value = response.data.items || [];
        console.log('Companies:', searchResult.value);
    } catch (e) {
        error.value = 'Failed to fetch company data';
        searchResult.value = [];
    } finally {
        loading.value = false;
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Customer Data"/>

        <v-container fluid>
            <v-card class="mb-3 pa-1">
                <v-card-title class="bg-green-darken-1 d-flex justify-space-between align-center">
                    Customer Data
                </v-card-title>

                <v-card-text>
                    <v-row class="mt-2">
                        <v-col cols="12" sm="3">
                            <v-text-field
                                v-model="searchInput"
                                variant="underlined"
                                label="Search Companies"
                                :loading="loading"
                                :error-messages="error"
                                placeholder="Enter company name..."
                                clearable
                                @keyup.enter="searchCompanies"
                            />
                        </v-col>
                        <v-spacer/>
                        <v-card-actions>
                            <v-btn
                                variant="tonal"
                                class="mr-2"
                                @click="resetFilters"
                            >
                                Reset Filters
                            </v-btn>
                            <v-btn
                                variant="tonal"
                                class="bg-success"
                                @click="searchCompanies"
                            >
                                Search
                            </v-btn>
                        </v-card-actions>
                    </v-row>
                </v-card-text>
            </v-card>

            <v-card>
                <v-card-text>
                    <v-data-table
                        :headers="headers"
                        :items="customerTableData"
                        :loading="loading"
                        :no-data-text="error || 'No companies found'"
                        class="elevation-8"
                    >
                        <template v-slot:no-data>
                            <div class="text-center pa-4">
                                <span v-if="error" class="text-error">{{ error }}</span>
                                <span v-else>Search for a company to see results</span>
                            </div>
                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card>
        </v-container>
    </AuthenticatedLayout>
</template>
