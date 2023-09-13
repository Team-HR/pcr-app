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
    <Head title="Rating Scale Matrix" />
    <AuthenticatedLayout>
        <!-- <auth-layout> -->
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Rating Scale Matrix /
                {{ `${$page.props.period.period}, ${$page.props.period.year}` }}
            </h2>
        </template>

        <div class="py-1"></div>
        <Card class="w-full">
            <template #title>
                <!-- <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <Button
                        size="small"
                        label="Back"
                        class="ml-5"
                        icon="bi bi-arrow-left"
                        @click="go_back()"
                        raised
                    ></Button>
                </div> -->

                <div class="w-full flex justify-center">
                    <i class="bi bi-book mr-2"></i>
                    <span>Department Rating Scale Matrix</span>
                </div>
            </template>
            <template #subtitle>
                <div class="w-full flex justify-center">
                    Edit or review your Department/Section's Rating Scale Matrix
                </div>
            </template>
            <template #content>
                <!-- ####################### Table Start########################### -->
                <div class="w-full mb-3">
                    <div class="text-center text-4xl">
                        {{ $page.props.auth.user.sys_department_name }}
                    </div>
                    <div class="text-center">
                        {{
                            `${$page.props.period.period}, ${$page.props.period.year}`
                        }}
                    </div>
                </div>
                <div style="overflow-x: auto">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th scope="col">MFO/PAP</th>
                                <th>Success Indicator</th>
                                <th>Performance Measure</th>
                                <th>Quality</th>
                                <th>Efficiency</th>
                                <th>Timeliness</th>
                                <th>In Charge</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <template v-for="(row, r) in rows" :key="r">
                            <!-- if  -->
                            <tr
                                v-if="row.rowspan == 0 && row.si_only == false"
                                :class="row.mfo_only ? 'bg-primary-50' : ''"
                            >
                                <td :colspan="row.mfo_only ? 8 : 1">
                                    <div :style="indent(row.level)">
                                        <Button
                                            type="button"
                                            class="p-button-tex p-button-text py-0 px-2 m-0 mr-2"
                                            @click="toggle($event, row.id)"
                                        >
                                            <i class="bi bi-gear"></i>
                                        </Button>
                                        <Menu
                                            :ref="`menu${row.id}`"
                                            :model="get_menu_items(row)"
                                            :popup="true"
                                        />
                                        <span>
                                            <strong class="mr-2">{{
                                                row.code
                                            }}</strong>
                                            {{ row.title }}
                                        </span>
                                    </div>
                                </td>
                                <template v-if="!row.mfo_only">
                                    <td>{{ row.success_indicator }}</td>
                                    <td
                                        v-html="
                                            performance_measures(
                                                row.performance_measures
                                            )
                                        "
                                    ></td>
                                    <td
                                        v-html="
                                            performance_measure_criteria(
                                                row.quality
                                            )
                                        "
                                    ></td>
                                    <td
                                        v-html="
                                            performance_measure_criteria(
                                                row.efficiency
                                            )
                                        "
                                    ></td>
                                    <td
                                        v-html="
                                            performance_measure_criteria(
                                                row.timeliness
                                            )
                                        "
                                    ></td>
                                    <td v-html="in_charge(row.in_charges)"></td>
                                    <td>
                                        <Button
                                            class="p-button-sm p-button-text p-button-success flex w-full"
                                            icon="bi bi-pencil"
                                            label="Edit"
                                            @click="edit_success_indicator(row)"
                                        ></Button>
                                        <Button
                                            class="p-button-sm p-button-text p-button-danger flex w-full"
                                            icon="bi bi-trash"
                                            label="Delete"
                                            @click="
                                                delete_success_indicator(row)
                                            "
                                        ></Button>
                                    </td>
                                </template>
                            </tr>
                            <tr
                                v-else-if="
                                    row.rowspan > 0 && row.si_only == false
                                "
                            >
                                <td :rowspan="row.rowspan">
                                    <div :style="indent(row.level)">
                                        <Button
                                            type="button"
                                            class="p-button-tex p-button-text py-0 px-2 m-0 mr-2"
                                            @click="toggle($event, row.id)"
                                        >
                                            <i class="bi bi-gear"></i>
                                        </Button>
                                        <Menu
                                            :ref="`menu${row.id}`"
                                            :model="get_menu_items(row)"
                                            :popup="true"
                                        />
                                        <span>
                                            <strong class="mr-2">{{
                                                row.code
                                            }}</strong>
                                            {{ row.title }}
                                        </span>
                                    </div>
                                </td>
                                <td>{{ row.success_indicator }}</td>
                                <td
                                    v-html="
                                        performance_measures(
                                            row.performance_measures
                                        )
                                    "
                                ></td>
                                <td
                                    v-html="
                                        performance_measure_criteria(
                                            row.quality
                                        )
                                    "
                                ></td>
                                <td
                                    v-html="
                                        performance_measure_criteria(
                                            row.efficiency
                                        )
                                    "
                                ></td>
                                <td
                                    v-html="
                                        performance_measure_criteria(
                                            row.timeliness
                                        )
                                    "
                                ></td>
                                <td v-html="in_charge(row.in_charges)"></td>
                                <td>
                                    <Button
                                        class="p-button-sm p-button-text p-button-success flex w-full"
                                        icon="bi bi-pencil"
                                        label="Edit"
                                        @click="edit_success_indicator(row)"
                                    ></Button>
                                    <Button
                                        class="p-button-sm p-button-text p-button-danger flex w-full"
                                        icon="bi bi-trash"
                                        label="Delete"
                                        @click="delete_success_indicator(row)"
                                    ></Button>
                                </td>
                            </tr>
                            <tr v-else>
                                <td>{{ row.success_indicator }}</td>
                                <td
                                    v-html="
                                        performance_measures(
                                            row.performance_measures
                                        )
                                    "
                                ></td>
                                <td
                                    v-html="
                                        performance_measure_criteria(
                                            row.quality
                                        )
                                    "
                                ></td>
                                <td
                                    v-html="
                                        performance_measure_criteria(
                                            row.efficiency
                                        )
                                    "
                                ></td>
                                <td
                                    v-html="
                                        performance_measure_criteria(
                                            row.timeliness
                                        )
                                    "
                                ></td>
                                <td v-html="in_charge(row.in_charges)"></td>
                                <td>
                                    <Button
                                        class="p-button-sm p-button-text p-button-success flex w-full"
                                        icon="bi bi-pencil"
                                        label="Edit"
                                        @click="edit_success_indicator(row)"
                                    ></Button>
                                    <Button
                                        class="p-button-sm p-button-text p-button-danger flex w-full"
                                        icon="bi bi-trash"
                                        label="Delete"
                                        @click="delete_success_indicator(row)"
                                    ></Button>
                                </td>
                            </tr>
                        </template>
                        <tr v-if="rows.length < 1">
                            <td
                                class="p-5 bg-gray-300"
                                colspan="8"
                                style="text-align: center"
                            >
                                No records found!
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- ####################### Table End ########################### -->

                <Button
                    class="my-5 p-button-sm"
                    icon="pi pi-plus"
                    label="Add New MFO/PAP"
                    @click="add_edit_modal = !add_edit_modal"
                ></Button>
                <!-- ############################       AddEdit Modal Start        ############################# -->
                <Dialog
                    :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
                    :header="form.id ? 'EDIT MFO/PAP' : 'ADD NEW MFO/PAP'"
                    v-model:visible="add_edit_modal"
                    :modal="true"
                    :style="{ width: '60%' }"
                >
                    <form
                        id="add_new_form"
                        class="card"
                        @submit.prevent="add_edit_submit()"
                    >
                        <div class="formgrid grid">
                            <div class="field col-12">
                                <label class="mr-2">Parent MFO/PAP:</label>
                                <br />
                                <Dropdown
                                    showClear
                                    v-model="form.parent_id"
                                    :options="parents"
                                    optionLabel="label"
                                    optionValue="id"
                                    placeholder="Select parent if available (Leave blank if none)"
                                />
                            </div>
                            <div class="field col-4">
                                <label>Code:</label>
                                <InputText
                                    class="w-full"
                                    type="text"
                                    v-model="form.code"
                                    placeholder="e.g. A., A.1., B.,B.1"
                                    required
                                />
                                <small class="ml-2">*Required</small>
                            </div>
                            <div class="field col-8">
                                <label>MFO/PAP Title:</label>
                                <InputText
                                    class="w-full"
                                    type="text"
                                    v-model="form.title"
                                    placeholder="e.g. Recruitment Services"
                                    required
                                />
                                <small class="ml-2">*Required</small>
                            </div>
                        </div>
                    </form>

                    <template #footer>
                        <Button
                            type="button"
                            label="No"
                            icon="pi pi-times"
                            class="p-button-text"
                            @click="add_edit_modal = false"
                        />
                        <Button
                            form="add_new_form"
                            type="submit"
                            label="Yes"
                            icon="pi pi-check"
                        />
                    </template>
                </Dialog>
                <!-- ############################       AddEdit Modal End        ############################# -->

                <Toast />
                <ConfirmDialog></ConfirmDialog>
            </template>
        </Card>
        <!-- </auth-layout> -->
    </AuthenticatedLayout>
</template>
<script>
export default {
    props: {
        auth: null,
        period: null,
        period_id: null,
        rows: null,
        parents: null,
    },
    components: {},

    data() {
        return {
            current_url: document.location.pathname,
            add_edit_modal: false,
            menu: [],
            form: this.$inertia.form({
                id: null,
                parent_id: null,
                code: null,
                title: null,
            }),
        };
    },
    watch: {
        add_edit_modal(newValue, oldValue) {
            if (!newValue) {
                this.clear_form();
            }
        },
    },
    methods: {
        go_back() {
            // console.log("test");
            window.history.back();
        },

        edit_success_indicator(row) {
            this.$inertia.get(
                "/pms/rsm/" +
                    this.period_id +
                    "/mfo/" +
                    row.id +
                    "/si/" +
                    row.success_indicator_id,
                {},
                { replace: true }
            );
        },
        delete_success_indicator(row) {
            this.$confirm.require({
                message: "Do you want to delete this Success Indicator?",
                header: "Delete Confirmation",
                icon: "pi pi-info-circle",
                acceptClass: "p-button-danger",
                accept: () => {
                    // console.log(id);
                    this.$inertia.delete(
                        "/pms/rsm/" +
                            this.period_id +
                            "/mfo/" +
                            row.id +
                            "/si/" +
                            row.success_indicator_id,
                        {
                            preserveScroll: true,
                            onSuccess: () => {
                                this.$toast.add({
                                    severity: "success",
                                    summary: "Deleted",
                                    detail: "Success Indicator deleted!",
                                    life: 3000,
                                });
                            },
                        }
                    );
                },
                // reject: () => {},
            });
        },
        add_edit_submit() {
            // if form.id is null, create new
            if (!this.form.id) {
                this.create();
            }
            // else form.id has value edit current
            else {
                this.update();
            }
        },

        create() {
            this.form.post(this.current_url, {
                preserveScroll: true,
                onSuccess: () => {
                    this.add_edit_modal = false;
                    this.clear_form();
                    this.$toast.add({
                        severity: "success",
                        summary: "Added",
                        detail: "New MFO/PAP added successfully!",
                        life: 3000,
                    });
                },
            });
        },

        update() {
            this.form.patch(this.current_url, {
                preserveScroll: true,
                onSuccess: () => {
                    this.add_edit_modal = false;
                    this.clear_form();
                    this.$toast.add({
                        severity: "success",
                        summary: "Updated",
                        detail: "MFO/PAP updated successfully!",
                        life: 3000,
                    });
                },
            });
        },

        destroy(id) {
            this.$inertia.delete(this.current_url + "/" + id, {
                preserveScroll: true,
                onSuccess: () => {
                    this.clear_form();
                    this.$toast.add({
                        severity: "success",
                        summary: "Deleted",
                        detail: "Successfully Deleteed!",
                        life: 3000,
                    });
                },
            });
        },

        clear_form() {
            this.form.id = null;
            this.form.parent_id = null;
            this.form.code = null;
            this.form.title = null;
        },
        toggle(event, id) {
            const menu = `menu${id}`;
            this.$refs[menu][0].toggle(event);
        },
        get_menu_items(row) {
            var items = [
                {
                    label: "MFO/PAP",
                    items: [
                        {
                            label: "Edit",
                            icon: "bi bi-input-cursor-text",
                            command: () => {
                                // console.log(row);
                                this.form.id = row.id;
                                this.form.parent_id = row.parent_id;
                                this.form.code = row.code;
                                this.form.title = row.title;
                                this.add_edit_modal = true;
                            },
                        },
                        {
                            label: "Delete",
                            icon: "bi bi-trash",
                            class: "p-menuitem-text text-red-700",
                            command: () => {
                                this.confirm_delete(row.id);
                            },
                        },
                    ],
                },
                {
                    label: "SUCCESS INDICATOR",
                    items: [
                        {
                            label: "Add New SI",
                            icon: "bi bi-rulers",
                            command: () => {
                                // console.log( `${this.current_url}/mfo/${row.id}/si`);
                                this.$inertia.get(
                                    `${this.current_url}/mfo/${row.id}/si`,
                                    {},
                                    { replace: true }
                                );
                            },
                        },
                    ],
                },
                {
                    label: "SUB-FUNCTION",
                    items: [
                        {
                            label: "Add New Sub",
                            icon: "bi bi-arrow-return-right",
                            command: () => {
                                this.form.id = null;
                                this.form.parent_id = row.id;
                                this.form.code = null;
                                this.form.title = null;
                                this.add_edit_modal = true;
                            },
                        },
                    ],
                },
            ];

            return items;
        },

        confirm_delete(id) {
            this.$confirm.require({
                message:
                    "Do you want to delete this record? Success Indicators will also be deleted, if has.",
                header: "Delete Confirmation",
                icon: "pi pi-info-circle",
                acceptClass: "p-button-danger",
                accept: () => {
                    this.destroy(id);
                },
                // reject: () => {},
            });
        },

        in_charge(arr) {
            var html = "";
            if (!arr) return html;
            for (let index = 0; index < arr.length; index++) {
                html += `${arr[index].full_name}` + "<br/>";
            }
            return html;
        },

        performance_measures(arr) {
            var html = "";
            if (!arr) return html;
            for (let index = 0; index < arr.length; index++) {
                html += arr[index] + "<br/>";
            }
            return html;
        },
        performance_measure_criteria(arr) {
            var html = "";
            if (!arr) return html;
            for (let index = 0; index < arr.length; index++) {
                if (arr[index]) {
                    html += `${5 - index} - ${arr[index]}` + "<br/>";
                }
            }
            return html;
        },
        indent(level) {
            var margin = "";
            if (level > 0) {
                margin = "margin-left:" + level * 20 + "px;";
            }
            return margin;
        },
    },
    mounted() {
        console.log(this.parents);
        this.$inertia.reload({ only: ["rows", "parents"] });
    },
};
</script>
