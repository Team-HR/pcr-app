<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import PeriodSelector from "@/Components/PMS/PeriodSelector.vue";
</script>

<template>
    <Head title="Rating Scale Matrix" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                PMS / Settings
            </h2>
        </template>

        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card class="mx-auto">
                    <template #title
                        ><i class="bi bi-gear"></i> Settings</template
                    >
                    <template #subtitle
                        >Configure Performance Management System</template
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
                                                :src="item.src"
                                                style="height: 15em"
                                            />
                                        </div>
                                    </template>
                                    <template #title>
                                        {{ item.label }}
                                    </template>
                                    <template #subtitle>
                                        Setup {{ item.label }}
                                    </template>
                                    <template #content>
                                        <Button
                                            icon="pi pi-wrench"
                                            label="Configure"
                                            text
                                            raised
                                            @click="$inertia.get(item.path)"
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
<script>
export default {
    data() {
        return {
            items: [
                {
                    label: "Periods",
                    path: "/pms/settings/periods",
                    src: "https://img.freepik.com/premium-photo/automated-testing-abstract-concept-vector-illustration_916191-65839.jpg?w=1060",
                },
                {
                    label: "Support Functions",
                    path: "/pms/settings/support_functions",
                    src: "https://img.freepik.com/premium-photo/digital-marketing-abstract-concept_891428-187.jpg?w=900",
                },
            ],
        };
    },
    mounted() {},
};
</script>
