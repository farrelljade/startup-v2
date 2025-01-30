<script setup>

import {computed, ref, watch} from "vue";
import {format, parseISO} from "date-fns";

const emit = defineEmits(['date-updated']);

const props = defineProps({
    inputDate: {
        type: String,
        default: null
    },
    label: {
        default: 'Date'
    },
    errors: {
        default: null
    },
    readonly: {
        default: false
    },
    maxDate: {
        default: null
    },
    icon: {
        type: String,
        default: null
    },
    hideDetails: {
        default: false
    },
    format: {
        type: String,
        default: 'dd/MM/yyyy'
    }
})

const dataDate = ref(null);
const menuOpen = ref(false);

watch(dataDate, (value) => {
    if (value === null) {
        dataDate.value = null;
    }
})

if (props.inputDate) {
    dataDate.value = parseISO((props.inputDate))
}

const dataDateFormatted = computed(() => {
    if (dataDate.value) {
        return format(dataDate.value, props.format)
    }
})

const onInputBlur = () => {
    if (dataDate.value) {
        emit('date-updated', format(dataDate.value, 'yyyy-MM-dd'))
    }
}

const resetDate = () => {
    dataDate.value = null;
    emit('date-updated', null);
}

</script>

<template>
    <v-menu
        v-model="menuOpen"
        :close-on-content-click="false"
        v-if="!readonly"
    >
        <template v-slot:activator="{ props }">
            <v-text-field
                v-model="dataDateFormatted"
                variant="underlined"
                :prepend-icon="icon"
                :="props"
                readonly
                :label="label"
                @blur="onInputBlur"
                :error-messages="errors"
                :hide-details="hideDetails"
                :append-inner-icon="dataDate ? 'mdi-close' : ''"
                @click:append-inner="resetDate"
            ></v-text-field>
        </template>
        <v-date-picker
            v-model="dataDate"
            :max="maxDate"
            class="bg-third"
            color="green-lighten-1"
            @update:modelValue="menuOpen = false; onInputBlur()"
        ></v-date-picker>
    </v-menu>
    <v-text-field
        v-else
        v-model="dataDateFormatted"
        :="props"
        readonly
        :label="label"
        @blur="onInputBlur"
        :error-messages="errors"
    ></v-text-field>
</template>
