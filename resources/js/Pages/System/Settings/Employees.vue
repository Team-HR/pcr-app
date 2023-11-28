<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";

import axios from "axios";
import { watch } from "vue";
import { ref, reactive, onMounted } from "vue";
import { FilterMatchMode } from "primevue/api";

defineProps({ employees: Array });

const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    // name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    // 'country.name': { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    // representative: { value: null, matchMode: FilterMatchMode.IN },
    // status: { value: null, matchMode: FilterMatchMode.EQUALS },
    // verified: { value: null, matchMode: FilterMatchMode.EQUALS }
});

var addEditModal = reactive({
    is_visible: false,
    state: "",
    form: {
        id: null,
        username: null,
        last_name: null,
        first_name: null,
        middle_name: null,
        ext_name: null,
        gender: null,
    },
});

var genders = ref([
    {
        name: "MALE",
        code: "MALE",
    },
    {
        name: "FEMALE",
        code: "FEMALE",
    },
]);

function submit() {
    router.post("/system/settings/employees", addEditModal.form, {
        onFinish: (visit) => {
            // console.log(visit);
            addEditModal.is_visible = false;
        },
    });
}

function addEditEmployee(employee = null) {
    console.log(employee);
    if (!employee) {
        addEditModal.is_visible = true;
        addEditModal.state = "Add New Employee";
    } else {
        addEditModal.is_visible = true;
        addEditModal.state = "Edit Employee";
        var gender = null;
        if (employee.gender) {
            gender =
                employee.gender == "MALE"
                    ? {
                          name: "MALE",
                          code: "MALE",
                      }
                    : {
                          name: "FEMALE",
                          code: "FEMALE",
                      };
        }
        addEditModal.form.id = employee.id;
        addEditModal.form.username = employee.account
            ? employee.account.username
            : null;
        addEditModal.form.last_name = employee.last_name;
        addEditModal.form.first_name = employee.first_name;
        addEditModal.form.middle_name = employee.middle_name;
        addEditModal.form.ext_name = employee.ext_name;
        addEditModal.form.gender = gender;
    }

    // axios.get("/api/list/employees").then(({ data }) => {
    //     console.log("employees: ", data);
    //     employees = data;
    // });
}

function createUsername(employee) {
    console.log(employee);
}

watch(
    () => addEditModal.is_visible,
    (is_visible) => {
        // clear form on modal close
        if (!is_visible) {
            addEditModal.form.id = null;
            addEditModal.form.username = null;
            addEditModal.form.last_name = null;
            addEditModal.form.first_name = null;
            addEditModal.form.middle_name = null;
            addEditModal.form.ext_name = null;
            addEditModal.form.gender = null;
        }
    }
);

// onMounted(() => {
//     get_employees();
// });

// router.reload({ only: ["employees"] });
</script>

<template>
    <Head title="System-Employees" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                System / Settings / Employees
            </h2>
        </template>

        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card class="mx-auto">
                    <template #title>
                        <!-- <i class="bi bi-gear"></i>
                        <span> Settings</span> -->
                        <Button
                            label="Add New"
                            @click="addEditEmployee()"
                        ></Button>
                    </template>
                    <template #subtitle>
                        <!-- <span>Configure system-wide parameters</span> -->
                    </template>
                    <template #content>
                        <Dialog
                            v-model:visible="addEditModal.is_visible"
                            modal
                            :header="addEditModal.state"
                            :style="{ width: '50vw' }"
                        >
                            <div class="fields flex">
                                <div class="col-4 flex flex-column gap-2">
                                    <label for="empId">Employee ID:</label>
                                    <InputText
                                        id="empId"
                                        v-model="addEditModal.form.id"
                                        aria-describedby="empId-help"
                                        placeholder="Leave blank if new"
                                        size="small"
                                    />
                                    <!-- <small id="empId-help">(Optional)</small> -->
                                </div>
                                <div class="col-4 flex flex-column gap-2">
                                    <label for="username">Username:</label>
                                    <InputText
                                        id="username"
                                        v-model="addEditModal.form.username"
                                        aria-describedby="username-help"
                                        placeholder="e.g. jdelacruz"
                                        size="small"
                                    />
                                    <small id="username-help">(Optional)</small>
                                </div>
                            </div>

                            <div class="fields flex">
                                <div class="col-4 flex flex-column gap-2">
                                    <label for="lname">Last Name:</label>
                                    <InputText
                                        id="lname"
                                        v-model="addEditModal.form.last_name"
                                        aria-describedby="lname-help"
                                        placeholder="Enter last name"
                                        size="small"
                                    />
                                    <small id="lname-help">* Required</small>
                                </div>

                                <div class="col-4 flex flex-column gap-2">
                                    <label for="fname">First Name:</label>
                                    <InputText
                                        id="fname"
                                        v-model="addEditModal.form.first_name"
                                        aria-describedby="fname-help"
                                        placeholder="Enter first name"
                                        size="small"
                                    />
                                    <small id="fname-help">* Required</small>
                                </div>

                                <div class="col-4 flex flex-column gap-2">
                                    <label for="mname">Middle Name:</label>
                                    <InputText
                                        id="mname"
                                        v-model="addEditModal.form.middle_name"
                                        aria-describedby="mname-help"
                                        placeholder="Enter middle name"
                                        size="small"
                                    />
                                    <small id="mname-help">(Optional)</small>
                                </div>
                            </div>
                            <div class="fields flex">
                                <div class="col-4 flex flex-column gap-2">
                                    <label for="extName">Name ext:</label>
                                    <InputText
                                        id="extName"
                                        v-model="addEditModal.form.ext_name"
                                        aria-describedby="extName-help"
                                        placeholder="Enter name extension"
                                        size="small"
                                    />
                                    <small id="extName-help">(Optional)</small>
                                </div>
                                <div class="col-4 flex flex-column gap-2">
                                    <label for="gender">Gender:</label>
                                    <Dropdown
                                        id="gender"
                                        v-model="addEditModal.form.gender"
                                        :options="genders"
                                        optionLabel="name"
                                        aria-describedby="gender-help"
                                        placeholder="Select gender"
                                        size="small"
                                    />
                                    <small id="gender-help">* Required</small>
                                </div>
                            </div>

                            <template #footer>
                                <Button
                                    label="No"
                                    icon="pi pi-times"
                                    @click="addEditModal.is_visible = false"
                                    text
                                />
                                <Button
                                    label="Yes"
                                    icon="pi pi-check"
                                    @click="submit()"
                                    autofocus
                                />
                            </template>
                        </Dialog>

                        <div class="flex flex-wrap">
                            <!-- <Register /> -->
                            <DataTable
                                v-model:filters="filters"
                                :value="employees"
                                class="w-full"
                                paginator
                                :rows="5"
                                :rowsPerPageOptions="[5, 10, 20, 50]"
                                :globalFilterFields="[
                                    'full_name',
                                    // 'country.name',
                                    // 'representative.name',
                                    // 'status',
                                ]"
                            >
                                <template #header>
                                    <div class="flex justify-content-end">
                                        <span class="p-input-icon-left">
                                            <i class="pi pi-search" />
                                            <InputText
                                                v-model="
                                                    filters['global'].value
                                                "
                                                placeholder="Search Name"
                                                clearable
                                            />
                                        </span>
                                    </div>
                                </template>
                                <Column
                                    field="id"
                                    header="Employee ID"
                                ></Column>
                                <Column
                                    field="account.username"
                                    header="Username"
                                >
                                    <template #body="slotProps">
                                        <div v-if="slotProps.data.account">
                                            {{
                                                slotProps.data.account.username
                                            }}
                                        </div>
                                        <div v-else>----</div>
                                    </template>
                                </Column>
                                <Column
                                    field="full_name"
                                    header="Name"
                                    body-class="uppercase"
                                ></Column>
                                <Column field="gender" header="Gender"></Column>
                                <Column header="Options">
                                    <template #body="slotProps">
                                        <Button
                                            label="Edit"
                                            @click="
                                                addEditEmployee(slotProps.data)
                                            "
                                        ></Button>
                                    </template>
                                </Column>
                            </DataTable>
                        </div>
                    </template>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
