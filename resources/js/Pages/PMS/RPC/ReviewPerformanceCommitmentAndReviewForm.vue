<style scoped>
table,
th,
td {
    font-size: 14px;
    padding: 5px;
    border: 0.5px solid rgb(185, 185, 185);
    border-collapse: collapse;
}
</style>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import PcrForm from "@/Components/PMS/PCR/PcrForm.vue";
</script>

<template>
    <Head title="Review Performance" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Review Performance Commitment / PCR
            </h2>
        </template>

        <div class="py-2">
            <Card class="w-full">
                <template #title>
                    <!-- <Button
                        label="Back"
                        class="p-button-sm p-button-raised p-button-text mb-3"
                        icon="bi bi-arrow-left"
                        @click="go_back()"
                    ></Button> -->
                    <!-- <br />
        <span><i class="bi bi-book mr-2"></i> {{ pms_pcr_status.full_name }}</span> -->
                </template>
                <template #subtitle>
                    <!-- <span class="text-xl">{{ pms_pcr_status.sys_department }} ( {{ period.period }},
          {{ period.year }})</span>
        <span class="uppercase ml-2 font-bold text-green-700 p-2 border-1 border-green-700 border-round">{{
          pms_pcr_status.form_type
        }}</span> -->
                    <!-- This here shows the individual's pcr form. -->
                </template>
                <template #content>
                    <PcrForm
                        form_status=""
                        strategic_function=""
                        core_functions=""
                        support_functions=""
                    />
                </template>
            </Card>
        </div>
    </AuthenticatedLayout>
</template>
<script>
export default {
    props: {
        period: null,
        form_status: null,
        strategic_function: null,
        core_functions: null,
        support_functions: null,
    },
    data() {
        return {
            current_url: document.location.pathname,
        };
    },
    methods: {
        go_back() {
            window.history.back();
        },
    },
    created() {},
    mounted() {},
};
</script>
