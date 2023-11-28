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
import FormBreadcrumb from "@/Components/PMS/PCR/FormBreadcrumb.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import MeasureSelector from "@/Components/PMS/PCR/MeasureSelector.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Form Status | PCR" />

    <AuthenticatedLayout>
        <template #header>
            <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                PCR / Form Status
            </h2> -->
            <FormBreadcrumb
                :period-id="this.period.id"
                :form-status-id="formStatusId"
            />
        </template>
        <div class="p-3">
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
                        ><i class="bi bi-book mr-2"></i> PERFORMANCE COMMITMENT
                        AND REVIEW | Strategic Function</span
                    ></template
                >
                <template #subtitle>
                    <span class="text-xl"
                        >{{ $page.props.auth.user.sys_department_name }} (
                        {{ period.period }}, {{ period.year }})</span
                    >
                    <br />
                    Accomplish Strategic Function</template
                >
                <template #content>
                    <div class="mx-5">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th>Strategic Function</th>
                                    <th>Success Indicator</th>
                                    <th>Actual Accomplishment</th>
                                    <th>Final Numerical Rating</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="rows && rows.length > 0">
                                    <tr
                                        v-for="(row, index) in rows"
                                        :key="index"
                                    >
                                        <td class="text-center">
                                            {{ row.function_title }}
                                        </td>
                                        <td class="text-center">
                                            {{ row.success_indicator }}
                                        </td>
                                        <td class="text-center">
                                            {{ row.actual_accomplishment }}
                                        </td>
                                        <td class="text-center">
                                            {{ row.final_numerical_rating }}
                                        </td>
                                        <td class="text-center">
                                            <Button
                                                label="Edit"
                                                icon="bi bi-pencil"
                                                class="p-button-sm p-button-text p-2 m-1"
                                                @click="
                                                    add_edit_accomplishment(row)
                                                "
                                            />
                                            <Button
                                                label="Delete"
                                                icon="bi bi-x"
                                                class="p-button-sm p-button-text p-button-danger p-2 m-1"
                                                @click="
                                                    confirm_accomplishment_reset(
                                                        row
                                                    )
                                                "
                                            />
                                        </td>
                                    </tr>
                                </template>
                                <template v-else>
                                    <tr>
                                        <!-- <td colspan="5" class="text-center text-gray-500">No records found!</td> -->
                                        <td colspan="5" class="text-center">
                                            <Button
                                                class="p-button-sm mr-3"
                                                label="Add Accomplishment"
                                                @click="
                                                    add_edit_accomplishment()
                                                "
                                            />
                                            <!-- <Button
                      class="p-button-sm p-button-danger"
                      label="Not Applicable"
                      @click="not_applicable()"
                    /> -->
                                        </td>
                                    </tr>
                                </template>
                                <!-- <tr>
                <td colspan="5" class="text-center">
                  <Button class="p-button-sm mr-3" label="Add Accomplishment" />
                  <Button class="p-button-sm p-button-danger" label="Not Applicable" />
                </td>
              </tr> -->
                            </tbody>
                        </table>
                    </div>
                    <!-- Dialogs and Toast start-->
                    <ConfirmDialog></ConfirmDialog>
                    <Toast />
                    <!-- Dialogs and Toast end-->

                    <!-- not applicable modal start -->
                    <Dialog
                        header="Accomplish Strategic Function"
                        v-model:visible="accomplishment_modal"
                        :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
                        :style="{ width: '50vw' }"
                        :modal="true"
                    >
                        <form
                            @submit.prevent="submit_add_edit_accomplishment()"
                            id="add_edit_accomplishment_form"
                        >
                            <div class="field">
                                <div class="font-bold mb-2">
                                    Strategic Function:
                                </div>
                                <Textarea
                                    v-model="accomplishment.function_title"
                                    :autoResize="true"
                                    rows="2"
                                    class="w-full"
                                    placeholder="Enter the strategic function"
                                    required
                                />
                            </div>
                            <div class="field">
                                <div class="font-bold mb-2">
                                    Success Indicator:
                                </div>
                                <Textarea
                                    v-model="accomplishment.success_indicator"
                                    :autoResize="true"
                                    rows="2"
                                    class="w-full"
                                    placeholder="Enter the success indicator"
                                    required
                                />
                            </div>
                            <div class="field">
                                <div class="font-bold mb-2">
                                    Actual Accomplishment:
                                </div>
                                <Textarea
                                    v-model="
                                        accomplishment.actual_accomplishment
                                    "
                                    :autoResize="true"
                                    rows="2"
                                    class="w-full"
                                    placeholder="Enter your actual accomplishment"
                                    required
                                />
                            </div>
                            <div class="field">
                                <div class="font-bold mb-2">
                                    Final Numerical Rating:
                                </div>
                                <InputNumber
                                    v-model="
                                        accomplishment.final_numerical_rating
                                    "
                                    mode="decimal"
                                    :minFractionDigits="2"
                                    :maxFractionDigits="2"
                                    placeholder="e.g. 1.00 - 5"
                                    required
                                />
                            </div>
                        </form>

                        <template #footer>
                            <Button
                                label="Cancel"
                                icon="pi pi-times"
                                @click="cancel_add_edit_accomplishment()"
                                class="p-button-text"
                            />
                            <Button
                                label="Save"
                                icon="pi pi-check"
                                autofocus
                                type="submit"
                                form="add_edit_accomplishment_form"
                            />
                        </template>
                    </Dialog>
                    <!-- not applicable modal end -->
                </template>
            </Card>
        </div>
    </AuthenticatedLayout>
    <!-- </auth-layout> -->
</template>
<script>
export default {
    props: {
        period: null,
        rows: null,
    },
    data() {
        return {
            current_url: document.location.pathname,
            error: {},
            accomplishment_modal: false,
            not_applicable_modal: false,
            accomplishment: this.$inertia.form({
                id: null,
                function_title: null,
                success_indicator: null,
                actual_accomplishment: null,
                final_numerical_rating: null,
                remarks: null,
                not_applicable: null,
            }),
            formStatusId: null,
        };
    },
    methods: {
        add_edit_accomplishment(row) {
            if (!row) {
                this.reset_accomplishment();
            } else {
                this.accomplishment.id = row.id;
                this.accomplishment.function_title = row.function_title;
                this.accomplishment.success_indicator = row.success_indicator;
                this.accomplishment.actual_accomplishment =
                    row.actual_accomplishment;
                this.accomplishment.final_numerical_rating =
                    row.final_numerical_rating;
                this.accomplishment.remarks = row.remarks;
                this.accomplishment.not_applicable = row.not_applicable;
            }
            this.accomplishment_modal = true;
        },
        cancel_add_edit_accomplishment() {
            this.accomplishment_modal = false;
        },
        submit_add_edit_accomplishment() {
            this.accomplishment.post(this.current_url, {
                preserveScroll: true,
                onSuccess: () => {
                    this.accomplishment_modal = false;
                    if (!this.accomplishment.id) {
                        this.$toast.add({
                            severity: "success",
                            summary: "Accomplished!",
                            detail: "Strategic function accomplished.",
                            life: 3000,
                        });
                    } else {
                        this.$toast.add({
                            severity: "info",
                            summary: "Accomplishment Updated!",
                            detail: "Strategic function accomplishment updated.",
                            life: 3000,
                        });
                    }
                    this.reset_accomplishment();
                },
            });
        },
        reset_accomplishment() {
            this.accomplishment.id = null;
            this.accomplishment.function_title = null;
            this.accomplishment.success_indicator = null;
            this.accomplishment.actual_accomplishment = null;
            this.accomplishment.final_numerical_rating = null;
            this.accomplishment.remarks = null;
            this.accomplishment.not_applicable = null;
        },
        confirm_accomplishment_reset(row) {
            this.$confirm.require({
                message: "This accomplishment will be deleted, proceed?",
                header: "Delete Confirmation",
                icon: "pi pi-info-circle",
                acceptClass: "p-button-danger",
                accept: () => {
                    this.$inertia.delete(
                        this.current_url + "/delete/" + row.id,
                        {
                            preserveScroll: true,
                            onSuccess: () => {
                                this.$toast.add({
                                    severity: "info",
                                    summary: "Confirmed",
                                    detail: "Strategic function accomplishment deleted",
                                    life: 3000,
                                });
                            },
                        }
                    );
                },
                reject: () => {
                    // this.$toast.add({
                    //   severity: "error",
                    //   summary: "Rejected",
                    //   detail: "You have rejected",
                    //   life: 3000,
                    // });
                },
            });
        },
        not_applicable() {
            this.not_applicable_modal = true;
        },
        submit_not_applicable() {},
        cancel_not_applicable() {
            this.not_applicable_modal = false;
        },
        go_back() {
            var pathname = document.location.pathname;
            pathname = pathname.split("/");
            pathname = `/${pathname[1]}/${pathname[2]}/${pathname[3]}`;
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
        this.$inertia.reload({ only: ["rows"] });
        this.formStatusId = this.$inertia.page.url.split("/")[5];
    },
    mounted() {},
};
</script>
