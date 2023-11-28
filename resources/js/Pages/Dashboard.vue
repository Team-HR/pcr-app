<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

let items = ref([
    {
        title: "PMS Settings",
        subtitle: "Setup Performance Management System Parameters",
        img: "https://img.freepik.com/free-vector/hand-drawn-flat-design-benchmark-illustration_23-2149331621.jpg?w=740&t=st=1696921998~exp=1696922598~hmac=3f83f1fbca4bbb209728d4e5bb0e404f26ddd87c20af60f514068fd5355069db",
        href: "/pms/settings",
    },
    {
        title: "System Settings",
        subtitle: "Configure system-wide parameters",
        img: "https://img.freepik.com/free-vector/illustration-characters-fixing-cogwheel_53876-40796.jpg?w=740&t=st=1696921952~exp=1696922552~hmac=2594f8760316d62a3be9a277c2d75a9d1fa6033a064c768ea90d184fa67032ca",
        href: "/system/settings",
    },
]);
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 flex">
                        <!-- <Button
                            label="Settings"
                            @click="$inertia.get('/pms/settings')"
                        ></Button> -->
                        <!-- https://img.freepik.com/premium-photo/automated-testing-abstract-concept-vector-illustration_916191-65912.jpg?w=1060 -->

                        <Card
                            class="mx-2"
                            style="width: 25em"
                            v-for="item in items"
                            :key="item.id"
                        >
                            <template #header>
                                <div class="flex justify-content-center w-full">
                                    <img
                                        alt="user header"
                                        :src="item.img"
                                        style="height: 15em"
                                    />
                                </div>
                            </template>
                            <template #title> {{ item.title }} </template>
                            <template #subtitle>
                                <div class="h-12">
                                    {{ item.subtitle }}
                                </div>
                            </template>
                            <template #content>
                                <Button
                                    icon="pi pi-wrench"
                                    label="Configure"
                                    text
                                    raised
                                    @click="$inertia.get(item.href)"
                                />
                            </template>
                            <template #footer> </template>
                        </Card>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
