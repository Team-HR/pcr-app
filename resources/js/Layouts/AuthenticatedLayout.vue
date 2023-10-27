<script setup>
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/vue3";

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div class="overflow-hidden">
        <div class="min-h-screen relative">
            <nav
                class="bg-white border-b border-gray-100 absolute top-0 left-0 w-full z-5"
            >
                <!-- Primary Navigation Menu -->
                <div class="mx-auto px-2 sm:px-3 lg:px-4">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center mr-5">
                                <Link
                                    :href="route('dashboard')"
                                    class="flex items-center"
                                >
                                    <ApplicationLogo
                                        class="block h-12 w-auto fill-current text-gray-800 mr-0"
                                    />
                                    <!-- <span>Online SPMS</span> -->
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <template v-for="(item, k) in items" :key="k">
                                <div
                                    class="hidden space-x-0 sm:-my-px sm:ml-0 sm:flex"
                                >
                                    <Divider layout="vertical" class="mx-3" />
                                    <NavLink
                                        :href="route(item.route)"
                                        :active="checkIfActive(item.route)"
                                    >
                                        <!-- :active="route().current('dashboard')" -->
                                        {{ item.label }}
                                    </NavLink>
                                </div>
                            </template>
                            <Divider layout="vertical" class="mx-3" />
                            <!-- Navigation Links -->
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="ml-2 -mr-0.5 h-4 w-4"
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
                                        <DropdownLink
                                            :href="route('profile.edit')"
                                        >
                                            Profile
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                        >
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                            >
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
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
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')">
                                Profile
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header
                class="bg-white shadow absolute left-0 w-full z-4"
                v-if="$slots.header"
                style="top: 65px"
            >
                <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>
            <!-- Page Content -->
            <main
                class="bg-gray-200 p-5 w-full top-0 left-0 absolute overflow-auto w-full h-full z-0"
            >
                <div style="height: 100px"></div>
                <slot />
            </main>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            items: [
                {
                    label: "Dashboard",
                    route: "dashboard",
                },
                {
                    label: "Performance Commitment",
                    route: "pcr",
                },
                {
                    label: "Individual Rating Scale",
                    route: "irsm",
                },
                // {
                //     label: "Rating Scale Matrix",
                //     route: "rsm",
                // },
                // {
                //     label: "Review Performance Commitment",
                //     route: "rpc",
                // },
                // {
                //     label: "Performance Management Team",
                //     route: "pmt",
                // },
            ],
        };
    },
    methods: {
        checkIfActive(route) {
            const url = this.$inertia.page.url.split("/");
            if (url.includes(route)) {
                return true;
            } else false;
        },
        getNavItems() {
            const roles = this.$inertia.page.props.auth.user.roles;
            const authLinks = [
                {
                    label: "Rating Scale Matrix",
                    route: "rsm",
                },
                {
                    label: "Review Performance Commitment",
                    route: "rpc",
                },
                {
                    label: "Performance Management Team",
                    route: "pmt",
                },
            ];
            authLinks.forEach((element) => {
                if (roles.includes(element.route)) {
                    this.items.push(element);
                }
            });
        },
    },
    created() {
        // console.log(this.$inertia.page.url.split("/")
        this.getNavItems();
    },
};
</script>
