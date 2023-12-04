<template>
    <div class="py-5 px-5 text-sm">
        <p>{{ recommendations }}</p>
    </div>

    <div class="flex justify-content-center flex-wrap mb-2" v-if="isUserSupervisor">
        <Button
            label="Add Recommendations"
            icon=""
            @click="visible = true"
            size="small"
            v-if="!recommendations"
        />
        <Button
            label="Edit Recommendations"
            icon=""
            @click="visible = true"
            size="small"
            v-else="!recommendations"
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
                            v-model="recommendations"
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

export default {
    props: {},
    data() {
        return {
            isUserSupervisor: true,
            visible: null,
            recommendations:
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
        };
    },

    methods: {
        onSubmit() {
            this.$toast.add({
                severity: "success",
                summary: "Saved!",
                detail: "Recommendations successfully saved!",
                life: 3000,
            });
        },
    },
    created() {
        //
    },
    mounted() {
        //
    },
};
</script>
