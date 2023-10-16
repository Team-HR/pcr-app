<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import PeriodSelector from "@/Components/PMS/PeriodSelector.vue";
import { ref } from "vue";

let items = ref([
    {
        title: "Employees",
        subtitle: "Add or update personnel to agency",
        href: "/system/settings/employees",
        img: "https://img.freepik.com/free-vector/employee-group-portrait-illustration_74855-5495.jpg?w=1380&t=st=1696923010~exp=1696923610~hmac=a041755b029c69f8900c4373980878f2838f647df1daedba15ad5fe37e2b46fa",
    },
    // {
    //     title: "Register Users",
    //     subtitle: "Register new users",
    //     href: "/system/settings/register",
    //     img: "https://img.freepik.com/free-vector/mobile-login-concept-illustration_114360-83.jpg?w=740&t=st=1696920917~exp=1696921517~hmac=f3316473d589e92ee7b48945d00a7980c465f6df696f2ed5d6d288cbef6710c6",
    // },
]);
</script>

<template>
    <Head title="Rating Scale Matrix" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                System / Settings
            </h2>
        </template>

        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card class="mx-auto">
                    <template #title
                        ><i class="bi bi-gear"></i> Settings</template
                    >
                    <template #subtitle
                        >Configure system-wide parameters</template
                    >
                    <template #content>
                        <div class="flex flex-wrap">
                            <template v-for="(item, i) in items" :key="i">
                                <!-- <Button
                                    class="m-3"
                                    style="height: 85px; width: 300px"
                                    :label="item.label"
                                    @click="$inertia.get(item.path)"
                                ></Button> -->
                                <Card class="mx-2" style="width: 25em">
                                    <template #header>
                                        <div
                                            class="flex justify-content-center w-full"
                                        >
                                            <img
                                                alt="user header"
                                                :src="item.img"
                                                style="height: 15em"
                                            />
                                        </div>
                                    </template>
                                    <template #title>
                                        {{ item.title }}
                                    </template>
                                    <template #subtitle>
                                        {{ item.subtitle }}
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
                            </template>
                        </div>
                    </template>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
