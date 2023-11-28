<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import FormBreadcrumb from "@/Components/PMS/PCR/FormBreadcrumb.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Form Status | PCR" />

    <AuthenticatedLayout>
        <template #header>
            <FormBreadcrumb
                v-if="!form_status.is_submitted"
                :period-id="this.period.id"
                :form-status-id="this.form_status.id"
            />
            <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                PCR / Form Status
            </h2> -->
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
                        <div class="">
                            <span
                                ><i class="bi bi-book mr-2"></i> PERFORMANCE
                                COMMITMENT AND REVIEW</span
                            >
                        </div>
                    </template>
                    <template #subtitle>
                        <div class="">
                            {{ $page.props.auth.user.sys_department_name }} (
                            {{ period.period }}, {{ period.year }})
                        </div>
                        <div class="">
                            Accomplish/Review your Performance Commitments
                        </div>
                    </template>
                    <template #content>
                        <div class="flex justify-content-center">
                            <table class="">
                                <!-- <thead>
            <tr>
              <th>Option</th>
              <th>Form</th>
              <th>Status</th>
            </tr>
          </thead> -->
                                <tr v-for="(item, i) in items" :key="i">
                                    <td v-if="!form_status.is_submitted">
                                        <!--  -->
                                        <Button
                                            @click="
                                                $inertia.get(
                                                    item.href,
                                                    {},
                                                    { replace: true }
                                                )
                                            "
                                            :label="
                                                item.b_label
                                                    ? item.b_label
                                                    : 'Edit'
                                            "
                                            class="p-button-sm w-full"
                                            text
                                            :disabled="item.is_disabled"
                                        ></Button>
                                        <!-- submit button start-->
                                        <!-- <Button v-else @click="submit(item)" :label="item.b_label ? item.b_label : 'Submit'" class="p-button-sm"
                      :disabled="item.is_disabled"></Button> -->
                                        <!-- submit button end-->
                                    </td>
                                    <td width="200px">
                                        <span class="ml-3">{{
                                            item.label
                                        }}</span>
                                    </td>
                                    <td class="" v-html="item.status"></td>
                                </tr>

                                <tr>
                                    <td v-if="!form_status.is_submitted">
                                        <!-- {{ form_status }} -- {{ form_status.is_submitted }} -->
                                        <Button
                                            label="Submit"
                                            class="p-button-sm w-full"
                                            @click="submit"
                                            :disabled="checkIfSubmittable"
                                            text
                                        ></Button>
                                    </td>
                                    <td>
                                        <span class="ml-3">
                                            {{
                                                !form_status.is_submitted
                                                    ? "Submit & Finalize"
                                                    : "Submitted"
                                            }}
                                        </span>
                                    </td>
                                    <td v-html="submit_status_text"></td>
                                </tr>
                            </table>
                        </div>
                        <Button
                            label="Print Form"
                            icon="bi bi-print"
                            v-if="form_status.is_submitted"
                            class="mt-2"
                            @click="printForm()"
                        ></Button>
                    </template>
                </Card>
            </div>
            <Toast />
        </div>
    </AuthenticatedLayout>
</template>

<script>
// import AuthLayout from "@/Layouts/Authenticated";
import { router } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";

export default {
    props: {
        period: null,
        form_status: null,
    },
    components: {
        // AuthLayout,
    },
    data() {
        return {
            current_url: document.location.pathname,
            items: [],
            form: useForm(this.form_status),
        };
    },
    created() {
        var items = [
            {
                no: 1,
                href: this.current_url + "/form_type/" + this.form_status.id,
                label: "Form Type",
                status: (() => {
                    var agency = this.form_status.agency
                        ? this.form_status.agency.toUpperCase()
                        : "________";
                    var form_type = this.form_status.form_type
                        ? this.form_status.form_type.toUpperCase()
                        : "________";
                    return this.form_status.agency
                        ? `Agency: <b class="text-green-700_ mr-3"> ${agency} </b>
               Type: <b class="text-green-700_ mr-3"> ${form_type}</b>`
                        : "Please set Form Type!";
                })(),
            },
            {
                no: 2,
                href: this.current_url + "/signatories/" + this.form_status.id,
                label: "Signatories",
                status: (() => {
                    if (!this.form_status.agency) return "Set Form Type first!";
                    // return this.form_status.signatories_inputs;
                    var immediate_supervisor,
                        department_head,
                        head_of_agency = "";
                    if (this.form_status.agency == "lgu") {
                        immediate_supervisor = this.form_status
                            .signatories_inputs.immediate_supervisor
                            ? this.form_status.signatories_inputs
                                  .immediate_supervisor.full_name
                            : "";
                        department_head = this.form_status.signatories_inputs
                            .department_head
                            ? this.form_status.signatories_inputs
                                  .department_head.full_name
                            : "";
                    } else {
                        immediate_supervisor = this.form_status
                            .signatories_inputs.immediate_supervisor
                            ? this.form_status.signatories_inputs
                                  .immediate_supervisor
                            : "";
                        department_head = this.form_status.signatories_inputs
                            .department_head
                            ? this.form_status.signatories_inputs
                                  .department_head
                            : "";
                    }
                    head_of_agency = this.form_status.signatories_inputs
                        .head_of_agency
                        ? this.form_status.signatories_inputs.head_of_agency
                        : "";
                    return `Immediate Supervisor: <b class="text-green-700_ mr-3"> ${immediate_supervisor}</b> <br/>
                    Department Head:<b class="text-green-700_ mr-3"> ${department_head}</b> <br/> Head of Agency: <b class="text-green-700_">${head_of_agency}</b>`;
                })(),
                is_disabled: !this.form_status.agency ? true : false,
            },
            {
                no: 3,
                href:
                    this.current_url + "/core_functions/" + this.form_status.id,
                label: "Core Functions",
                status: (() => {
                    if (!this.form_status.agency) return "Set Form Type first!";
                    var total_percentage_weight = this.form_status
                        .total_percentage_weight
                        ? this.form_status.total_percentage_weight
                        : "_________";
                    var total_average_rating = this.form_status
                        .total_average_rating
                        ? this.form_status.total_average_rating
                        : "_________";
                    return this.status_text(
                        total_percentage_weight,
                        total_average_rating
                    );
                })(),
                is_disabled: !this.form_status.agency ? true : false,
            },
            {
                no: 4,
                href:
                    this.current_url +
                    "/support_functions/" +
                    this.form_status.id,
                label: "Support Function",
                status: (() => {
                    if (!this.form_status.agency) return "Set Form Type first!";
                    var total_percentage_weight = this.form_status
                        .support_total_percentage_weight
                        ? this.form_status.support_total_percentage_weight
                        : "_________";
                    var total_average_rating =
                        this.form_status.support_total_average_rating &&
                        this.form_status.support_total_average_rating != "0.00"
                            ? this.form_status.support_total_average_rating
                            : "_________";
                    return this.status_text(
                        total_percentage_weight,
                        total_average_rating
                    );
                })(),
                is_disabled: !this.form_status.agency ? true : false,
            },
            {
                no: 5,
                href:
                    this.current_url +
                    "/strategic_function/" +
                    this.form_status.id,
                label: "Strategic Function",
                status: (() => {
                    if (!this.form_status.agency) return "Set Form Type first!";
                    var total_percentage_weight = this.form_status
                        .strat_total_percentage_weight
                        ? this.form_status.strat_total_percentage_weight
                        : "_________";
                    var total_average_rating = this.form_status
                        .strat_total_average_rating
                        ? this.form_status.strat_total_average_rating
                        : "_________";
                    return this.status_text(
                        total_percentage_weight,
                        total_average_rating
                    );
                })(),
                is_disabled: !this.form_status.agency ? true : false,
            },

            // {
            //   no: 6,
            //   href: "/api/" + this.current_url + "/submit",
            //   b_label: "Submit",
            //   label: this.form_status.is_submitted ? "Submitted" : "Finalize & Submit",
            //   status: (() => {
            //     if (!this.form_status.agency) return "Set Form Type first!";
            //     var total_percentage_weight = this.form_status.overall_percentage_weight
            //       ? this.form_status.overall_percentage_weight
            //       : "_________";
            //     var total_average_rating = this.form_status.overall_numerical_rating
            //       ? this.form_status.overall_numerical_rating
            //       : "_________";
            //     return `Total Percentage Weight (%): <b class="text-green-700_ mr-3">${total_percentage_weight}%</b>Total Numerical Rating: <b class="text-green-700_ mr-3">${total_average_rating}</b>`;
            //   })(),
            //   is_disabled: !this.form_status.agency ? true : false,
            // },
        ];

        this.items = items;
    },
    computed: {
        submit_status_text() {
            if (!this.form_status.agency) return "Set Form Type first!";
            var total_percentage_weight = this.form_status
                .overall_percentage_weight
                ? this.form_status.overall_percentage_weight
                : "_________";
            var total_average_rating = this.form_status.overall_numerical_rating
                ? this.form_status.overall_numerical_rating
                : "_________";
            return `Total Percentage Weight (%): <b class="text-green-700_ mr-3">${total_percentage_weight}%</b>Final Numerical Rating: <b class="text-green-700_ mr-3">${total_average_rating}</b>`;
        },

        checkIfSubmittable() {
            if (
                this.form_status.total_average_rating == "0.00" ||
                this.form_status.strat_total_average_rating == "0.00" ||
                this.form_status.support_total_average_rating == "0.00"
            ) {
                return true;
            }
            // strat_total_average_rating
            // support_total_average_rating
            // total_average_rating
            // return true;
        },
    },

    methods: {
        isActive(item) {
            return item.route
                ? this.$router.resolve(item.route).path === this.$route.path
                : false;
        }, // DELETE AFTER TESTING

        printForm() {
            router.get(this.current_url + "/print/" + this.form_status.id);
        },
        go_back() {
            window.history.back();
        },

        status_text(total_percentage_weight, total_average_rating) {
            return `Percentage Weight (%): <b class="text-green-700_ mr-3">${total_percentage_weight}%</b>Rating: <b class="text-green-700_ mr-3">${total_average_rating}</b>`;
        },
        submit() {
            this.form.post(this.current_url + "/submit", {
                onSuccess: (page) => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Submitted",
                        detail: "PCR Successfully Submitted!",
                        life: 3000,
                    });
                },
            });
        },
        go_back() {
            window.history.back();
        },
    },

    mounted() {
        router.reload({ only: ["form_status"] });
        // console.log(this.period.id);
        // console.log(this.form_status.id);
    },
};
</script>
