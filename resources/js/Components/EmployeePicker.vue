<template>
    <Card>
        <template #content>
            <Dropdown
                id="item_picker"
                v-model="in_charge"
                :options="items"
                optionLabel="full_name"
                :filter="true"
                placeholder="Pick a personnel and click add..."
                :showClear="true"
                class="mr-3"
            >
            </Dropdown>
            <Button
                :disabled="!in_charge"
                class="p-button-text"
                label="Add"
                icon="bi bi-plus"
                @click="add_incharge()"
            ></Button>
            <br />
            <div class="mt-3 ml-3">
                <div v-for="item in selected_employees" :key="item.id">
                    <div class="flex">
                        <Button
                            class="p-button-sm p-button-text p-button-danger"
                            icon="bi bi-x"
                            label="Remove"
                            @click="remove_incharge(item)"
                        ></Button>
                        <div class="flex py-2 ml-3">{{ item.full_name }}</div>
                    </div>
                </div>
            </div>
        </template>
    </Card>
</template>
<script>
export default {
    props: {
        initSelections: null,
        options: null,
    },
    data() {
        return {
            in_charge: null,
            items: [],
            selected_employees: [],
        };
    },
    methods: {
        add_incharge() {
            this.selected_employees.push(this.in_charge);
            this.resort(this.selected_employees);
            this.remove_from_items(this.in_charge);
            this.in_charge = null;
            this.$emit("changed", this.selected_employees);
        },
        remove_incharge(item) {
            this.items.push(item);
            this.resort(this.items);
            this.remove_from_selected_employees(item);
            this.$emit("changed", this.selected_employees);
        },
        remove_from_selected_employees(item) {
            for (
                let index = 0;
                index < this.selected_employees.length;
                index++
            ) {
                if (this.selected_employees[index].id == item.id) {
                    this.selected_employees.splice(index, 1);
                }
            }
        },
        remove_from_items(item) {
            for (let index = 0; index < this.items.length; index++) {
                if (this.items[index].id == item.id) {
                    this.items.splice(index, 1);
                }
            }
        },
        resort(objs) {
            objs.sort((a, b) =>
                a.full_name > b.full_name
                    ? 1
                    : b.full_name > a.full_name
                    ? -1
                    : 0
            );
        },
    },
    created() {
        this.items = JSON.parse(JSON.stringify(this.options));
        this.selected_employees = this.initSelections;
    },
    mounted() {
        console.log("initSelections:", this.initSelections);
    },
};
</script>
