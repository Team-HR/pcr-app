
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
  <table class="mt-3 w-full">
    <thead>
      <tr>
        <th colspan="" class="text-left uppercase bg-indigo-500 text-white">Signatories</th>
      </tr>
      <tr>
        <td>

          <form @submit.prevent="submit_form()" class="w-full ml-5">
            <div class="field">
              <h3>SUPERVISOR:</h3>
              <Dropdown v-if="this.form_type.agency == 'lgu'" showClear v-model="form.immediate_supervisor"
                        :options="employees" optionLabel="full_name"
                        placeholder="Select immediate supervisor (Leave empty if none)" :filter="true"
                        filterPlaceholder="Search name" class="mr-2 w-4" aria-describedby="username-help" />

              <InputText v-else placeholder="Name of your supervisor" class="w-4" v-model="form.immediate_supervisor" />
              <br>
              <small id="username-help" class="ml-2">*Leave empty if none.</small>

            </div>
            <div class="field">
              <h3>DEPARTMENT HEAD:</h3>
              <Dropdown v-if="this.form_type.agency == 'lgu'" showClear v-model="form.department_head"
                        :options="employees" optionLabel="full_name" placeholder="Select your department head"
                        :filter="true" filterPlaceholder="Search name" class="mr-2 w-4" />
              <InputText v-else placeholder="Name of your department head" class="w-4" v-model="form.department_head" />
            </div>
            <div class="field">
              <h3>HEAD OF AGENCY:</h3>
              <InputText placeholder="Name of your agency head" class="w-4" v-model="form.head_of_agency" />
            </div>
          </form>
        </td>
      </tr>
    </thead>
  </table>



  <div class="border-0 border-round border-indigo-300 p-3">

    <!-- <div class="field">
        <label for="pcrType">PCR Form Type:</label>
        <Dropdown id="pcrType" v-model="selectedPcrType" :options="pcrTypes" optionLabel="name" placeholder="Select PCR type"
                  class="w-full _md:w-14rem" />
      </div> -->

  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: ["pms_pcr_status"],
  data() {
    return {
      employees: null,
      form_type: {
        agency: "lgu"
      },
      formTypes: {
        ipcr: "INDIVIDUAL PERFORMANCE COMMITMENT AND REVIEW (IPCR)",
        spcr: "SECTION PERFORMANCE COMMITMENT AND REVIEW (SPCR)",
        dspcr: "DIVISION PERFORMANCE COMMITMENT AND REVIEW (DSPCR)",
        dpcr: "DEPARTMENT PERFORMANCE COMMITMENT AND REVIEW (DSPCR)",
      },
      current_url: document.location.pathname,
      error: {
        agency: "",
        form_type: "",
      },
      form: this.$inertia.form({
        immediate_supervisor: null,
        department_head: null,
        head_of_agency: null,
      }),
    }
  },


  created() {
    // get list of employees
    axios.get("/api/list/employees").then(({ data }) => {
      console.log("this.employees: ", data);
      this.employees = data
    })
    console.log(this.pms_pcr_status);
  }
};
</script>

