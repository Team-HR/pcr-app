<template>
    <div class="py-5 px-5 text-sm">
        <p>{{ form.recommendations }}</p>
    </div>

    <div
        class="flex justify-content-center flex-wrap mb-2"
        v-if="isUserSupervisor"
    >
        <Button
            label="Add/Edit Recommendations" 
            outlined
            icon="pi pi-pencil"
            @click="visible = true"
            size="small"
            class="p-2"
            v-if="!form.recommendations"
        />
        <Button
            label="Edit Recommendations"
            icon=""
            @click="visible = true"
            size="small"
            v-else="!form.recommendations"
        />

        <Dialog
            v-model:visible="visible"
            modal
            header="Recommendations"
            :style="{ width: '50rem' }"
            :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
        >
            <div class="card flex justify-content-center">
                <form @submit.prevent="onSubmit" class="flex flex-column gap-2">
                    <span class="p-float-label">
                        <Textarea
                            id="value"
                            v-model="form.recommendations"
                            :class="{ 'p-invalid': errorMessage }"
                            class="w-full"
                            rows="4"
                            cols="100"
                            aria-describedby="text-error"
                        />
                        <label for="value">Enter recommendations here:</label>
                    </span>
                    <small id="text-error" class="p-error">{{
                        errorMessage || "&nbsp;"
                    }}</small>
                    <Button type="submit" label="Save" size="small" />
                </form>
                <Toast />
            </div>
        </Dialog>
    </div>
</template>
<script>
// import { Inertia } from '@inertiajs/inertia';
import { router } from "@inertiajs/vue3";

export default {
    props: {},
    data() {
        return {
            isUserSupervisor: true,
            visible: null,
            form: {
                recommendations: "",
            },
            errorMessage: null,
        };
    },

    methods: {
        onSubmit() {
            router.post(router.page.url + "/save_recommendations", this.form, {
                onSuccess: (page) => {
                    this.visible = false;
                },
            });

            this.$toast.add({
                severity: "success",
                summary: "Saved!",
                detail: "Recommendations successfully saved!",
                life: 3000,
            });
        },
        getRecommendations() {
            // console.log("getRecommendations");
            axios
                .get(router.page.url + "/get_recommendations")
                .then(({ data }) => {
                    // console.log(data);
                    this.form.recommendations = data;
                });
        },
    },
    created() {
        this.getRecommendations();
    },
    mounted() {
        //
    },
};
</script>
