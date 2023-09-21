<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PeriodSelector from "@/Components/PMS/PeriodSelector.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Setup Support Functions" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <Card class="mx-auto">
                        <template #title
                            ><i class="bi bi-gear"></i> Settings : Support
                            Functions</template
                        >
                        <template #subtitle
                            >Setup Support Functions for Performance Commitment
                            Reports</template
                        >
                        <template #content>
                            <PeriodSelector
                                icon=""
                                title=""
                                description=""
                                path="/pms/settings/support_functions/"
                            />
                        </template>
                    </Card>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script>
export default {
    props: {
        // years: Array
    },
    data() {
        return {
            current_url: document.location.pathname,
            form: this.$inertia.form({
                year: null,
            }),
        };
    },
    methods: {
        addYear() {
            console.log(this.current_url);
            // return false;
            // console.log(this.year);
            this.form.post(this.current_url + "/create", {
                preserveScroll: true,
                onSuccess: () => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Success!",
                        detail: "New periods added!",
                        life: 3000,
                    });
                    this.form.year = null;
                },
            });
        },
    },
    mounted() {
        // console.log(this.years);
    },
};
</script>
