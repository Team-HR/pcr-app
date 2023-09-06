<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

import PeriodSelector from "@/Components/PMS/PeriodSelector.vue";

// export default {
//   props: {
//     // periods: null,
//   },
//   components: {
//     AuthLayout,
//     PeriodSelector
//   },
//   data() {
//     return {
//       // period_id: null,
//     };
//   },
//   mounted() { },
// };
</script>

<template>
    <Head title="Rating Scale Matrix" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Rating Scale Matrix
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <period-selector
                            icon="bi bi-book"
                            title="Department Rating Scale Matrix"
                            description="Edit or review your Department/Section's Rating Scale Matrix"
                            path="/pms/rsm/"
                        ></period-selector>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
