<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, useForm} from '@inertiajs/vue3';
import {ref} from "vue";

const updateTargetDialog = ref(false);

const props = defineProps({
    users: {
        type: Object,
        required: true
    }
})

const targetTypes = [
    { id: 'prospects', name: 'prospects' },
    { id: 'rejuves', name: 'rejuves' },
    { id: 'profit', name: 'profit' },
    { id: 'iho', name: 'iho' },
    { id: 'lubricants', name: 'lubricants' }
];

const userTargets = ref(props.users.map(user => ({
    id: user.id,
    name: user.name,
    prospects: user.targets[0]?.target_value || '',
    rejuves: user.targets[1]?.target_value || '',
    profit: user.targets[2]?.target_value || '',
    iho: user.targets[3]?.target_value || '',
    lubricants: user.targets[4]?.target_value || ''
})));

const form = useForm({
    targets: []
})

const openUpdateTargetDialog = () => {
    updateTargetDialog.value = true;
}

const submit = () => {
    const startDate = new Date().toISOString().split('T')[0];
    const endDate = new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0).toISOString().split('T')[0];

    form.targets = userTargets.value.flatMap(user =>
        targetTypes.map(type => ({
            user_id: user.id,
            type: type.id,
            value: user[type.name] || 0,
            start_date: startDate,
            end_date: endDate
        }))
    );

    form.post(route('user-targets.store'));

    updateTargetDialog.value = false;
}
</script>

<template>
    <AuthenticatedLayout>
        <Head title="User Targets"/>

        <v-container fluid>
            <v-card class="mb-3 pa-1">
                <v-card-title class="bg-green-lighten-1 d-flex justify-space-between align-center">
                    User Targets Page

                    <v-btn
                        density="comfortable"
                        @click="openUpdateTargetDialog"
                    >
                        Targets
                    </v-btn>
                </v-card-title>

                <form @submit.prevent="submit">
                    <v-table
                        height="600px"
                        fixed-header
                    >
                        <thead>
                            <tr>
                                <th class="text-left">
                                    Account Manager
                                </th>
                                <th class="text-left">
                                    Prospects
                                </th>
                                <th class="text-left">
                                    Rejuves
                                </th>
                                <th class="text-left">
                                    Profit
                                </th>
                                <th class="text-left">
                                    IHO
                                </th>
                                <th class="text-left">
                                    Lubricants
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(user, index) in userTargets"
                                :key="user.name"
                            >
                                <td>{{ user.name }}</td>
                                <td>
                                    <v-text-field
                                        class="mt-4"
                                        v-model="userTargets[index].prospects"
                                        variant="underlined"
                                        density="compact"
                                    />
                                </td>
                                <td>
                                    <v-text-field
                                        class="mt-4"
                                        v-model="userTargets[index].rejuves"
                                        variant="underlined"
                                        density="compact"
                                    />
                                </td>
                                <td>
                                    <v-text-field
                                        class="mt-4"
                                        v-model="userTargets[index].profit"
                                        variant="underlined"
                                        density="compact"
                                    />
                                </td>
                                <td>
                                    <v-text-field
                                        class="mt-4"
                                        v-model="userTargets[index].iho"
                                        variant="underlined"
                                        density="compact"
                                    />
                                </td>
                                <td>
                                    <v-text-field
                                        class="mt-4"
                                        v-model="userTargets[index].lubricants"
                                        variant="underlined"
                                        density="compact"
                                    />
                                </td>
                            </tr>
                        </tbody>
                    </v-table>
                </form>
            </v-card>
        </v-container>

        <v-dialog
            v-model="updateTargetDialog"
            transition="dialog-bottom-transition"
            width="40vw"
        >
            <v-card class="pa-1">
                <v-toolbar
                    color="green-darken-1"
                >
                    <v-toolbar-title>Target Options</v-toolbar-title>
                </v-toolbar>
                <v-spacer/>
                <v-card-actions>
                    <v-btn
                        color="info"
                        variant="tonal"
                    >
                        Update Targets
                    </v-btn>
                    <v-spacer/>
                    <v-btn
                        color="success"
                        variant="tonal"
                        @click="submit"
                        :loading="form.processing"
                    >
                        Set Targets
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </AuthenticatedLayout>
</template>
