
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

<template>
  <div>
    <!-- {{ $inertia.page.props.auth.user.roles }} -->
    <!-- table strategic function start -->
    <table class="mt-3 w-full">
      <thead>
        <tr>
          <th colspan="6" class="text-left uppercase bg-indigo-500 text-white">Strategic Function</th>
        </tr>
        <tr class="bg-indigo-100">
          <th style="width: 37.5px;">20%</th>
          <th>Strategic Function</th>
          <th>Success Indicator</th>
          <th>Actual Accomplishment</th>
          <th>Final Numerical Rating</th>
          <th>Options</th>
        </tr>
      </thead>
      <template v-if="rows && rows.length > 0">
        <tr v-for="row, s in rows" :key="s">
          <td colspan="2">
            {{ row.function_title }}
          </td>
          <td>
            {{ row.success_indicator }}
          </td>
          <td>
            {{ row.actual_accomplishment }}
          </td>
          <td class="text-center">
            {{ row.final_numerical_rating }}
          </td>
          <td class="text-center">
            <Button label="Edit" icon="bi bi-pencil" class="p-button-sm p-button-text p-2 m-1"
                    @click="formDialog = true" />
            <Button label="Clear" icon="bi bi-arrow-counterclockwise"
                    class="p-button-sm p-button-text p-button-warning p-2 m-1" @click="deleteDialog = true" />
          </td>
        </tr>
      </template>
      <template v-else>
        <tr>
          <!-- <td colspan="5" class="text-center text-gray-500">No records found!</td> -->
          <td colspan="6" class="text-center">
            <Button class="p-button-sm mr-3" label="Add Accomplishment" @click="add_edit_accomplishment()" />
            <!-- <Button class="p-button-sm p-button-danger"
                                  label="Not Applicable"
                                  @click="not_applicable()"
                                /> -->
          </td>
        </tr>
      </template>
    </table>
    <!-- table strategic function end -->
  </div>

  <Dialog v-model:visible="deleteDialog" modal header="Delete" :style="{ _width: '50vw' }">
    <p>
      Are your sure you want to delete current record?
    </p>
    <template #footer>
      <Button label="No" icon="pi pi-times" @click="deleteDialog = false" text />
      <Button label="Yes" icon="pi pi-check" @click="confirm_delete()" autofocus />
    </template>
  </Dialog>


  <Dialog header="Accomplish Strategic Function" v-model:visible="formDialog"
          :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '50vw' }" :modal="true">
    <form @submit.prevent="submit_add_edit_accomplishment()" id="add_edit_accomplishment_form">
      <div class="field">
        <div class="font-bold mb-2">Strategic Function:</div>
        <Textarea v-model="accomplishment.function_title" :autoResize="true" rows="2" class="w-full"
                  placeholder="Enter the strategic function" required />
      </div>
      <div class="field">
        <div class="font-bold mb-2">Success Indicator:</div>
        <Textarea v-model="accomplishment.success_indicator" :autoResize="true" rows="2" class="w-full"
                  placeholder="Enter the success indicator" required />
      </div>
      <div class="field">
        <div class="font-bold mb-2">Actual Accomplishment:</div>
        <Textarea v-model="accomplishment.actual_accomplishment" :autoResize="true" rows="2" class="w-full"
                  placeholder="Enter your actual accomplishment" required />
      </div>
      <div class="field">
        <div class="font-bold mb-2">Final Numerical Rating:</div>
        <InputNumber v-model="accomplishment.final_numerical_rating" mode="decimal" :minFractionDigits="2"
                     :maxFractionDigits="2" :max="5" placeholder="e.g. 1.00 - 5" required />
      </div>
    </form>
    <template #footer>
      <Button label="Cancel" icon="pi pi-times" @click="close_dialog()" class="p-button-text" />
      <Button label="Save" icon="pi pi-check" autofocus type="submit" form="add_edit_accomplishment_form" />
    </template>
  </Dialog>
</template>

<script>
import axios from 'axios';

export default {
  props: ["pms_pcr_status"],
  data() {
    return {
      rows: [],
      deleteDialog: null,
      formDialog: null,
      accomplishment: {
        id: null,
        pms_period_id: this.pms_pcr_status.pms_period_id,
        sys_employee_id: this.pms_pcr_status.sys_employee_id,
        function_title: null,
        success_indicator: null,
        actual_accomplishment: null,
        final_numerical_rating: null,
        percent: 20,
        remarks: null,
        not_applicable: 0
      },
      default_accomplishment: {
        id: null,
        pms_period_id: this.pms_pcr_status.pms_period_id,
        sys_employee_id: this.pms_pcr_status.sys_employee_id,
        function_title: null,
        success_indicator: null,
        actual_accomplishment: null,
        final_numerical_rating: null,
        percent: 20,
        remarks: null,
        not_applicable: 0
      }
    };
  },
  watch: {
    formDialog(newValue, oldValue) {
      if (this.rows.length > 0) {
        this.accomplishment = JSON.parse(JSON.stringify(this.rows[0]))
      }
    },
  },
  methods: {

    add_edit_accomplishment() {
      this.formDialog = true
    },

    getStrategicFunctionData() {
      axios.post("/api/pms/strategic_function", {
        pms_pcr_status: this.pms_pcr_status,
      }).then(({ data }) => {
        this.rows = data
        this.formDialog = false
      })
    },

    confirm_delete() {
      axios.post("/api/pms/strategic_function/delete", {
        pms_pcr_status: this.pms_pcr_status,
      }).then(({ data }) => {
        this.rows = []
        this.deleteDialog = false
        this.accomplishment = JSON.parse(JSON.stringify(this.default_accomplishment))
      })
    },

    submit_add_edit_accomplishment() {
      axios.post("/api/pms/strategic_function/create_or_update", {
        accomplishment: this.accomplishment,
      }).then(({ data }) => {
        this.close_dialog()
        this.getStrategicFunctionData()
      })
    },

    close_dialog() {
      this.formDialog = false
      this.accomplishment = JSON.parse(JSON.stringify(this.default_accomplishment))
    },


  },

  created() {
    this.getStrategicFunctionData()
  },

  mounted() {


  }
};
</script>

