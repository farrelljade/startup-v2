<script setup>
import SidebarItem from './SidebarItem.vue';

const props = defineProps({
    rail: Boolean,
    groupTitle: String,
    icon: String,
    value: String,
    items: {
        type: Array,
        required: true
    }
});
</script>

<template>
    <v-list-group :value="value">
        <template v-slot:activator="{ props: groupProps }">
            <v-tooltip v-if="rail" :text="groupTitle">
                <template v-slot:activator="{ props: tooltipProps }">
                    <v-list-item
                        v-bind="{...groupProps, ...tooltipProps}"
                        :prepend-icon="icon"
                        :title="groupTitle"
                    />
                </template>
            </v-tooltip>
            <v-list-item
                v-else
                v-bind="groupProps"
                :prepend-icon="icon"
                :title="groupTitle"
            />
        </template>

        <sidebar-item
            v-for="item in items"
            :key="item.value"
            :rail="rail"
            :href="item.href"
            :icon="item.icon"
            :title="item.title"
            :value="item.value"
        />
    </v-list-group>
</template>
