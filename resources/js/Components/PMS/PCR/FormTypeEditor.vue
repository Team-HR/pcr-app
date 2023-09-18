
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
        <th colspan="" class="text-left uppercase bg-indigo-500 text-white">Form Setting</th>
      </tr>
      <tr>
        <td>
          <form @submit.prevent="" class="w-full ml-5">
            <div class="field">
              <h3>AGENCY:</h3>
              <Dropdown v-model="selectedAgency" :options="agencies" optionLabel="name" placeholder="Select employer"
                        class="mr-2 w-4" />
            </div>
            <div class="field">
              <h3>SELECT FORM TYPE:</h3>
              <Dropdown v-model="selectedFormType" :options="pcrTypes" optionLabel="name"
                        placeholder="Select PCR form type" class="mr-2 w-4" />
            </div>
          </form>
        </td>
      </tr>
    </thead>
  </table>
</template>

<script>
import axios from 'axios';

export default {
  props: ["pms_pcr_status"],
  data() {
    return {
      selectedAgency: null,
      agencies: [
        { name: "LGU", code: "lgu" },
        { name: "NGA", code: "nga" }
      ],
      selectedFormType: null,
      pcrTypes: [
        { name: "IPCR (INDIVIDUAL PERFORMANCE COMMITMENT AND REVIEW)", code: "ipcr" },
        { name: "SPCR (SECTION PERFORMANCE COMMITMENT AND REVIEW)", code: "spcr" },
        { name: "Division SPCR (DIVISION PERFORMANCE COMMITMENT AND REVIEW)", code: "dspcr" },
        { name: "DPCR (DEPARTMENT PERFORMANCE COMMITMENT AND REVIEW)", code: "dpcr" },
      ],
    }
  },


  created() {

  }


};
</script>

