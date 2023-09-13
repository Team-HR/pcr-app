<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import PeriodSelector from "@/Components/PMS/PeriodSelector.vue";
</script>

<template>
    <Head title="Individual Rating Scale Matrix" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Individual Rating Scale Matrix / Period Selection
            </h2>
        </template>

        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <period-selector
                    icon="bi bi-book"
                    title="Select Rating Period"
                    description="View your individual rating scale matrix."
                    path="/pms/irsm/"
                ></period-selector>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
