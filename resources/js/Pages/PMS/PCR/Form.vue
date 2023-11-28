<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import FormComponent from "@/Components/PMS/PCR/FormComponent.vue";
</script>

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

<template>
    <Head title="PCR" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                PCR /
                {{ `${$page.props.period.period}, ${$page.props.period.year}` }}
            </h2>
        </template>

        <div class="py-1"></div>
        <Card class="w-full">
            <template #title>
                <Card class="w-full">
                    <template #title>
                        <!-- <Button
                            label="Back"
                            class="p-button-sm p-button-raised p-button-text mb-3"
                            icon="bi bi-arrow-left"
                            @click="go_back()"
                        ></Button>
                        <br /> -->
                        <span
                            ><i class="bi bi-book mr-2"></i> PERFORMANCE
                            COMMITMENT AND REVIEW</span
                        ></template
                    >
                    <template #subtitle>
                        <span class="text-xl"
                            >{{ $page.props.auth.user.sys_department_name }} (
                            {{ period.period }}, {{ period.year }})</span
                        >
                        <br />
                        Accomplish/Review your Performance Commitments</template
                    >
                    <template #content>
                        <FormComponent :pms_pcr_status="form_status" />
                    </template>
                </Card>
            </template>
        </Card>

        <Toast />
    </AuthenticatedLayout>
</template>
<script>
import { useForm } from "@inertiajs/vue3";

export default {
    props: {
        period: null,
        form_status: null,
    },
    data() {
        return {
            current_url: document.location.pathname,
            items: [],
            form: useForm(this.form_status),
        };
    },

    methods: {
        go_back() {
            window.history.back();
        },
    },

    mounted() {},
};
</script>
>
