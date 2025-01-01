<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, router, usePage} from '@inertiajs/vue3';
import {userHasPermission} from "@/helpers/helpers.js";
import {computed} from "vue";

const page = usePage()
const auth = computed(() => page.props.auth.user)

defineProps({
    prospects: Object
})

const prospectsHeaders = [
    { title: 'Name', key: 'company_name', sortable: false},
    { title: 'Account Manager', key: 'user.name', sortable: false},
    { title: 'Lead Source', key: 'lead_source.name', sortable: false},
    { title: 'Action', key: 'actions', sortable: false}
]

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Prospects" />

        <v-container fluid>
            <v-card class="mb-3 pa-3">
                <v-card-title class="bg-green-darken-1 d-flex justify-space-between align-center">
                    Prospects Page
                </v-card-title>
            </v-card>

            <v-card>
                <v-card-text>
                    <v-data-table
                        :headers="prospectsHeaders"
                        :items="prospects"
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
    </AuthenticatedLayout>
</template>
