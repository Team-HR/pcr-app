<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PeriodSelector from "@/Components/PMS/PeriodSelector.vue";
import axios from "axios";

import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Setup Support Functions" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Setup Support Functions |
                <span>{{ period.period }} {{ period.year }}</span>
            </h2>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <Card class="mx-auto">
                    <template #title
                        ><i class="bi bi-gear"></i> Setup : Setup Support
                        Functions</template
                    >
                    <template #subtitle
                        >Setup Support Functions for this period</template
                    >fg ik1
                    <template #content>
                        <Dropdown
                            v-model="form.form_type"
                            :options="formTypes"
                            optionLabel="name"
                            placeholder="Select the form type"
                            class="w-full md:w-14rem"
                            @change="getSupportFunctions()"
                        />
                        <br />
                        <Button
                            :disabled="form.form_type.name == null"
                            @click="addSupportFunction()"
                            label="Add"
                            icon="pi pi-plus"
                            class="my-3"
                        />

                        <!-- <h3>
                    {{ form.form_type.name }}
                </h3> -->
                        <!-- {{ percentTotal }} -->
                        <DataTable
                            class="p-datatable-small"
                            :value="supportFunctions"
                        >
                            <Column
                                field="percent"
                                :header="`(${percentTotal}%) Weight`"
                                class="text-center"
                            >
                                <template #body="slotProps">
                                    {{ slotProps.data.percent }}%
                                </template>
                            </Column>
                            <Column
                                field="support_function"
                                header="Support Function"
                            ></Column>
                            <Column
                                field="success_indicator"
                                header="Success Indicator"
                            ></Column>
                            <Column header="" bodyClass="">
                                <template #body="slotProps">
                                    <div class="w-full flex flex-nowrap">
                                        <Button
                                            class="mr-2"
                                            label="Edit"
                                            @click="
                                                editSupportFunction(
                                                    slotProps.data
                                                )
                                            "
                                            size="small"
                                            text
                                            raised
                                            icon="pi pi-pencil"
                                        ></Button>

                                        <Button
                                            severity="danger"
                                            @click="
                                                prompt_delete(slotProps.data)
                                            "
                                            size="small"
                                            text
                                            raised
                                            icon="pi pi-trash"
                                            label="Delete"
                                        ></Button>
                                    </div>
                                </template>
                            </Column>
                        </DataTable>

                        <Dialog
                            v-model:visible="addDialog"
                            modal
                            :header="
                                !form.id
                                    ? 'Add New Support Function'
                                    : 'Edit Support Function'
                            "
                            :style="{ width: '50vw' }"
                        >
                            <form @submit.prevent="submitAddSupportFunction()">
                                <div class="formgrid grid">
                                    <div class="field col-12">
                                        <label>Support Function:</label>
                                        <small class="ml-2">*Required</small>
                                        <br />
                                        <Textarea
                                            class="w-full"
                                            v-model="form.support_function"
                                            rows="5"
                                            :autoResize="true"
                                            placeholder="Enter support functions here..."
                                        />
                                    </div>
                                    <div class="field col-12">
                                        <label>Success Indicator:</label>
                                        <small class="ml-2">*Required</small>
                                        <br />
                                        <Textarea
                                            class="w-full"
                                            v-model="form.success_indicator"
                                            rows="5"
                                            :autoResize="true"
                                            placeholder="Enter success indicator here..."
                                        />
                                    </div>
                                    <div class="field col-12">
                                        <label>Percent:</label>
                                        <small class="ml-2">*Required</small>
                                        <br />
                                        <!-- <InputText type="number" class="w-3" v-model="form.percent" rows="5"
                                           placeholder="__ %" /> -->

                                        <InputNumber
                                            v-model="form.percent"
                                            inputId="percent"
                                            suffix="%"
                                            placeholder="__ %"
                                        />
                                    </div>
                                    <div class="field col-12">
                                        <label>Measures:</label>
                                        <small class="ml-2">*Required</small>

                                        <div class="field-checkbox">
                                            <Checkbox
                                                id="quality"
                                                name="quality"
                                                binary
                                                v-model="has_quality"
                                            />
                                            <label for="quality">Quality</label>
                                        </div>
                                        <div class="field-checkbox">
                                            <Checkbox
                                                id="efficiency"
                                                name="efficiency"
                                                binary
                                                v-model="has_efficiency"
                                            />
                                            <label for="efficiency"
                                                >Efficiency</label
                                            >
                                        </div>
                                        <div class="field-checkbox">
                                            <Checkbox
                                                id="timeliness"
                                                name="timeliness"
                                                binary
                                                v-model="has_timeliness"
                                            />
                                            <label for="timeliness"
                                                >Timeliness</label
                                            >
                                        </div>

                                        <div class="formgrid grid">
                                            <div
                                                class="ffield col-12 md:col-4"
                                                :hidden="!has_quality"
                                            >
                                                <label>Quality:</label>
                                                <div
                                                    class="p-inputgroup mb-1"
                                                    v-for="(i, k) in 5"
                                                    :key="k"
                                                >
                                                    <span
                                                        class="p-inputgroup-addon"
                                                    >
                                                        {{ 5 - i + 1 }}
                                                    </span>
                                                    <InputText
                                                        @update:model-value="
                                                            readRatingScaleInputText(
                                                                'quality',
                                                                k
                                                            )
                                                        "
                                                        v-model="
                                                            form.quality[k]
                                                        "
                                                    />
                                                </div>
                                            </div>
                                            <div
                                                class="field col-12 md:col-4"
                                                :hidden="!has_efficiency"
                                            >
                                                <label>Efficiency:</label>
                                                <div
                                                    class="p-inputgroup mb-1"
                                                    v-for="(i, k) in 5"
                                                    :key="k"
                                                >
                                                    <span
                                                        class="p-inputgroup-addon"
                                                    >
                                                        {{ 5 - i + 1 }}
                                                    </span>
                                                    <!-- ref="readEfficiencyInputText" -->
                                                    <InputText
                                                        @update:model-value="
                                                            readRatingScaleInputText(
                                                                'efficiency',
                                                                k
                                                            )
                                                        "
                                                        v-model="
                                                            form.efficiency[k]
                                                        "
                                                    />
                                                </div>
                                            </div>
                                            <div
                                                class="field col-12 md:col-4"
                                                :hidden="!has_timeliness"
                                            >
                                                <label>Timeliness:</label>
                                                <div
                                                    class="p-inputgroup mb-1"
                                                    v-for="(i, k) in 5"
                                                    :key="k"
                                                >
                                                    <span
                                                        class="p-inputgroup-addon"
                                                    >
                                                        {{ 5 - i + 1 }}
                                                    </span>
                                                    <InputText
                                                        @update:model-value="
                                                            readRatingScaleInputText(
                                                                'timeliness',
                                                                k
                                                            )
                                                        "
                                                        v-model="
                                                            form.timeliness[k]
                                                        "
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="field col-12 bg-yellow-100 w-full p-3"
                                        :hidden="suggestions.list.length < 1"
                                    >
                                        <div class="mb-2">Suggestions:</div>

                                        <div class="w-full flex flex-wrap">
                                            <template
                                                v-for="(
                                                    item, i
                                                ) in suggestions.list"
                                                :key="i"
                                            >
                                                <Card
                                                    class="hover:bg-indigo-700 hover:text-white cursor-pointer mx-2"
                                                    @click="
                                                        pickSuggestion(item)
                                                    "
                                                >
                                                    <template #content>
                                                        <template
                                                            v-for="(
                                                                measure, m
                                                            ) in item"
                                                            :key="m"
                                                        >
                                                            <tr
                                                                v-if="measure"
                                                                border="1"
                                                            >
                                                                <td border="1">
                                                                    <div
                                                                        class="mx-2 font-bold"
                                                                    >
                                                                        {{
                                                                            5 -
                                                                            m
                                                                        }}
                                                                    </div>
                                                                </td>
                                                                <td border="1">
                                                                    {{
                                                                        measure
                                                                    }}
                                                                </td>
                                                            </tr>
                                                        </template>
                                                    </template>
                                                </Card>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-column">
                                    <Button
                                        type="submit"
                                        label="Save"
                                        class="mr-2"
                                    ></Button>
                                    <Button
                                        type="button"
                                        @click="
                                            cancelSubmitAddSupportFunction()
                                        "
                                        label="Cancel"
                                        severity="secondary"
                                    ></Button>
                                </div>
                            </form>
                        </Dialog>
                        <ConfirmDialog />
                        <Toast />
                    </template>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script>
import { ref, nextTick } from "vue";

export default {
    props: {
        period: Object,
    },
    data() {
        return {
            current_url: document.location.pathname,
            has_quality: false,
            has_efficiency: false,
            has_timeliness: false,
            form: this.$inertia.form({
                id: null,
                support_function: null,
                success_indicator: null,
                quality: [],
                efficiency: [],
                timeliness: [],
                percent: null,
                form_type: { name: "IPCR", code: "ipcr" },
            }),
            supportFunction: this.$inertia.form({
                support_function: null,
                success_indicator: null,
                form_type: {},
            }),
            addDialog: false,
            supportFunctions: [],
            formTypes: [
                { name: "IPCR", code: "ipcr" },
                { name: "SPCR", code: "spcr" },
                { name: "DIVISION SPCR", code: "dspcr" },
                { name: "DPCR", code: "dpcr" },
            ],

            suggestions: {
                type: "",
                list: [],
            },
        };
    },
    watch: {
        addDialog(newValue, oldValue) {
            if (!newValue) {
                this.clearSupportFunctionForm();
            }
        },
    },
    computed: {
        percentTotal() {
            let percent = 0;

            this.supportFunctions.forEach((element) => {
                percent += element.percent;
            });

            return percent;
        },
    },
    methods: {
        prompt_delete(row) {
            // console.log("/pms/settings/support_function/" + row.id);
            // return false;
            this.$confirm.require({
                message: "Are you sure you want to delete this record?",
                header: "Delete Confirmation",
                icon: "pi pi-info-circle",
                acceptClass: "p-button-danger",
                accept: () => {
                    this.$inertia.delete(
                        "/pms/settings/support_function/" + row.id,
                        {
                            preserveScroll: true,
                            onSuccess: () => {
                                this.$toast.add({
                                    severity: "success",
                                    summary: "Deleted",
                                    detail: "Support function deleted!",
                                    life: 3000,
                                });
                                this.getSupportFunctions();
                            },
                        }
                    );
                },
                // reject: () => {},
            });
        },
        pickSuggestion(item) {
            this.form[this.suggestions.type] = item;
            // clear this.suggestions after selecting
            this.suggestions.type = "";
            this.suggestions.list = [];
        },

        readRatingScaleInputText(type, k) {
            nextTick(() => {
                this.getSimilarRatingScaleMeasures(type, k);
            });
        },

        getSimilarRatingScaleMeasures(type, k) {
            const val = this.form[type][k];
            axios
                .post(this.current_url + "/getSimilarRatingScaleMeasures", {
                    type: type,
                    val: val,
                })
                .then(({ data }) => {
                    this.suggestions.type = type;
                    this.suggestions.list = data.suggestions;
                })
                .catch((err) => {
                    console.error(err);
                });
        },

        addSupportFunction() {
            this.addDialog = true;
        },

        submitAddSupportFunction() {
            this.form.post(this.current_url + "/create", {
                preserveScroll: true,
                onSuccess: () => {
                    var msg = !this.form.id
                        ? "New support function added!"
                        : "Support function updated!";
                    this.$toast.add({
                        severity: "success",
                        summary: "Success!",
                        detail: msg,
                        life: 3000,
                    });
                    this.cancelSubmitAddSupportFunction();
                    this.getSupportFunctions();
                },
            });
        },

        cancelSubmitAddSupportFunction() {
            this.addDialog = false;
        },

        clearSupportFunctionForm() {
            this.has_quality = false;
            this.has_efficiency = false;
            this.has_timeliness = false;
            this.form.id = null;
            this.form.support_function = null;
            this.form.success_indicator = null;
            this.form.quality = [];
            this.form.efficiency = [];
            this.form.timeliness = [];
            this.form.percent = null;
        },

        getSupportFunctions() {
            const form_type = this.form.form_type;
            axios
                .post(this.current_url, {
                    form_type: form_type,
                })
                .then(({ data }) => {
                    this.supportFunctions = data;
                })
                .catch((err) => {
                    console.error(err);
                });
        },

        editSupportFunction(data) {
            this.addDialog = true;
            this.form.id = data.id;
            this.form.support_function = data.support_function;
            this.form.success_indicator = data.success_indicator;
            this.form.quality = data.quality;
            this.form.efficiency = data.efficiency;
            this.form.timeliness = data.timeliness;
            this.form.percent = data.percent;

            if (data.quality.length > 0) {
                this.has_quality = true;
            }

            if (data.efficiency.length > 0) {
                this.has_efficiency = true;
            }

            if (data.timeliness.length > 0) {
                this.has_timeliness = true;
            }
        },
    },
    mounted() {
        this.getSupportFunctions();
    },
};
</script>
