<template>
    <!-- add accomplishment modal start -->
    <Button
        label="Corrections"
        size="small"
        icon="pi pi-angle-right"
        text
        @click="visible = true"
    />

    <Dialog
        header="Edit Accomplishment"
        v-model:visible="visible"
        :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
        :style="{ width: '50vw' }"
        :modal="true"
    >
        <form @submit.prevent="submit_form()" id="accomplishment_form">
            <div class="field">
                <div class="font-bold">Success Indicator:</div>
                <span>{{ core_function.success_indicator }}</span>
                <br />
            </div>
            <div class="field">
                <div class="font-bold">Actual Accomplishment:</div>
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
            <div class="field" v-if="core_function.quality.length > 0">
                <div class="font-bold">Quality:</div>
                <template
                    v-for="(quality, i) in core_function.quality"
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

            <div class="field" v-if="core_function.efficiency.length > 0">
                <div class="font-bold">Efficiency:</div>
                <template
                    v-for="(efficiency, i) in core_function.efficiency"
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
            <div class="field" v-if="core_function.timeliness.length > 0">
                <div class="font-bold">Timeliness:</div>
                <template
                    v-for="(timeliness, i) in core_function.timeliness"
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
</template>
<script>
import axios from "axios";
import { router } from "@inertiajs/vue3";

export default {
    props: {
        core_function: null,
    },
    data() {
        return {
            visible: false,
            // core_function: {},
            accomplishment: {
                id: null,
                actual: null,
                quality: null,
                efficiency: null,
                timeliness: null,
                percent: null,
                remarks: null,
            },
        };
    },

    watch: {
        visible(val) {
            if (val) {
                this.accomplishment = JSON.parse(
                    JSON.stringify(
                        this.core_function.pms_pcr_core_function_data
                    )
                );
                console.log(this.accomplishment);
            }
        },
    },

    methods: {
        submit_form() {
            axios
                .post(router.page.url + "/save_corrections", {
                    previous: this.core_function.pms_pcr_core_function_data,
                    new: this.accomplishment,
                })
                .then(({ data }) => {
                    console.log("save_corrections: ", data);
                });
            this.visible = false;
        },
        cancel_accomplishment() {
            this.visible = false;
        },
    },
};
</script>
