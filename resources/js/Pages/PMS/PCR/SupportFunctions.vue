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
                        AND REVIEW | Support Functions</span
                    ></template
                >
                <template #subtitle>
                    <span class="text-xl"
                        >{{ $page.props.auth.user.sys_department_name }} (
                        {{ period.period }}, {{ period.year }})</span
                    >
                    <br />
                    Accomplish Support Functions</template
                >
                <template #content>
                    <div class="mx-5"></div>
                    <!-- Dialogs and Toast start-->
                    <ConfirmDialog></ConfirmDialog>
                    <Toast />
                    <!-- Dialogs and Toast end-->
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="text-xl">
                                    {{ total_percentage_weight }}%
                                </th>
                                <th class="text-xl">Support Function</th>
                                <th class="text-xl">Success Indicator</th>
                                <th class="text-xl">Actual Accomplishment</th>
                                <th class="text-xl" style="width: 40px">Q</th>
                                <th class="text-xl" style="width: 40px">E</th>
                                <th class="text-xl" style="width: 40px">T</th>
                                <th class="text-xl" style="width: 40px">
                                    A ({{
                                        total_numerical_rating
                                            ? total_numerical_rating
                                            : ""
                                    }})
                                </th>
                                <th class="text-xl">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="rows.length < 1">
                                <td
                                    class="text-center bg-gray-300 p-5"
                                    colspan="9"
                                >
                                    No records found! Please setup the support
                                    functions.
                                </td>
                            </tr>
                            <tr v-for="(row, i) in rows" :key="i">
                                <!-- <td colspan="8">{{row}}</td> -->
                                <td class="text-lg text-center">
                                    {{ row.percent }}%
                                </td>
                                <td class="text-lg">
                                    {{ row.support_function }}
                                </td>
                                <td class="text-lg">
                                    {{ row.success_indicator }}
                                </td>
                                <template v-if="row.id">
                                    <td class="text-lg">
                                        {{ row.accomplishment }}
                                    </td>
                                    <td class="text-center">
                                        {{ row.quality }}
                                    </td>
                                    <td class="text-center">
                                        {{ row.efficiency }}
                                    </td>
                                    <td class="text-center">
                                        {{ row.timeliness }}
                                    </td>
                                    <td class="text-center">
                                        {{ row.average }}
                                    </td>
                                    <td class="text-center">
                                        <Button
                                            label="Edit"
                                            class="p-button-text p-button-primary"
                                            icon="bi bi-pencil-square"
                                            @click="openAddEditModal(row)"
                                        />
                                        <Button
                                            label="Reset"
                                            class="p-button-text p-button-danger"
                                            icon="bi bi-arrow-counterclockwise"
                                            type="button"
                                            @click="resetAccomplishment(row.id)"
                                        />
                                    </td>
                                </template>
                                <template v-else>
                                    <td colspan="6" class="text-center">
                                        <Button
                                            label="Add Accomplishment"
                                            class="p-button-raised p-button-text"
                                            icon="bi bi-check2-circle"
                                            @click="openAddEditModal(row)"
                                        />
                                    </td>
                                </template>
                            </tr>
                        </tbody>
                    </table>
                </template>
            </Card>

            <Dialog
                header="Add/Edit Accomplishment"
                v-model:visible="addEditModal"
                :modal="true"
                style="width: 1000px"
            >
                <div class="m-2">
                    <form
                        id="submitAccomplishmentForm"
                        @submit.prevent="submitAccomplishment"
                    >
                        <table class="mb-2" style="width: 100%">
                            <tr>
                                <td
                                    class="text-xl font-bold"
                                    style="width: 195px"
                                >
                                    Support Function:
                                </td>
                                <td class="text-xl">
                                    {{ editAccomplishment.support_function }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-xl font-bold">
                                    Success Indicator:
                                </td>
                                <td class="text-xl">
                                    {{ editAccomplishment.success_indicator }}
                                    <Button
                                        label="Copy"
                                        icon="bi bi-box-arrow-down"
                                        class="p-button-text"
                                        @click="
                                            editAccomplishment.accomplishment =
                                                editAccomplishment.success_indicator
                                        "
                                    />
                                </td>
                            </tr>
                        </table>
                        <div class="mt-3"></div>
                        <label class="font-bold text-xl"
                            >Actual Accomplishment:</label
                        >

                        <Textarea
                            v-model="editAccomplishment.accomplishment"
                            rows="3"
                            style="width: 100%"
                            placeholder="Enter actual accomplishment here..."
                            class="mt-2"
                            required
                        />

                        <MeasureSelector
                            class="mt-2"
                            v-if="editAccomplishment.quality_options.length > 0"
                            name="Quality"
                            :options="editAccomplishment.quality_options"
                            v-model="editAccomplishment.quality"
                        />

                        <MeasureSelector
                            class="mt-2"
                            v-if="
                                editAccomplishment.efficiency_options.length > 0
                            "
                            name="Efficiency"
                            :options="editAccomplishment.efficiency_options"
                            v-model="editAccomplishment.efficiency"
                        />

                        <MeasureSelector
                            class="mt-2"
                            v-if="
                                editAccomplishment.timeliness_options.length > 0
                            "
                            name="Timeliness"
                            :options="editAccomplishment.timeliness_options"
                            v-model="editAccomplishment.timeliness"
                        />
                    </form>
                </div>

                <template #footer>
                    <Button
                        label="No"
                        icon="pi pi-times"
                        @click="addEditModal = false"
                        class="p-button-text"
                    />
                    <Button
                        type="submit"
                        form="submitAccomplishmentForm"
                        label="Save"
                        icon="pi pi-save"
                        class="p-button-text"
                        autofocus
                    />
                </template>
            </Dialog>
        </div>
    </AuthenticatedLayout>
</template>
<script>
export default {
    props: {
        period: null,
        rows: null,
        total_numerical_rating: null,
        total_percentage_weight: null,
    },
    components: {},
    data() {
        return {
            current_url: document.location.pathname,
            error: {},
            accomplishment_modal: false,
            not_applicable_modal: false,
            editAccomplishment: this.$inertia.form({
                id: null,
                support_func_id: null,
                support_function: null,
                success_indicator: null,
                accomplishment: null,
                quality_options: null,
                quality: null,
                efficiency_options: null,
                efficiency: null,
                timeliness_options: null,
                timeliness: null,
                percent: null,
            }),
            addEditModal: false,
        };
    },
    methods: {
        resetAccomplishment(id) {
            this.$confirm.require({
                message:
                    "Resetting this accomplishment will empty its values, proceed?",
                header: "Reset Confirmation",
                icon: "pi pi-info-circle",
                acceptClass: "p-button-danger",
                accept: () => {
                    this.$inertia.delete(
                        this.current_url + "/accomplishment/" + id,
                        {
                            preserveScroll: true,
                            onSuccess: () => {
                                this.$toast.add({
                                    severity: "info",
                                    summary: "Confirmed",
                                    detail: "Accomplishment resetted",
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

        openAddEditModal(row) {
            this.editAccomplishment.id = row.id;
            this.editAccomplishment.support_func_id = row.support_func_id;
            this.editAccomplishment.support_function = row.support_function;
            this.editAccomplishment.success_indicator = row.success_indicator;
            this.editAccomplishment.accomplishment = row.accomplishment;
            this.editAccomplishment.quality_options = row.quality_options;
            this.editAccomplishment.quality = row.quality;
            this.editAccomplishment.efficiency_options = row.efficiency_options;
            this.editAccomplishment.efficiency = row.efficiency;
            this.editAccomplishment.timeliness_options = row.timeliness_options;
            this.editAccomplishment.timeliness = row.timeliness;
            this.editAccomplishment.percent = row.percent;
            this.addEditModal = true;
        },

        submitAccomplishment() {
            this.editAccomplishment.post(this.current_url + "/accomplishment", {
                preserveScroll: true,
                onSuccess: () => {
                    if (!this.editAccomplishment.support_func_data_id) {
                        this.$toast.add({
                            severity: "success",
                            summary: "Accomplished!",
                            detail: "Accomplishment saved!",
                            life: 3000,
                        });
                    } else {
                        this.$toast.add({
                            severity: "success",
                            summary: "Updated!",
                            detail: "Accomplishment updated!",
                            life: 3000,
                        });
                    }
                    this.addEditModal = false;
                    // this.clear_accomplishment();
                },
            });
        },
    },
    created() {
        this.$inertia.reload({ only: ["rows"] });
        this.formStatusId = this.$inertia.page.url.split("/")[5];
    },
    mounted() {},
};
</script>
