<script setup>

const props = defineProps({
    rail: Boolean,
    href: String,
    icon: String,
    title: String,
    value: String
});
</script>

<template>
    <v-tooltip v-if="rail" :text="title">
        <template v-slot:activator="{ props }">
            <v-list-item
                :href="href"
                v-bind="props"
                :prepend-icon="icon"
                :title="title"
                :value="value"
            />
        </template>
    </v-tooltip>
    <v-list-item
        v-else
        :href="href"
        :prepend-icon="icon"
        :title="title"
        :value="value"
    />
</template>
