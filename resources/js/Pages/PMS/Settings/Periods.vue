<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
// import PeriodSelector from "@/Components/PMS/PeriodSelector.vue";
</script>

<template>
    <Head title="Rating Scale Matrix" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                PMS / Settings / Periods
            </h2>
        </template>

        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card class="mx-auto">
                    <template #title
                        ><i class="bi bi-gear"></i> Settings : Periods</template
                    >
                    <template #subtitle
                        >Configure Performance Management System
                        Periods</template
                    >
                    <template #content>
                        <!-- <Button icon="pi pi-plus" label="Add New Period"></Button> -->

                        <!-- {{ years }} -->

                        <DataTable :value="years" tableStyle="width: 30rem;">
                            <Column field="year" header="Year"></Column>
                            <Column
                                field="firstPeriod"
                                header="1st Period"
                            ></Column>
                            <Column
                                field="secondPeriod"
                                header="2nd Period"
                            ></Column>
                        </DataTable>

                        <form class="m-5" @submit.prevent="addYear()">
                            <InputText
                                v-model="form.year"
                                type="number"
                                placeholder="Add Year"
                                required
                            />

                            <!-- <InputNumber id="year" v-model="year" :useGrouping="false" aria-describedby="number-error"
                       placeholder="Add Year" required="true" /> -->

                            <Button
                                type="submit"
                                icon="pi pi-plus"
                                label="Add Year"
                                class="vertical-align-middle ml-2"
                            />
                        </form>
                    </template>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script>
export default {
    props: {
        years: Array,
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
        console.log(this.years);
    },
};
</script>
