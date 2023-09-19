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
</script>

<template>
    <Head title="Form Status | PCR" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                PCR / Form Status
            </h2>
        </template>
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                            COMMITMENT AND REVIEW | Set Form Type</span
                        ></template
                    >
                    <template #subtitle>
                        <span class="text-xl"
                            >{{ $page.props.auth.user.sys_department_name }} (
                            {{ period.period }}, {{ period.year }})</span
                        >
                        <br />
                        Set form type</template
                    >
                    <template #content>
                        <form
                            @submit.prevent="submit_form()"
                            class="w-full ml-5"
                        >
                            <div class="field">
                                <h3>AGENCY:</h3>
                                <div class="field-radiobutton">
                                    <RadioButton
                                        inputId="agency1"
                                        name="employee_from"
                                        value="lgu"
                                        v-model="form.agency"
                                    />
                                    <label for="agency1"
                                        >(LGU) Local Government Unit</label
                                    >
                                </div>
                                <div class="field-radiobutton">
                                    <RadioButton
                                        inputId="agency2"
                                        name="employee_from"
                                        value="nga"
                                        v-model="form.agency"
                                    />
                                    <label for="agency2"
                                        >(NGA) National Government Agency</label
                                    >
                                </div>
                                <Message
                                    severity="error"
                                    v-if="error.agency && !form.agency"
                                >
                                    {{ error.agency }}
                                </Message>
                            </div>
                            <div class="field">
                                <h3>PCR TYPE:</h3>
                                <div class="field-radiobutton">
                                    <RadioButton
                                        inputId="type1"
                                        name="form_type"
                                        value="ipcr"
                                        v-model="form.form_type"
                                    />
                                    <label for="type1">IPCR</label>
                                </div>

                                <div v-if="form.agency != 'nga'">
                                    <div class="field-radiobutton">
                                        <RadioButton
                                            inputId="type2"
                                            name="form_type"
                                            value="spcr"
                                            v-model="form.form_type"
                                        />
                                        <label for="type2">SPCR</label>
                                    </div>
                                    <div class="field-radiobutton">
                                        <RadioButton
                                            inputId="type3"
                                            name="form_type"
                                            value="dspcr"
                                            v-model="form.form_type"
                                        />
                                        <label for="type3">DIVISION SPCR</label>
                                    </div>
                                    <div class="field-radiobutton">
                                        <RadioButton
                                            inputId="type4"
                                            name="form_type"
                                            value="dpcr"
                                            v-model="form.form_type"
                                        />
                                        <label for="type4">DPCR</label>
                                    </div>
                                </div>
                                <Message
                                    severity="error"
                                    v-if="error.form_type && !form.form_type"
                                >
                                    {{ error.form_type }}
                                </Message>
                            </div>
                            <Button
                                icon="bi bi-save"
                                label="Save"
                                type="submit"
                            ></Button>
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
        form_type: null,
        period: null,
    },

    data() {
        return {
            current_url: document.location.pathname,
            error: {
                agency: "",
                form_type: "",
            },
            form: this.$inertia.form({
                agency: null,
                form_type: null,
            }),
        };
    },
    methods: {
        validate() {
            this.error.agency = !this.form.agency
                ? "Please select the agency."
                : null;
            this.error.form_type = !this.form.form_type
                ? "Please select the form type."
                : null;
            return this.error.agency || this.error.form_type ? false : true;
        },
        submit_form() {
            if (this.form.agency == "nga") {
                this.form.form_type = "ipcr";
            }
            if (this.validate()) {
                this.form.post(this.current_url, {
                    onSuccess: () => {
                        this.go_back();
                    },
                });
            }
        },
        go_back() {
            // window.history.back();
            var pathname = document.location.pathname;
            pathname = pathname.split("/");
            pathname = `/${pathname[1]}/${pathname[2]}/${pathname[3]}`;
            // console.log(pathname);
            this.$inertia.get(
                pathname,
                {},
                {
                    replace: true,
                    onSuccess: () => {
                        // if (toast) {
                        //   this.$toast.add(toast);
                        // }
                    },
                }
            );
        },
    },
    created() {
        if (this.form_type) {
            this.form.agency = this.form_type.agency;
            this.form.form_type = this.form_type.form_type;
        }
    },
    mounted() {},
};
</script>
