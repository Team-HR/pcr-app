<script setup>
    import Column from 'primevue/column';
    import Button from 'primevue/button';
    import DataTable from 'primevue/datatable';
    import Card from 'primevue/card';

</script>


<template>
    <Card class="w-full">
        <template #title> <i :class="icon"></i> <span> {{ title }}</span></template>
        <template #subtitle>{{ description }}</template>
        <template v-if="$page.props.auth.user.sys_employee_id" #content>

            <DataTable :value="periods" responsiveLayout="scroll" class="w-6 mx-auto">
                <Column field="year" header="Year">
                    <template #body="slotProp">
                        <span class="text-xl font-bold">{{ slotProp.data.year }}</span>
                    </template>
                </Column>
                <Column field="period1" header="1st Semester">
                    <template #body="slotProp">
                        <!-- {{ slotProp.data }} -->
                        <Button v-if="slotProp.data.period1"
                                class="p-button hover:bg-primary-900 bg-primary-600 m-2 p-3 p-button-raised"
                                label="January - June" @click="$inertia.get(path + slotProp.data.period1)" />
                    </template>
                </Column>
                <Column field="period2" header="2nd Semester">
                    <template #body="slotProp">
                        <!-- {{ slotProp.data }} -->
                        <Button v-if="slotProp.data.period2"
                                class="p-button hover:bg-red-900 bg-red-600 m-2 p-3 p-button-raised"
                                label="July - December" @click="$inertia.get(path + slotProp.data.period2)" />
                    </template>
                </Column>
            </DataTable>
        </template>
        <template v-else #content>
            <p class="text-red-700">*Only available for users with an associated employee ID.</p>
        </template>
    </Card>
</template>
<script>

export default {
    props: {
        icon: {
            type: String,
            default: "pi pi-question-circle"
        },
        title: {
            type: String,
            default: "{{ Title here }}"
        },
        description: {
            type: String,
            default: "{{ Description here }}"
        },
        path: ""
    },
    data() {
        return {
            period_id: null,
            periods: []
        };
    },
    computed: {
        years() {
            let years = [{
                year: 2023,
                period0Id: 1,
                period1Id: 2,
            }];
            // this.periods.forEach(element => {

            // });
            return years
        },
    },
    created() {
        axios('/api/pms/periods').then(({ data }) => {
            this.periods = data
        });
    }
};
</script>
