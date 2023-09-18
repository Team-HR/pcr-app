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
import FormTypeEditor from "@/Components/PMS/PCR/FormTypeEditor.vue";
// import SignatoriesEditor from '@/Components/PMS/PCR/SignatoriesEditor.vue';
// import StrategicFunctionEditor from '@/Components/PMS/PCR/StrategicFunctionEditor.vue';
import CoreFunctionsEditor from '@/Components/PMS/PCR/CoreFunctionsEditor.vue';
</script>

<template>
    <div>
        <!-- formtype setup start -->
        <FormTypeEditor />
        <!-- formtype setup end -->

        <!-- signatories setup start -->
        <!-- <SignatoriesEditor :pms_pcr_status="pms_pcr_status" /> -->
        <!-- signatories setup end -->

        <!-- table strategic function start -->
        <!-- <StrategicFunctionEditor :pms_pcr_status="pms_pcr_status" /> -->
        <!-- table strategic function end -->

        <!-- table core function start -->
        <CoreFunctionsEditor :pms_pcr_status="pms_pcr_status" />
        <!-- table core functions end -->

        <!-- table support function start -->
        <table class="mt-3 w-full">
            <thead>
                <tr>
                    <th
                        colspan="11"
                        class="text-left uppercase bg-indigo-500 text-white"
                    >
                        Support Functions
                    </th>
                </tr>
                <tr>
                    <th>{{ support_functions.total_percentage_weight }}%</th>
                    <th>Support Function</th>
                    <th>Success Indicator</th>
                    <th>Actual Accomplishment</th>
                    <th style="width: 40px">Q</th>
                    <th style="width: 40px">E</th>
                    <th style="width: 40px">T</th>
                    <th style="width: 40px">
                        A ({{
                            support_functions.total_numerical_rating
                                ? support_functions.total_numerical_rating
                                : ""
                        }})
                    </th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="!rows_support">
                    <td class="text-center bg-gray-300 p-5" colspan="9">
                        No records found! Please setup the support functions.
                    </td>
                </tr>
                <tr v-for="(row, i) in rows_support" :key="i">
                    <!-- <td colspan="8">{{row}}</td> -->
                    <td class="text-center">{{ row.percent }}%</td>
                    <td class="">{{ row.support_function }}</td>
                    <td class="">{{ row.success_indicator }}</td>
                    <template v-if="row.id">
                        <td class="">{{ row.accomplishment }}</td>
                        <td class="text-center">{{ row.quality }}</td>
                        <td class="text-center">{{ row.efficiency }}</td>
                        <td class="text-center">{{ row.timeliness }}</td>
                        <td class="text-center">{{ row.average }}</td>
                        <td class="text-center">
                            <Button
                                label="Edit"
                                class="p-button-text p-button-primary p-button-small w-4 p-1"
                                icon="bi bi-pencil-square"
                                @click="openAddEditModal(row)"
                            />
                            <Button
                                label="Clear"
                                class="p-button-text p-button-warning p-button-small w-4 p-1"
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
                                class="p-button-raised p-button-text p-button-small w-4 p-1"
                                icon="bi bi-check2-circle"
                                @click="openAddEditModal(row)"
                            />
                        </td>
                    </template>
                </tr>
            </tbody>
        </table>
        <!-- table support function end -->
    </div>
</template>
<script>
import axios from "axios";

export default {
    props: ["pms_pcr_status"],
    components: {
        // FormTypeEditor,
        // SignatoriesEditor,
        // StrategicFunctionEditor,
        // CodeFunctionsEditor
    },
    // emits: ["update:modelValue"],
    data() {
        return {
            core_functions: {},
            support_functions: {},
            rows: [],
            rows_strat: [],
            rows_support: [],
            // content: this.modelValue,
        };
    },
    methods: {
        // changeInput(event) {
        //   this.$emit("update:modelValue", event.target.value); // previously was `this.$emit('input', title)`
        // },

        indent(level) {
            var margin = "";
            if (level > 0) {
                margin = "margin-left:" + level * 20 + "px;";
            }
            return margin;
        },
    },

    // created() {
    //   axios.post("/api/pms/pcr_data", {
    //     pms_pcr_status: this.pms_pcr_status,
    //   }).then(({ data }) => {
    //     // console.log(data);
    //     // this.core_functions = data
    //     // this.rows = data.rows
    //     // this.rows_strat = data.rows_strat
    //     // this.support_functions = data.rows_support
    //     // this.rows_support = data.rows_support.data
    //   })
    //   // console.log(this.pms_pcr_status);
    // },

    // mounted() {

    // }
};
</script>
