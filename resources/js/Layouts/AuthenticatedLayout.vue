<script setup>
import {ref} from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import {Link, usePage} from '@inertiajs/vue3';
import {reactive} from 'vue';

const showingNavigationDropdown = ref(false);
const page = usePage()
const state = reactive({
    showAuthenticated: !!page.props.auth.user,
});
console.log(!!page.props.auth.user)
</script>

<template>
    <div>
        <div class="min-h-screen bg-black pt-[90px]">
            <nav class="fixed top-0 left-0 right-0 bg-black border-b border-[#30363d] z-[500]">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link
                                    v-if="state.showAuthenticated"
                                    :href="route('profile.show',{user:$page.props.auth.user.id})"
                                >
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-gray-800"
                                    />
                                </Link>
                                <Link
                                    v-else
                                    :href="route('register')"
                                    :active="route().current('register')"
                                >
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-gray-800"
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink v-if="state.showAuthenticated"
                                         :href="route('profile.show',{user:$page.props.auth.user.id})"
                                         :active="route().current('profile.show')">
                                    Home
                                </NavLink>
                                <NavLink v-else :href="route('register')" :active="route().current('register')">
                                    Home
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-gray-800 hover:bg-[#374151] focus:outline-none transition ease-in-out duration-150"
                                            >
                                                <span v-if="state.showAuthenticated">
                                                    {{ $page.props.auth.user.username }}
                                                </span>
                                                <span v-else>
                                                    Незарегистри́рованный пользователь
                                                </span>

                                                <svg
                                                    class="ms-2 -me-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <div v-if="state.showAuthenticated">
                                            <DropdownLink :href="route('profile.edit')"> Профиль</DropdownLink>
                                            <DropdownLink :href="route('logout')" method="post" as="button">
                                                Выйти из аккаунта
                                            </DropdownLink>
                                        </div>
                                        <div v-else>
                                            <DropdownLink :href="route('register')">Зарегистрироваться</DropdownLink>
                                            <DropdownLink :href="route('login')" method="post" as="button">
                                                Войти в аккаунт
                                            </DropdownLink>
                                        </div>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 focus:outline-none focus:text-gray-500 transition duration-150 ease-in-out"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="black" viewBox="0 0 24 24">
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden"
                >
                    <!--                    <div class="pt-2 pb-3 space-y-1">-->
                    <!--                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">-->
                    <!--                            Dashboard2-->
                    <!--                        </ResponsiveNavLink>-->
                    <!--                    </div>-->

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-[#30363d]">
<!--                        <div class="px-4">-->
<!--                            <div class="font-medium text-base text-gray-800">-->
<!--                                {{ $page.props.auth.user.name }}-->
<!--                                11-->
<!--                            </div>-->
<!--                            <div class="font-medium text-sm text-gray-500">-->
<!--                                {{ $page.props.auth.user.email }}-->
<!--                            </div>-->
<!--                        </div>-->

                        <div class="mt-3 space-y-1">
                            <div v-if="state.showAuthenticated">
                                <ResponsiveNavLink :href="route('profile.edit')"> Профиль</ResponsiveNavLink>
                                <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                    Выйти из аккаунта
                                </ResponsiveNavLink>
                            </div>
                            <div v-else>
                                <ResponsiveNavLink :href="route('register')">Зарегистрироваться</ResponsiveNavLink>
                                <ResponsiveNavLink :href="route('login')" method="post" as="button">
                                    Войти в аккаунт
                                </ResponsiveNavLink>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <!--            <header class="bg-white shadow" v-if="$slots.header">-->
            <!--                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">-->
            <!--                    <slot name="header" />-->
            <!--                </div>-->
            <!--            </header>-->

            <!-- Page Content -->
            <main>
                <slot/>
            </main>
        </div>
    </div>
</template>
