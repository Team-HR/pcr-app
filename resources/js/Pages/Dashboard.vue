<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
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
                    <div class="p-6 text-gray-900">
                        <!-- <Button
                            label="Settings"
                            @click="$inertia.get('/pms/settings')"
                        ></Button> -->
                        <!-- https://img.freepik.com/premium-photo/automated-testing-abstract-concept-vector-illustration_916191-65912.jpg?w=1060 -->

                        <Card class="mx-2" style="width: 25em">
                            <template #header>
                                <div class="flex justify-content-center w-full">
                                    <img
                                        alt="user header"
                                        src="https://img.freepik.com/premium-photo/automated-testing-abstract-concept-vector-illustration_916191-65912.jpg?w=1060"
                                        style="height: 15em"
                                    />
                                </div>
                            </template>
                            <template #title> Settings </template>
                            <template #subtitle>
                                Setup Performance Management System Parameters
                            </template>
                            <template #content>
                                <Button
                                    icon="pi pi-wrench"
                                    label="Configure"
                                    text
                                    raised
                                    @click="$inertia.get('/pms/settings')"
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
