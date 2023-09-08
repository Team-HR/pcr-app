<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import EmployeePicker from "@/Components/EmployeePicker.vue";
</script>

<template>
    <Head title="Success Indicator Editor" />
    <AuthenticatedLayout>
        <!-- <auth-layout> -->
        <Card class="w-full">
            <template #title>
                <span
                    ><i class="bi bi-book mr-2"></i> Rating Scale Matrix |
                    Success Indicator</span
                >
            </template>
            <template #subtitle>Add/Edit/Delete Success Indicator/s</template>
            <template #content>
                <Button
                    label="Cancel"
                    icon="bi bi-arrow-left"
                    class="p-button-danger p-button-sm p-button-text p-button-raised mx-3"
                    @click="go_back()"
                ></Button>

                <Button
                    label="Save"
                    icon="bi bi-save"
                    class="p-button-success p-button-sm p-button-raised"
                    :disabled="!form.success_indicator"
                    @click="save_form()"
                ></Button>

                <div class="m-5">
                    <div class="text-xl w-full mb-2">
                        <span class="mr-3">MFO/PAP:</span>
                        <span>{{ $page.props.mfo.code }})</span>
                        {{ ` ` }}
                        <span>{{ $page.props.mfo.title }}</span>
                        <br />
                    </div>

                    <!-- AddEdit form start -->

                    <form
                        id="add_edit_form"
                        @submit.prevent="add_edit_submit()"
                    >
                        <div class="formgrid grid">
                            <div class="field col-12">
                                <label>Success Indicator:</label>
                                <small class="ml-2">*Required</small>
                                <br />
                                <Textarea
                                    class="w-full"
                                    v-model="form.success_indicator"
                                    rows="5"
                                    :autoResize="true"
                                    placeholder="Example: 100% (_/_) of applicant requirements prepared..."
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
                                    <label for="efficiency">Efficiency</label>
                                </div>
                                <div class="field-checkbox">
                                    <Checkbox
                                        id="timeliness"
                                        name="timeliness"
                                        binary
                                        v-model="has_timeliness"
                                    />
                                    <label for="timeliness">Timeliness</label>
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
                                            <span class="p-inputgroup-addon">
                                                {{ 5 - i + 1 }}
                                            </span>
                                            <InputText
                                                v-model="form.quality[k]"
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
                                            <span class="p-inputgroup-addon">
                                                {{ 5 - i + 1 }}
                                            </span>
                                            <InputText
                                                v-model="form.efficiency[k]"
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
                                            <span class="p-inputgroup-addon">
                                                {{ 5 - i + 1 }}
                                            </span>
                                            <InputText
                                                v-model="form.timeliness[k]"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="field col-12">
                                <label>In-Charge:</label>
                                <small class="ml-2">*Required</small>
                                <br />
                                <EmployeePicker
                                    :initSelections="form.in_charges"
                                    :options="employees"
                                    @changed="getEmployeePicks"
                                />
                            </div>
                        </div>
                    </form>

                    <!-- AddEdit form end -->
                </div>
            </template>
        </Card>
        <!-- </auth-layout> -->
    </AuthenticatedLayout>
</template>
<script>

export default {
    props: {
        periods: null,
        employees: null,
        success_indicator: null,
    },

    data() {
        return {
            current_url: document.location.pathname,
            period_id: null,
            has_quality: false,
            has_efficiency: false,
            has_timeliness: false,
            in_charge: null,
            form: this.$inertia.form({
                id: null,
                success_indicator: null,
                quality: [],
                efficiency: [],
                timeliness: [],
                in_charges: [],
            }),
        };
    },
    methods: {
        getEmployeePicks(value) {
            // console.log(this.form);
            this.form.in_charges = value;
        },
        go_back(toast) {
            var pathname = document.location.pathname;
            pathname = pathname.split("/");
            pathname = `/${pathname[1]}/${pathname[2]}/${pathname[3]}`;
            this.$inertia.get(
                pathname,
                {},
                {
                    replace: true,
                    onSuccess: () => {
                        if (toast) {
                            this.$toast.add(toast);
                        }
                    },
                }
            );
        },
        save_form() {
            if (!this.form.id) {
                this.form.post(this.current_url, {
                    onSuccess: () => {
                        this.go_back({
                            severity: "success",
                            summary: "Added",
                            detail: "New success indicator added successfully!",
                            life: 3000,
                        });
                    },
                });
            } else {
                this.form.patch(this.current_url, {
                    onSuccess: () => {
                        this.go_back({
                            severity: "success",
                            summary: "Updated",
                            detail: "Updated success indicator successfully!",
                            life: 3000,
                        });
                    },
                });
            }
        },
    },
    created() {
        if (this.success_indicator) {
            this.form.id = this.success_indicator.id;
            this.form.success_indicator =
                this.success_indicator.success_indicator;

            if (this.success_indicator.quality.length > 0) {
                this.has_quality = true;
                this.form.quality = this.success_indicator.quality;
            }
            if (this.success_indicator.efficiency.length > 0) {
                this.has_efficiency = true;
                this.form.efficiency = this.success_indicator.efficiency;
            }
            if (this.success_indicator.timeliness.length > 0) {
                this.has_timeliness = true;
                this.form.timeliness = this.success_indicator.timeliness;
            }

            this.form.in_charges = this.success_indicator.in_charges;
        }
    },
};
</script>
