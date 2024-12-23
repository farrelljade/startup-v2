<script setup>
import { usePage, Link } from '@inertiajs/vue3';
import {computed, ref} from 'vue';

const page = usePage()
const user = computed(() => page.props.auth.user)

</script>

<template>
    <v-card>
        <v-layout>
            <v-navigation-drawer
                expand-on-hover
                rail
            >
                <v-list>
                    <v-list-item
                        prepend-avatar="https://randomuser.me/api/portraits/women/85.jpg"
                        :subtitle="user.email"
                        :title="user.name"
                    ></v-list-item>
                </v-list>

                <v-divider></v-divider>

                <v-list density="compact" nav>
                    <v-list-item :href="route('dashboard')" prepend-icon="mdi-home" title="Home" value="home"></v-list-item>
                    <v-list-item prepend-icon="mdi-account-multiple" title="Shared with me" value="shared"></v-list-item>
                    <v-list-item prepend-icon="mdi-star" title="Starred" value="starred"></v-list-item>

                    <v-list-group
                        value="Admin"
                    >
                        <template v-slot:activator="{ props}">
                            <v-list-item
                                prepend-icon="mdi-account-circle"
                                v-bind="props"
                                title="Admin"
                            ></v-list-item>
                        </template>

                        <v-list-item :href="route('users.index')" title="Users Page" value="users"></v-list-item>
                    </v-list-group>

                    <v-list-item class="align-self-center mb-2">
                        <Link :href="route('logout')" method="post" as="button" class="v-list-item__link">
                            <v-btn
                                prepend-icon="mdi-logout"
                                color="red"
                            >
                                logout
                            </v-btn>
                        </Link>
                    </v-list-item>
                </v-list>
            </v-navigation-drawer>

            <v-main>
                <slot />
            </v-main>
        </v-layout>
    </v-card>
</template>
