<template>
    <div class="w-full my-0 relative flex align-items-baseline">
        <!-- <Breadcrumb :home="home" :model="items" class="p-0 m-0 b-0 relative">
            <template #item="{ label, item, props }">
                <Button
                    :label="item.label"
                    text
                    small
                    :class="
                        active_route == item.route ? 'success' : 'text-gray-400'
                    "
                    class="p-0 m-0 px-2"
                    @click="$inertia.get(item.href, {}, { replace: true })"
                />
            </template>
        </Breadcrumb> -->

        <!-- pi-chevron-right -->
        <!-- pi-calendar -->

        <Button
            icon="pi pi-calendar"
            label="Period"
            text
            small
            class="p-0 m-0 px-2 text-gray-400"
            @click="$inertia.get('/pms/pcr', {}, { replace: true })"
        />

        <template v-for="(item, i) in items" :key="i">
            <!-- <i class="pi pi-chevron-right"></i> -->
            <Button
                icon="pi pi-chevron-right"
                :label="item.label"
                text
                small
                :class="
                    active_route == item.route ? 'success' : 'text-gray-400'
                "
                class="p-0 m-0 px-2"
                @click="$inertia.get(item.href, {}, { replace: true })"
            />
        </template>
    </div>
</template>

<script>
export default {
    props: {
        periodId: null,
        formStatusId: null,
    },
    data() {
        return {
            active_route: null,
            home: {
                href: "/pms/pcr/" + this.periodId,
                label: "Status",
                route: null,
            },
            items: [
                {
                    href: "/pms/pcr/" + this.periodId,
                    label: "Status",
                    route: null,
                },
                {
                    href:
                        "/pms/pcr/" +
                        this.periodId +
                        "/form_type/" +
                        this.formStatusId,
                    label: "Form Type",
                    route: "form_type",
                },
                {
                    href:
                        "/pms/pcr/" +
                        this.periodId +
                        "/signatories/" +
                        this.formStatusId,
                    label: "Signatories",
                    route: "signatories",
                },
                {
                    href:
                        "/pms/pcr/" +
                        this.periodId +
                        "/core_functions/" +
                        this.formStatusId,
                    label: "Core Functions",
                    route: "core_functions",
                },
                {
                    href:
                        "/pms/pcr/" +
                        this.periodId +
                        "/support_functions/" +
                        this.formStatusId,
                    label: "Support Functions",
                    route: "support_functions",
                },
                {
                    href:
                        "/pms/pcr/" +
                        this.periodId +
                        "/strategic_function/" +
                        this.formStatusId,
                    label: "Strategic Function",
                    route: "strategic_function",
                },
                // { label: "Finalize" }
            ],
        };
    },
    mounted() {
        this.active_route = this.$inertia.page.url.split("/")[4];
        // console.log(());
        // console.log(this.periodId);
        // console.log(this.formStatusId);
    },
};
</script>
