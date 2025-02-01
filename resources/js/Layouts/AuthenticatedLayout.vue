<script setup>
import {usePage, Link, router} from '@inertiajs/vue3';
import {computed, defineAsyncComponent, onMounted, ref, watch} from 'vue';
import {createCookie, readCookie, userHasPermission} from "@/helpers/helpers.js";

const drawer = ref(true);
const rail = ref(false);
const impersonateUserDialog = ref(false);
const user = computed(() => usePage().props.auth.user)

const saveRailState = (newState) => {
    createCookie('sidebar_rail', newState ? '1' : '0', 365);
}

watch(rail, (newValue) => {
    saveRailState(newValue);
});

onMounted(() => {
    const savedRail = readCookie('sidebar_rail');

    if (savedRail !== null) {
        rail.value = savedRail === '1';
    }
});

const openImpersonateDialog = () => {
    impersonateUserDialog.value = true;
}

const impersonateDialog = defineAsyncComponent(() =>
    import('@/Components/ImpersonateDialog.vue')
);

const removeImpersonate = () => {
    createCookie('impersonate', '', -1);
    window.location.reload();
}

const logout = () => {
    router.post(route('logout'));
}
</script>

<template>
    <v-card>
        <v-layout>
            <v-navigation-drawer
                v-model="drawer"
                :rail="rail"
                permanent
            >
                <v-list>
                    <v-list-item
                        v-if="!rail"
                        prepend-icon="mdi-menu-open"
                        @click.stop="rail = true"
                        :title="user.name"
                    ></v-list-item>
                </v-list>

                <v-list density="compact" nav>
                    <v-list-item v-if="rail" prepend-icon="mdi-menu-close" @click.stop="rail = false"></v-list-item>
                    <v-list-item :href="route('dashboard')" prepend-icon="mdi-home" title="Home" value="home"></v-list-item>
                    <v-list-item :href="route('orders.index')" prepend-icon="mdi-cart" title="Orders Page" value="orders"></v-list-item>
                    <v-list-item :href="route('prospects.index')" prepend-icon="mdi-face-agent" title="Prospects Page" value="prospects"></v-list-item>
                    <v-list-item :href="route('customers.index')" prepend-icon="mdi-account-group" title="Customers Page" value="customers"></v-list-item>

                    <v-list-group
                        v-if="user && userHasPermission(user, 'View Admin')"
                        value="Admin"
                    >
                        <template v-slot:activator="{ props }">
                            <v-list-item
                                prepend-icon="mdi-account-circle"
                                v-bind="props"
                                title="Admin"
                            ></v-list-item>
                        </template>

                        <v-list-item :href="route('users.index')" title="Users Page" value="users"></v-list-item>
                        <v-list-item :href="route('user-targets.index')" title="User Targets" value="user_targets"></v-list-item>
                    </v-list-group>
                </v-list>

                <template v-slot:append>
                    <div class="pa-2">
                        <v-btn
                            v-if="user && user.is_admin"
                            :block="true"
                            color="white"
                            class="mb-2"
                            @click="openImpersonateDialog"
                        >
                            <v-icon>mdi-account-convert</v-icon>
                            <span v-if="!rail">Impersonate</span>
                        </v-btn>

                        <v-btn
                            v-if="readCookie('impersonate')"
                            :block="true"
                            color="orange"
                            class="mb-2"
                            @click="removeImpersonate"
                        >
                            <v-icon>mdi-logout</v-icon>
                            <span v-if="!rail">Stop Impersonating</span>
                        </v-btn>
                        <form @submit.prevent="logout" method="POST">
                            <v-btn
                                :block="true"
                                color="red"
                                type="submit"
                            >
                                <v-icon>mdi-logout</v-icon>
                                <span v-if="!rail">Logout</span>
                            </v-btn>
                        </form>
                    </div>
                </template>
            </v-navigation-drawer>

            <v-main>
                <slot />
            </v-main>
        </v-layout>
    </v-card>

    <impersonate-dialog
        @close="impersonateUserDialog = false"
        :dialog="impersonateUserDialog"
    />
</template>
