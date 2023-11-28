<script setup>
import Column from "primevue/column";
import Button from "primevue/button";
import DataTable from "primevue/datatable";
import Card from "primevue/card";
</script>

<template>
    <Card class="w-full">
        <template #title>
            <i :class="icon"></i> <span> {{ title }}</span></template
        >
        <template #subtitle>{{ description }}</template>
        <template v-if="$page.props.auth.user.sys_employee_id" #content>
            <!-- :hidden="!periods" -->

            <div v-if="!periods" class="w-full flex justify-center">
                <!-- <Skeleton width="4rem" height="2rem"></Skeleton> -->
                <Skeleton style="width: 540px; height: 200px"></Skeleton>
                <!-- <div class="bg-gray-400" style="width: 540px; height: 200px;"></div> -->
            </div>

            <div class="w-full flex justify-center">
                <DataTable
                    :value="periods"
                    responsiveLayout="scroll"
                    class="p-datatable-small w-6"
                    :hidden="!periods"
                >
                    <Column field="year">
                        <template #header>
                            <div class="w-full text-center">Year</div>
                        </template>
                        <template #body="slotProp">
                            <div class="text-center">
                                <span class="text-xl font-bold">{{
                                    slotProp.data.year
                                }}</span>
                            </div>
                        </template>
                    </Column>
                    <Column field="period1">
                        <template #header>
                            <div class="w-full text-center">1st Semester</div>
                        </template>
                        <template #body="slotProp">
                            <div class="w-full flex justify-content-center">
                                <Button
                                    v-if="slotProp.data.period1"
                                    icon="pi pi-calendar"
                                    severity="info"
                                    label="January - June"
                                    @click="
                                        $inertia.get(
                                            path + slotProp.data.period1
                                        )
                                    "
                                    text
                                    raised
                                />
                            </div>
                        </template>
                    </Column>
                    <Column field="period2">
                        <template #header bodyClass="text-green-700">
                            <div class="w-full text-center">2nd Semester</div>
                        </template>
                        <template #body="slotProp">
                            <!-- {{ slotProp.data }} -->
                            <div class="w-full flex justify-content-center">
                                <Button
                                    v-if="slotProp.data.period2"
                                    icon="pi pi-calendar"
                                    severity="danger"
                                    label="July - December"
                                    @click="
                                        $inertia.get(
                                            path + slotProp.data.period2
                                        )
                                    "
                                    text
                                    raised
                                />
                            </div>
                        </template>
                    </Column>
                </DataTable>
            </div>
        </template>
        <template v-else #content>
            <p class="text-red-700">
                *Only available for users with an associated employee ID.
            </p>
        </template>
    </Card>
</template>
<script>
export default {
    props: {
        icon: {
            type: String,
            default: "pi pi-question-circle",
        },
        title: {
            type: String,
            default: "{{ Title here }}",
        },
        description: {
            type: String,
            default: "{{ Description here }}",
        },
        path: "",
    },
    data() {
        return {
            period_id: null,
            periods: null,
        };
    },
    computed: {
        years() {
            let years = [
                {
                    year: 2023,
                    period0Id: 1,
                    period1Id: 2,
                },
            ];
            // this.periods.forEach(element => {

            // });
            return years;
        },
    },
    created() {
        axios("/api/pms/periods").then(({ data }) => {
            this.periods = data;
        });
    },
};
</script>
