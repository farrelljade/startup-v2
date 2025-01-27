<script setup>

import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";

const emit = defineEmits(['success', 'close']);

const showPassword = ref(false);

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
})

const togglePassword = () => {
    showPassword.value = !showPassword.value;
}

const submit = () => {
    form.post(route('register'), {
        onSuccess: () => {
            emit('success')
            emit('close')
        }
    });
};
</script>

<template>
    <form @submit.prevent="submit">
        <v-card class="pa-1">
            <v-card-title class="bg-green-darken-1 d-flex justify-space-between align-center">
                Add New User

                <v-btn
                    variant="text"
                    icon="mdi-close-circle"
                    @click="emit('close')"
                />
            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="form.name"
                            autocomplete
                            label="Name"
                            variant="underlined"
                            :error-messages="form.errors.name"
                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="form.email"
                            autocomplete="new-password"
                            label="Email"
                            variant="underlined"
                            :error-messages="form.errors.email"
                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="form.password"
                            label="Password"
                            variant="underlined"
                            :type="showPassword ? 'text' : 'password'"
                            :append-inner-icon="form.password ? (showPassword ? 'mdi-eye' : 'mdi-eye-off') : ''"
                            @click:append-inner="togglePassword"
                            :error-messages="form.errors.password"
                        />
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="form.password_confirmation"
                            label="Confirm Password"
                            variant="underlined"
                            :type="showPassword ? 'text' : 'password'"
                            :append-inner-icon="form.password ? (showPassword ? 'mdi-eye' : 'mdi-eye-off') : ''"
                            @click:append-inner="togglePassword"
                            :error-messages="form.errors.password_confirmation"
                        />
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions>
                <v-btn
                    variant="tonal"
                    color="error"
                    text="Cancel"
                    @click="emit('close')"
                />
                <v-spacer/>
                <v-btn
                    variant="tonal"
                    color="success"
                    text="Create User"
                    @click="submit"
                    :loading="form.processing"
                />
            </v-card-actions>
        </v-card>
    </form>
</template>
