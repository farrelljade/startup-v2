<script setup>

const props = defineProps({
    userProfitThisMonth: {
        type: Number,
        required: true
    },
    prospectsToCustomers: {
        type: Array,
        required: true
    },
    userTargets: {
        type: Array,
        required: true
    }
});

const currentMonth = new Date().toLocaleString('en-GB', { month: 'long' });
</script>

<template>
    <v-row>
        <v-col cols="12" sm="3" class="cursor-pointer">
            <v-sheet
                class="dashboard-info"
                border
                color="deep-purple-lighten-1"
                rounded
                elevation="12"
            >
                <div class="top-row">
                    <div class="name">Profit for {{ currentMonth }}</div>
                </div>

                <div class="center-row">
                    £{{ Number(userProfitThisMonth).toLocaleString(undefined, {minimumFractionDigits: 2}) }}
                </div>

                <div class="bottom-row">
                    <div class="bottom-left name">Target: {{ userTargets.find(t => t.target?.type === 'profit')?.target_value || 0 }}</div>
                    <v-chip
                        v-if="userProfitThisMonth >= (userTargets.find(t => t.target?.type === 'profit')?.target_value || 0)"
                        color="success"
                        density="compact"
                        variant="elevated"
                        class="font-weight-bold"
                    >
                        Hit!
                    </v-chip>
                </div>
            </v-sheet>
        </v-col>
        <v-col cols="12" sm="3" class="cursor-pointer">
            <v-sheet
                class="dashboard-info"
                border
                color="deep-orange-lighten-1"
                rounded
                elevation="12"
            >
                <div class="top-row">
                    <div class="name">Prospects in {{ currentMonth }}</div>
                </div>

                <div class="center-row">
                    {{ prospectsToCustomers }}
                </div>

                <div class="bottom-row">
                    <div class=" bottom-left name">Target: {{ userTargets.find(t => t.target?.type === 'prospects')?.target_value || 0 }}</div>
                    <v-chip
                        v-if="prospectsToCustomers >= (userTargets.find(t => t.target?.type === 'prospects')?.target_value || 0)"
                        color="success"
                        density="compact"
                        variant="elevated"
                        class="font-weight-bold"
                    >
                        Hit!
                    </v-chip>
                </div>
            </v-sheet>
        </v-col>
    </v-row>
</template>
