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
    {title: "Date of Creation", key: "date_of_creation", sortable: false},
    {title: "Registered Office Address", key: "registered_office_address", sortable: false},
];

const customerTableData = computed(() => {
    if (searchResult.value && Array.isArray(searchResult.value)) {
        return searchResult.value.map(item => ({
            title: item.title || 'N/A',
            company_number: item.company_number || 'N/A',
            company_status: item.company_status || 'N/A',
            date_of_creation: item.date_of_creation || 'N/A',
            registered_office_address: item.address_snippet || item.address?.postal_code || 'N/A'
        }));
    }
    return [];
});

// Common SIC codes you might want to use
const sicCodeOptions = [
    { value: '46710', title: 'Wholesale of solid, liquid and gaseous fuels and related products' },
    { value: '47300', title: 'Retail sale of automotive fuel in specialised stores' },
    // Add more relevant SIC codes...
];

const resetFilters = () => {
    searchInput.value = "";
    searchResult.value = [];
    error.value = null;
}

const searchCompanies = async () => {
    if (!searchInput.value && !selectedSicCodes.value.length) return;

    loading.value = true;
    error.value = null;

    try {
        const params = {
            ...(searchInput.value && { company_name_includes: searchInput.value }),
            ...(selectedSicCodes.value.length && { sic_codes: selectedSicCodes.value }),
            size: 20
        };

        const response = await axios.get('/advanced-search/companies', { params });
        searchResult.value = response.data.items || [];
    } catch (e) {
        error.value = 'Failed to fetch company data';
        searchResult.value = [];
    } finally {
        loading.value = false;
    }
}

// const searchCompanies = async () => {
//     if (!searchInput.value) return;
//
//     loading.value = true;
//     error.value = null;
//
//     try {
//         const response = await axios.get('/customer-data/search', {
//             params: { q: searchInput.value }
//         });
//
//         searchResult.value = response.data.items || [];
//     } catch (e) {
//         error.value = 'Failed to fetch company data';
//         searchResult.value = [];
//     } finally {
//         loading.value = false;
//     }
// }
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
                            />
                        </v-col>
                        <v-col cols="12" sm="3">
                            <v-select
                                v-model="selectedSicCodes"
                                variant="underlined"
                                :items="sicCodeOptions"
                                label="SIC Codes"
                                multiple
                                chips
                                clearable
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
