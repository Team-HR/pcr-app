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
                        AND REVIEW | Core Functions</span
                    ></template
                >
                <template #subtitle>
                    <span class="text-xl"
                        >{{ $page.props.auth.user.sys_department_name }} (
                        {{ period.period }}, {{ period.year }})</span
                    >
                    <br />
                    Accomplish Core Functions</template
                >
                <template #content>
                    <!-- table start -->
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th style="width: 15px">
                                    {{ total_percentage_weight }}%
                                </th>
                                <th class="w-3">MFO/PAP</th>
                                <th class="w-3">Success <br />Indicator</th>
                                <th>Actual <br />Accomplishments</th>
                                <th>Q</th>
                                <th>E</th>
                                <th>T</th>
                                <th>
                                    A
                                    <i class="text-gray-700"
                                        >({{ total_average_rating }})</i
                                    >
                                </th>
                                <th>Remarks</th>
                                <th>
                                    <!-- <i class="bi bi-folder"></i> -->
                                </th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <template v-for="(row, r) in rows" :key="r">
                            <tr
                                v-if="row.rowspan == 0 && row.si_only == false"
                                :class="row.mfo_only ? 'bg-primary-50' : ''"
                            >
                                <td v-if="!row.mfo_only" class="text-center">
                                    <template
                                        v-if="row.pms_pcr_core_function_data"
                                    >
                                        <span
                                            v-if="
                                                row.pms_pcr_core_function_data
                                                    .percent
                                            "
                                            >{{
                                                row.pms_pcr_core_function_data
                                                    .percent
                                            }}%</span
                                        >
                                    </template>
                                </td>
                                <!-- if  mfo has no success indicator (title) conditioned colspan if has multiple success indicator -->
                                <td :colspan="row.mfo_only ? 11 : 1">
                                    <div :style="indent(row.level)">
                                        <span>
                                            <strong class="mr-2">{{
                                                row.code
                                            }}</strong>
                                            {{ row.title }}
                                        </span>
                                    </div>
                                </td>
                                <!-- if mfo with only one success indicator -->
                                <template v-if="!row.mfo_only">
                                    <td>{{ row.success_indicator }}</td>
                                    <template
                                        v-if="row.pms_pcr_core_function_data"
                                    >
                                        <template
                                            v-if="
                                                !row.pms_pcr_core_function_data
                                                    .not_applicable
                                            "
                                        >
                                            <td>
                                                {{
                                                    row
                                                        .pms_pcr_core_function_data
                                                        .actual
                                                }}
                                            </td>
                                            <td class="text-center">
                                                {{
                                                    row
                                                        .pms_pcr_core_function_data
                                                        .quality
                                                }}
                                            </td>
                                            <td class="text-center">
                                                {{
                                                    row
                                                        .pms_pcr_core_function_data
                                                        .efficiency
                                                }}
                                            </td>
                                            <td class="text-center">
                                                {{
                                                    row
                                                        .pms_pcr_core_function_data
                                                        .timeliness
                                                }}
                                            </td>
                                            <td
                                                class="text-center text-yellow-700"
                                            >
                                                {{
                                                    row
                                                        .pms_pcr_core_function_data
                                                        .average
                                                }}
                                            </td>
                                            <td class="text-center">
                                                {{
                                                    row
                                                        .pms_pcr_core_function_data
                                                        .remarks
                                                }}
                                            </td>
                                        </template>
                                        <template v-else>
                                            <td
                                                colspan="6"
                                                class="text-center text-blue-700"
                                            >
                                                {{
                                                    row
                                                        .pms_pcr_core_function_data
                                                        .actual
                                                }}
                                            </td>
                                        </template>
                                        <td></td>
                                        <td class="text-center">
                                            <Button
                                                v-if="
                                                    !row
                                                        .pms_pcr_core_function_data
                                                        .not_applicable
                                                "
                                                label="Edit"
                                                icon="bi bi-pencil"
                                                class="p-button-sm p-button-text p-2 m-1"
                                                @click="
                                                    edit_accomplishment(row)
                                                "
                                            />
                                            <Button
                                                v-else
                                                label="Edit"
                                                icon="bi bi-pencil"
                                                class="p-button-sm p-button-text p-2 m-1"
                                                @click="
                                                    edit_not_applicable(row)
                                                "
                                            />
                                            <Button
                                                label="Clear"
                                                icon="bi bi-arrow-counterclockwise"
                                                class="p-button-sm p-button-text p-button-warning p-2 m-1"
                                                @click="
                                                    confirm_accomplishment_reset(
                                                        row
                                                    )
                                                "
                                            />
                                        </td>
                                    </template>
                                    <template v-else>
                                        <td colspan="8" class="text-center">
                                            <Button
                                                label="Add Accomplishment"
                                                class="p-button-text p-button-small p-button-raised w-4 p-1"
                                                @click="add_accomplishment(row)"
                                            ></Button>
                                            <Button
                                                label="Not Applicable"
                                                class="p-button-danger p-button-small p-button-raised w-4 mt-2 ml-3 p-1"
                                                @click="not_applicable(row)"
                                            ></Button>
                                        </td>
                                    </template>
                                </template>
                            </tr>
                            <!-- sub mfo with initial success indicator  -->
                            <tr
                                v-else-if="
                                    row.rowspan > 0 && row.si_only == false
                                "
                            >
                                <td class="text-center text-center">
                                    <template
                                        v-if="row.pms_pcr_core_function_data"
                                    >
                                        <span
                                            v-if="
                                                row.pms_pcr_core_function_data
                                                    .percent
                                            "
                                            >{{
                                                row.pms_pcr_core_function_data
                                                    .percent
                                            }}%</span
                                        >
                                    </template>
                                </td>
                                <td :rowspan="row.rowspan">
                                    <div :style="indent(row.level)">
                                        <span>
                                            <strong class="mr-2">{{
                                                row.code
                                            }}</strong>
                                            {{ row.title }}
                                        </span>
                                    </div>
                                </td>
                                <td>{{ row.success_indicator }}</td>
                                <!-- accomplish interface start -->
                                <template v-if="row.pms_pcr_core_function_data">
                                    <template
                                        v-if="
                                            !row.pms_pcr_core_function_data
                                                .not_applicable
                                        "
                                    >
                                        <td>
                                            {{
                                                row.pms_pcr_core_function_data
                                                    .actual
                                            }}
                                        </td>
                                        <td class="text-center">
                                            {{
                                                row.pms_pcr_core_function_data
                                                    .quality
                                            }}
                                        </td>
                                        <td class="text-center">
                                            {{
                                                row.pms_pcr_core_function_data
                                                    .efficiency
                                            }}
                                        </td>
                                        <td class="text-center">
                                            {{
                                                row.pms_pcr_core_function_data
                                                    .timeliness
                                            }}
                                        </td>
                                        <td class="text-center text-yellow-700">
                                            {{
                                                row.pms_pcr_core_function_data
                                                    .average
                                            }}
                                        </td>
                                        <td class="text-center">
                                            {{
                                                row.pms_pcr_core_function_data
                                                    .remarks
                                            }}
                                        </td>
                                    </template>
                                    <template v-else>
                                        <td
                                            colspan="6"
                                            class="text-center text-blue-700"
                                        >
                                            {{
                                                row.pms_pcr_core_function_data
                                                    .actual
                                            }}
                                        </td>
                                    </template>
                                    <td></td>
                                    <td class="text-center">
                                        <Button
                                            v-if="
                                                !row.pms_pcr_core_function_data
                                                    .not_applicable
                                            "
                                            label="Edit"
                                            icon="bi bi-pencil"
                                            class="p-button-sm p-button-text p-2 m-1"
                                            @click="edit_accomplishment(row)"
                                        />
                                        <Button
                                            v-else
                                            label="Edit"
                                            icon="bi bi-pencil"
                                            class="p-button-sm p-button-text p-2 m-1"
                                            @click="edit_not_applicable(row)"
                                        />
                                        <Button
                                            label="Clear"
                                            icon="bi bi-arrow-counterclockwise"
                                            class="p-button-sm p-button-text p-button-warning p-2 m-1"
                                            @click="
                                                confirm_accomplishment_reset(
                                                    row
                                                )
                                            "
                                        />
                                    </td>
                                </template>
                                <template v-else>
                                    <td colspan="8" class="text-center">
                                        <Button
                                            label="Add Accomplishment"
                                            class="p-button-text p-button-small p-button-raised w-4 p-1"
                                            @click="add_accomplishment(row)"
                                        ></Button>
                                        <Button
                                            label="Not Applicable"
                                            class="p-button-danger p-button-small p-button-raised w-4 mt-2 ml-3 p-1"
                                            @click="not_applicable(row)"
                                        ></Button>
                                    </td>
                                </template>
                                <!-- accomplish interface end -->
                            </tr>
                            <!-- succeding success indicator from above -->
                            <tr v-else>
                                <td class="text-center">
                                    <template
                                        v-if="row.pms_pcr_core_function_data"
                                    >
                                        <span
                                            v-if="
                                                row.pms_pcr_core_function_data
                                                    .percent
                                            "
                                            >{{
                                                row.pms_pcr_core_function_data
                                                    .percent
                                            }}%</span
                                        >
                                    </template>
                                </td>
                                <td>{{ row.success_indicator }}</td>
                                <template v-if="row.pms_pcr_core_function_data">
                                    <template
                                        v-if="
                                            !row.pms_pcr_core_function_data
                                                .not_applicable
                                        "
                                    >
                                        <td>
                                            {{
                                                row.pms_pcr_core_function_data
                                                    .actual
                                            }}
                                        </td>
                                        <td class="text-center">
                                            {{
                                                row.pms_pcr_core_function_data
                                                    .quality
                                            }}
                                        </td>
                                        <td class="text-center">
                                            {{
                                                row.pms_pcr_core_function_data
                                                    .efficiency
                                            }}
                                        </td>
                                        <td class="text-center">
                                            {{
                                                row.pms_pcr_core_function_data
                                                    .timeliness
                                            }}
                                        </td>
                                        <td class="text-center text-yellow-700">
                                            {{
                                                row.pms_pcr_core_function_data
                                                    .average
                                            }}
                                        </td>
                                        <td class="text-center">
                                            {{
                                                row.pms_pcr_core_function_data
                                                    .remarks
                                            }}
                                        </td>
                                    </template>
                                    <template v-else>
                                        <td
                                            colspan="6"
                                            class="text-center text-blue-700"
                                        >
                                            {{
                                                row.pms_pcr_core_function_data
                                                    .actual
                                            }}
                                        </td>
                                    </template>
                                    <td></td>
                                    <td class="text-center">
                                        <Button
                                            v-if="
                                                !row.pms_pcr_core_function_data
                                                    .not_applicable
                                            "
                                            label="Edit"
                                            icon="bi bi-pencil"
                                            class="p-button-sm p-button-text p-2 m-1"
                                            @click="edit_accomplishment(row)"
                                        />
                                        <Button
                                            v-else
                                            label="Edit"
                                            icon="bi bi-pencil"
                                            class="p-button-sm p-button-text p-2 m-1"
                                            @click="edit_not_applicable(row)"
                                        />
                                        <Button
                                            label="Clear"
                                            icon="bi bi-arrow-counterclockwise"
                                            class="p-button-sm p-button-text p-button-warning p-2 m-1"
                                            @click="
                                                confirm_accomplishment_reset(
                                                    row
                                                )
                                            "
                                        />
                                    </td>
                                </template>
                                <template v-else>
                                    <td colspan="8" class="text-center">
                                        <Button
                                            label="Add Accomplishment"
                                            class="p-button-text p-button-small p-button-raised w-4 p-1"
                                            @click="add_accomplishment(row)"
                                        ></Button>
                                        <Button
                                            label="Not Applicable"
                                            class="p-button-danger p-button-small p-button-raised w-4 mt-2 ml-3 p-1"
                                            @click="not_applicable(row)"
                                        ></Button>
                                    </td>
                                </template>
                            </tr>
                        </template>
                        <tr v-if="rows.length < 1">
                            <td
                                class="p-5 bg-gray-300"
                                colspan="11"
                                style="text-align: center"
                            >
                                No records found!
                            </td>
                        </tr>
                    </table>
                    <!-- table end -->
                    <!-- add accomplishment modal start -->
                    <Dialog
                        header="Edit Accomplishment"
                        v-model:visible="edit_accomplishment_modal"
                        :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
                        :style="{ width: '50vw' }"
                        :modal="true"
                    >
                        <form
                            @submit.prevent="submit_accomplishment()"
                            id="accomplishment_form"
                        >
                            <div class="field">
                                <div class="font-bold">Success Indicator:</div>
                                <span>{{
                                    core_function.success_indicator
                                }}</span>
                                <br />
                                <!-- <Button
                                    text
                                    label="Copy"
                                    @click="
                                        accomplishment.actual =
                                            core_function.success_indicator
                                    "
                                    icon="pi pi-copy"
                                    class="m-1"
                                /> -->
                            </div>
                            <div class="field">
                                <div class="font-bold">
                                    Actual Accomplishment:
                                </div>
                                <Textarea
                                    v-model="accomplishment.actual"
                                    :autoResize="true"
                                    rows="5"
                                    class="w-full"
                                    placeholder="Enter your actual accomplishment here based on the success indicator above."
                                    required
                                />
                            </div>
                            <!-- <div class="field">
              {{ core_function }}
            </div> -->
                            <div
                                class="field"
                                v-if="core_function.quality.length > 0"
                            >
                                <div class="font-bold">Quality:</div>
                                <template
                                    v-for="(
                                        quality, i
                                    ) in core_function.quality"
                                    :key="i"
                                >
                                    <div v-if="quality">
                                        <input
                                            type="radio"
                                            name="quality"
                                            :value="5 - i"
                                            :id="`quality${i}`"
                                            v-model="accomplishment.quality"
                                            required
                                        />
                                        <label :for="`quality${i}`">{{
                                            `${5 - i} - ${quality}`
                                        }}</label>
                                    </div>
                                </template>
                            </div>
                            <div
                                class="field"
                                v-if="core_function.efficiency.length > 0"
                            >
                                <div class="font-bold">Efficiency:</div>
                                <template
                                    v-for="(
                                        efficiency, i
                                    ) in core_function.efficiency"
                                    :key="i"
                                >
                                    <div v-if="efficiency">
                                        <input
                                            type="radio"
                                            name="efficiency"
                                            :value="5 - i"
                                            :id="`efficiency${i}`"
                                            v-model="accomplishment.efficiency"
                                            required
                                        />
                                        <label :for="`efficiency${i}`">{{
                                            `${5 - i} - ${efficiency}`
                                        }}</label>
                                    </div>
                                </template>
                            </div>
                            <div
                                class="field"
                                v-if="core_function.timeliness.length > 0"
                            >
                                <div class="font-bold">Timeliness:</div>
                                <template
                                    v-for="(
                                        timeliness, i
                                    ) in core_function.timeliness"
                                    :key="i"
                                >
                                    <div v-if="timeliness">
                                        <input
                                            type="radio"
                                            name="timeliness"
                                            :value="5 - i"
                                            :id="`timeliness${i}`"
                                            v-model="accomplishment.timeliness"
                                            required
                                        />
                                        <label :for="`timeliness${i}`">{{
                                            `${5 - i} - ${timeliness}`
                                        }}</label>
                                    </div>
                                </template>
                            </div>
                            <div class="field">
                                <div class="font-bold">Percentage Weight:</div>
                                <!-- <InputNumber placeholder="-- % " /> -->
                                <InputNumber
                                    inputId="percent"
                                    v-model="accomplishment.percent"
                                    suffix="%"
                                    placeholder="--%"
                                    required
                                />
                            </div>
                            <div class="field">
                                <div class="font-bold">Remarks:</div>
                                <Textarea
                                    :autoResize="true"
                                    rows="5"
                                    class="w-full"
                                    placeholder="Enter remarks here."
                                    v-model="accomplishment.remarks"
                                />
                            </div>
                        </form>
                        <template #footer>
                            <Button
                                label="Cancel"
                                icon="pi pi-times"
                                @click="cancel_accomplishment()"
                                class="p-button-text"
                            />
                            <Button
                                label="Save"
                                icon="pi pi-check"
                                autofocus
                                type="submit"
                                form="accomplishment_form"
                            />
                        </template>
                    </Dialog>
                    <!-- add accomplishment modal end -->

                    <!-- not applicable modal start -->
                    <Dialog
                        header="Not Applicable"
                        v-model:visible="not_applicable_modal"
                        :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
                        :style="{ width: '50vw' }"
                        :modal="true"
                    >
                        <form
                            @submit.prevent="submit_not_applicable()"
                            id="not_applicable_form"
                        >
                            <!-- <div class="field">
              <div class="font-bold">Success Indicator:</div>
              <span>{{ core_function.success_indicator }}</span>
            </div> -->
                            <div class="field">
                                <div class="font-bold mb-2">Reason:</div>
                                <Textarea
                                    v-model="accomplishment.actual"
                                    :autoResize="true"
                                    rows="5"
                                    class="w-full"
                                    placeholder="Enter the reason why the success indicator is not applicable for accomplishment."
                                    required
                                />
                            </div>
                        </form>

                        <template #footer>
                            <Button
                                label="Cancel"
                                icon="pi pi-times"
                                @click="cancel_not_applicable()"
                                class="p-button-text"
                            />
                            <Button
                                label="Save"
                                icon="pi pi-check"
                                autofocus
                                type="submit"
                                form="not_applicable_form"
                            />
                        </template>
                    </Dialog>
                    <!-- not applicable modal end -->

                    <ConfirmDialog></ConfirmDialog>
                    <Toast />
                </template>
            </Card>
        </div>
    </AuthenticatedLayout>
</template>
<script>
export default {
    props: {
        form_status: null,
        period: null,
        rows: null,
        total_percentage_weight: null,
        total_average_rating: null,
    },

    data() {
        return {
            current_url: document.location.pathname,
            error: {},
            edit_accomplishment_modal: false,
            not_applicable_modal: false,
            core_function: null,
            // percentage_weight_remaining: null,
            accomplishment: this.$inertia.form({
                form_status: this.$props.form_status,
                id: null,
                pms_rsm_success_indicator_id: null,
                actual: null,
                quality: null,
                efficiency: null,
                timeliness: null,
                percent: null,
                remarks: null,
                not_applicable: null,
            }),
        };
    },
    methods: {
        not_applicable(row) {
            this.accomplishment.id = null;
            this.accomplishment.pms_rsm_success_indicator_id =
                row.pms_rsm_success_indicator_id;
            this.accomplishment.not_applicable = true;
            this.not_applicable_modal = true;
        },
        cancel_not_applicable() {
            this.not_applicable_modal = false;
            this.clear_accomplishment();
        },
        edit_not_applicable(row) {
            console.log(row);
            this.accomplishment.id = row.pms_pcr_core_function_data.id;
            this.accomplishment.pms_rsm_success_indicator_id =
                row.pms_rsm_success_indicator_id;
            this.accomplishment.actual = row.pms_pcr_core_function_data.actual;
            this.accomplishment.not_applicable = true;
            this.not_applicable_modal = true;
        },
        submit_not_applicable() {
            console.log(this.accomplishment);
            this.accomplishment.post(this.current_url + "/accomplishment", {
                preserveScroll: true,
                onSuccess: () => {
                    if (!this.accomplishment.id) {
                        this.$toast.add({
                            severity: "info",
                            summary: "Note!",
                            detail: "Success indicator marked as not applicable!",
                            life: 3000,
                        });
                    } else {
                        this.$toast.add({
                            severity: "info",
                            summary: "Updated!",
                            detail: "Reason updated!",
                            life: 3000,
                        });
                    }
                    this.not_applicable_modal = false;
                    this.clear_accomplishment();
                },
            });
        },
        submit_accomplishment() {
            this.accomplishment.post(this.current_url + "/accomplishment", {
                preserveScroll: true,
                onSuccess: () => {
                    if (!this.accomplishment.id) {
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
                    this.edit_accomplishment_modal = false;
                    this.clear_accomplishment();
                },
            });
        },
        add_accomplishment(row) {
            this.core_function = row;
            this.accomplishment.id = null;
            this.accomplishment.pms_rsm_success_indicator_id =
                row.pms_rsm_success_indicator_id;
            this.edit_accomplishment_modal = true;
        },
        cancel_accomplishment() {
            this.edit_accomplishment_modal = false;
            this.clear_accomplishment();
        },
        edit_accomplishment(row) {
            this.core_function = row;
            this.accomplishment.id = row.pms_pcr_core_function_data.id;
            this.accomplishment.pms_rsm_success_indicator_id =
                row.pms_rsm_success_indicator_id;
            this.accomplishment.actual = row.pms_pcr_core_function_data.actual;
            this.accomplishment.quality =
                row.pms_pcr_core_function_data.quality;
            this.accomplishment.efficiency =
                row.pms_pcr_core_function_data.efficiency;
            this.accomplishment.timeliness =
                row.pms_pcr_core_function_data.timeliness;
            this.accomplishment.percent =
                row.pms_pcr_core_function_data.percent;
            this.accomplishment.remarks =
                row.pms_pcr_core_function_data.remarks;
            this.edit_accomplishment_modal = true;
        },
        clear_accomplishment() {
            this.accomplishment.id = null;
            this.accomplishment.pms_rsm_success_indicator_id = null;
            this.accomplishment.actual = null;
            this.accomplishment.quality = null;
            this.accomplishment.efficiency = null;
            this.accomplishment.timeliness = null;
            this.accomplishment.percent = null;
            this.accomplishment.remarks = null;
            this.accomplishment.not_applicable = null;
        },
        confirm_accomplishment_reset(row) {
            this.$confirm.require({
                message:
                    "Resetting this accomplishment will empty its values, proceed?",
                header: "Reset Confirmation",
                icon: "pi pi-info-circle",
                acceptClass: "p-button-danger",
                accept: () => {
                    this.$inertia.delete(
                        this.current_url +
                            "/accomplishment/" +
                            row.pms_pcr_core_function_data.id,
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
        indent(level) {
            var margin = "";
            if (level > 0) {
                margin = "margin-left:" + level * 20 + "px;";
            }
            return margin;
        },

        validate() {},
        submit_form() {},
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
        this.$inertia.reload({ only: ["rows"] });
    },
    mounted() {},
};
</script>
