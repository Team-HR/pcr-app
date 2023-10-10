<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import PeriodSelector from "@/Components/PMS/PeriodSelector.vue";
</script>

<template>
    <Head title="Review Performance" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Review Performance Commitment / Period Selection
            </h2>
        </template>

        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <period-selector
                    icon="bi bi-book"
                    title="Select Rating Period"
                    description="Review your personnel's Performance Commitment and Review"
                    path="/pms/rpc/"
                ></period-selector>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script>
export default {
    props: {
        periods: null,
    },
    data() {
        return {
            period_id: null,
        };
    },
    mounted() {},
};
</script>
