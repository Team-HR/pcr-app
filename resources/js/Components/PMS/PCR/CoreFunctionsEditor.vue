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
        <th colspan="11" class="text-left uppercase bg-indigo-500 text-white">Core Functions</th>
      </tr>
      <tr>
        <th style="width: 15px">{{ total_percentage_weight }}%</th>
        <th class="w-3">MFO/PAP</th>
        <th class="w-3">Success <br />Indicator</th>
        <th>Actual <br />Accomplishments</th>
        <th>Q</th>
        <th>E</th>
        <th>T</th>
        <th>
          A <i class="text-gray-700">({{ total_average_rating }})</i>
        </th>
        <th>Remarks</th>
        <th>
          <!-- <i class="bi bi-folder"></i> -->
        </th>
        <th>Options</th>
      </tr>
    </thead>

    <!-- <template v-for="(row, r) in rows" :key="r">
      <tr>
        <td colspan="11">{{ row.pms_pcr_core_function_data ? row.pms_pcr_core_function_data.corrections : '' }}
        </td>
      </tr>
    </template> -->
    <template v-for="(row, r) in rows" :key="r">
      <tr v-if="row.rowspan == 0 && row.si_only == false" :class="row.mfo_only ? 'bg-primary-50' : ''">
        <td v-if="!row.mfo_only" class="text-center">
          <template v-if="row.pms_pcr_core_function_data">
            <span v-if="row.pms_pcr_core_function_data.percent">{{ row.pms_pcr_core_function_data.percent + "%" }}</span>
          </template>
        </td>
        <!-- if  mfo has no success indicator (title) conditioned colspan if has multiple success indicator -->

        <td :colspan="row.mfo_only ? 11 : 1">
          <div :style="indent(row.level)">
            <span>
              <strong class="mr-2">{{ row.code }}</strong>
              {{ row.title }}
            </span>
          </div>
        </td>
        <!-- if mfo with only one success indicator -->
        <template v-if="!row.mfo_only">
          <td>{{ row.success_indicator }}</td>
          <template v-if="row.pms_pcr_core_function_data">
            <template v-if="!row.pms_pcr_core_function_data
              .not_applicable
              ">
              <td>
                {{
                  row.pms_pcr_core_function_data.actual
                }}
              </td>
              <td class="text-center">
                {{
                  row.pms_pcr_core_function_data.quality
                }}
              </td>
              <td class="text-center">
                {{
                  row.pms_pcr_core_function_data
                    .efficiency
                }}
              </td>
              <td class="text-center">
                {{
                  row.pms_pcr_core_function_data
                    .timeliness
                }}
              </td>
              <td class="text-center text-yellow-700">
                {{
                  row.pms_pcr_core_function_data.average
                }}
              </td>
              <td class="text-center">
                {{
                  row.pms_pcr_core_function_data.remarks
                }}
              </td>
            </template>
            <template v-else>
              <td colspan="6" class="text-center text-blue-700">
                {{
                  row.pms_pcr_core_function_data.actual
                }}
              </td>
            </template>
            <td></td>
            <td class="text-center">
              <Button v-if="!row.pms_pcr_core_function_data
                    .not_applicable
                  " label="Edit" icon="bi bi-pencil" class="p-button-sm p-button-text p-2 m-1"
                      @click="edit_accomplishment(row)" />
              <Button v-else label="Edit" icon="bi bi-pencil" class="p-button-sm p-button-text p-2 m-1"
                      @click="edit_not_applicable(row)" />
              <Button label="Clear" icon="bi bi-arrow-counterclockwise"
                      class="p-button-sm p-button-text p-button-warning p-2 m-1"
                      @click="confirm_accomplishment_reset(row)" />
            </td>
          </template>
          <template v-else>
            <td colspan="8" class="text-center">
              <Button label="Add Accomplishment" class="p-button-text p-button-small p-button-raised w-4 p-1"
                      @click="add_accomplishment(row)"></Button>
              <Button label="Not Applicable" class="p-button-danger p-button-small p-button-raised w-4 mt-2 ml-3 p-1"
                      @click="not_applicable(row)"></Button>
            </td>
          </template>
        </template>
      </tr>
      <!-- sub mfo with initial success indicator  -->
      <tr v-else-if="row.rowspan > 0 && row.si_only == false">
        <td class="text-center text-center">
          <template v-if="row.pms_pcr_core_function_data">
            <span v-if="row.pms_pcr_core_function_data.percent
              ">{{
    row.pms_pcr_core_function_data.percent
  }}%</span>
          </template>
        </td>
        <td :rowspan="row.rowspan">
          <div :style="indent(row.level)">
            <span>
              <strong class="mr-2">{{ row.code }}</strong>
              {{ row.title }}
            </span>
          </div>
        </td>
        <td>{{ row.success_indicator }}</td>
        <!-- accomplish interface start -->
        <template v-if="row.pms_pcr_core_function_data">
          <template v-if="!row.pms_pcr_core_function_data
            .not_applicable
            ">
            <td>
              {{ row.pms_pcr_core_function_data.actual }}
            </td>
            <td class="text-center">
              {{ row.pms_pcr_core_function_data.quality }}
            </td>
            <td class="text-center">
              {{
                row.pms_pcr_core_function_data.efficiency
              }}
            </td>
            <td class="text-center">
              {{
                row.pms_pcr_core_function_data.timeliness
              }}
            </td>
            <td class="text-center text-yellow-700">
              {{ row.pms_pcr_core_function_data.average }}
            </td>
            <td class="text-center">
              {{ row.pms_pcr_core_function_data.remarks }}
            </td>
          </template>
          <template v-else>
            <td colspan="6" class="text-center text-blue-700">
              {{ row.pms_pcr_core_function_data.actual }}
            </td>
          </template>
          <td></td>
          <td class="text-center">
            <Button v-if="!row.pms_pcr_core_function_data
              .not_applicable
              " label="Edit" icon="bi bi-pencil" class="p-button-sm p-button-text p-2 m-1"
                    @click="edit_accomplishment(row)" />
            <Button v-else label="Edit" icon="bi bi-pencil" class="p-button-sm p-button-text p-2 m-1"
                    @click="edit_not_applicable(row)" />
            <Button label="Clear" icon="bi bi-arrow-counterclockwise"
                    class="p-button-sm p-button-text p-button-warning p-2 m-1"
                    @click="confirm_accomplishment_reset(row)" />
          </td>
        </template>
        <template v-else>
          <td colspan="8" class="text-center">
            <Button label="Add Accomplishment" class="p-button-text p-button-small p-button-raised w-4 p-1"
                    @click="add_accomplishment(row)"></Button>
            <Button label="Not Applicable" class="p-button-danger p-button-small p-button-raised w-4 mt-2 ml-3 p-1"
                    @click="not_applicable(row)"></Button>
          </td>
        </template>
        <!-- accomplish interface end -->
      </tr>
      <!-- succeding success indicator from above -->
      <tr v-else>
        <td class="text-center">
          <template v-if="row.pms_pcr_core_function_data">
            <span v-if="row.pms_pcr_core_function_data.percent
              ">{{ row.pms_pcr_core_function_data.percent }}%</span>
          </template>
        </td>
        <td>{{ row.success_indicator }}</td>
        <template v-if="row.pms_pcr_core_function_data">
          <template v-if="!row.pms_pcr_core_function_data
            .not_applicable
            ">
            <td>
              {{ row.pms_pcr_core_function_data.actual }}
            </td>
            <td class="text-center">
              {{ row.pms_pcr_core_function_data.quality }}
            </td>
            <td class="text-center">
              {{
                row.pms_pcr_core_function_data.efficiency
              }}
            </td>
            <td class="text-center">
              {{
                row.pms_pcr_core_function_data.timeliness
              }}
            </td>
            <td class="text-center text-yellow-700">
              {{ row.pms_pcr_core_function_data.average }}
            </td>
            <td class="text-center">
              {{ row.pms_pcr_core_function_data.remarks }}
            </td>
          </template>
          <template v-else>
            <td colspan="6" class="text-center text-blue-700">
              {{ row.pms_pcr_core_function_data.actual }}
            </td>
          </template>
          <td></td>
          <td class="text-center">
            <Button v-if="!row.pms_pcr_core_function_data
              .not_applicable
              " label="Edit" icon="bi bi-pencil" class="p-button-sm p-button-text p-2 m-1"
                    @click="edit_accomplishment(row)" />
            <Button v-else label="Edit" icon="bi bi-pencil" class="p-button-sm p-button-text p-2 m-1"
                    @click="edit_not_applicable(row)" />
            <Button label="Clear" icon="bi bi-arrow-counterclockwise"
                    class="p-button-sm p-button-text p-button-warning p-2 m-1"
                    @click="confirm_accomplishment_reset(row)" />
          </td>
        </template>
        <template v-else>
          <td colspan="8" class="text-center">
            <Button label="Add Accomplishment" class="p-button-text p-button-small p-button-raised w-4 p-1"
                    @click="add_accomplishment(row)"></Button>
            <Button label="Not Applicable" class="p-button-danger p-button-small p-button-raised w-4 mt-2 ml-3 p-1"
                    @click="not_applicable(row)"></Button>
          </td>
        </template>
      </tr>
    </template>


    <!-- test start -->
    <!-- {{ get_length(rows) }} -->

    <template v-if="get_length(rows) < 1">
      <tr>
        <td class="p-5 bg-gray-300" colspan="11" style="text-align: center">
          No records found!
        </td>
      </tr>
    </template>

  </table>

  <!-- add accomplishment modal start -->
  <Dialog header="Edit Accomplishment" v-model:visible="edit_accomplishment_modal"
          :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '50vw' }" :modal="true">
    <form @submit.prevent="submit_accomplishment()" id="accomplishment_form">
      <div class="field">
        <div class="font-bold">Success Indicator:</div>
        <span>{{ core_function.success_indicator }}</span>
      </div>
      <div class="field">
        <div class="font-bold">Actual Accomplishment:</div>
        <Textarea v-model="accomplishment.actual" :autoResize="true" rows="5" class="w-full"
                  placeholder="Enter your actual accomplishment here based on the success indicator above." required />
      </div>
      <!-- <div class="field">{{ core_function }}</div> -->
      <div class="field" v-if="get_length(core_function.quality) > 0">
        <div class="font-bold">Quality:</div>
        <template v-for="(quality, i) in core_function.quality" :key="i">
          <div v-if="quality">
            <input type="radio" name="quality" :value="5 - i" :id="`quality${i}`" v-model="accomplishment.quality"
                   required />
            <label :for="`quality${i}`">{{ `${5 - i} - ${quality}` }}</label>
          </div>
        </template>
      </div>
      <div class="field" v-if="get_length(core_function.efficiency) > 0">
        <div class="font-bold">Efficiency:</div>
        <template v-for="(efficiency, i) in core_function.efficiency" :key="i">
          <div v-if="efficiency">
            <input type="radio" name="efficiency" :value="5 - i" :id="`efficiency${i}`"
                   v-model="accomplishment.efficiency" required />
            <label :for="`efficiency${i}`">{{ `${5 - i} - ${efficiency}` }}</label>
          </div>
        </template>
      </div>
      <div class="field" v-if="get_length(core_function.timeliness) > 0">
        <div class="font-bold">Timeliness:</div>
        <template v-for="(timeliness, i) in core_function.timeliness" :key="i">
          <div v-if="timeliness">
            <input type="radio" name="timeliness" :value="5 - i" :id="`timeliness${i}`"
                   v-model="accomplishment.timeliness" required />
            <label :for="`timeliness${i}`">{{ `${5 - i} - ${timeliness}` }}</label>
          </div>
        </template>
      </div>
      <div class="field">
        <div class="font-bold">Percentage Weight:</div>
        <!-- <InputNumber placeholder="-- % " /> -->
        <InputNumber inputId="percent" v-model="accomplishment.percent" suffix="%" placeholder="--%" required />
      </div>
      <div class="field">
        <div class="font-bold">Remarks:</div>
        <Textarea :autoResize="true" rows="5" class="w-full" placeholder="Enter remarks here."
                  v-model="accomplishment.remarks" />
      </div>
    </form>
    <template #footer>
      <Button label="Cancel" icon="pi pi-times" @click="cancel_accomplishment()" class="p-button-text" />
      <Button label="Save" icon="pi pi-check" autofocus type="submit" form="accomplishment_form" />
    </template>
  </Dialog>
  <!-- add accomplishment modal end -->

  <!-- not applicable modal start -->
  <Dialog header="Not Applicable" v-model:visible="not_applicable_modal"
          :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '50vw' }" :modal="true">
    <form @submit.prevent="submit_not_applicable()" id="not_applicable_form">
      <!-- <div class="field">
                                                                                                                                                                                                          <div class="font-bold">Success Indicator:</div>
                                                                                                                                                                                                          <span>{{ core_function.success_indicator }}</span>
                                                                                                                                                                                                        </div> -->
      <div class="field">
        <div class="font-bold mb-2">Reason:</div>
        <Textarea v-model="accomplishment.actual" :autoResize="true" rows="5" class="w-full"
                  placeholder="Enter the reason why the success indicator is not applicable for accomplishment."
                  required />
      </div>
    </form>

    <template #footer>
      <Button label="Cancel" icon="pi pi-times" @click="cancel_not_applicable()" class="p-button-text" />
      <Button label="Save" icon="pi pi-check" autofocus type="submit" form="not_applicable_form" />
    </template>
  </Dialog>
  <!-- not applicable modal end -->

  <ConfirmDialog />
  <Toast />
</template>
<script>
// import { Inertia } from '@inertiajs/inertia';


export default {
  props: {
    pms_pcr_status: {},
  },
  data() {
    return {
      current_url: document.location.pathname,
      error: {},
      edit_accomplishment_modal: false,
      not_applicable_modal: false,
      core_function: null,
      // percentage_weight_remaining: null,
      accomplishment: this.$inertia.form({
        pms_pcr_status: this.pms_pcr_status,
        id: null,
        pms_rsm_success_indicator_id: null,
        actual: null,
        quality: null,
        efficiency: null,
        timeliness: null,
        percent: null,
        remarks: null,
        not_applicable: null,
      }),
      form_status: this.pms_pcr_status,
      period: this.pms_pcr_status.period,
      rows: [],
      total_percentage_weight: null,
      total_average_rating: null,
    }
  },

  methods: {
    get_length(rating) {
      if (!rating) return 0;
      return rating.length;
    },
    not_applicable(row) {
      this.accomplishment.id = null;
      this.accomplishment.pms_rsm_success_indicator_id =
        row.pms_rsm_success_indicator_id;
      this.accomplishment.not_applicable = true;
      this.not_applicable_modal = true;
    },
    cancel_not_applicable() {
      this.not_applicable_modal = false;
      this.clear_accomplishment();
    },
    edit_not_applicable(row) {
      console.log(row);
      this.accomplishment.id =
        row.pms_pcr_core_function_data.id;
      this.accomplishment.pms_rsm_success_indicator_id =
        row.pms_rsm_success_indicator_id;
      this.accomplishment.actual =
        row.pms_pcr_core_function_data.actual;
      this.accomplishment.not_applicable = true;
      this.not_applicable_modal = true;
    },
    submit_not_applicable() {
      console.log(this.accomplishment);
      this.accomplishment.post(this.current_url + "/accomplishment", {
        preserveScroll: true,
        onSuccess: () => {
          if (!this.accomplishment.id) {
            this.$toast.add({
              severity: "info",
              summary: "Note!",
              detail: "Success indicator marked as not applicable!",
              life: 3000,
            });
          } else {
            this.$toast.add({
              severity: "info",
              summary: "Updated!",
              detail: "Reason updated!",
              life: 3000,
            });
          }
          this.not_applicable_modal = false;
          this.clear_accomplishment();
        },
      });
    },

    submit_accomplishment() {
      this.accomplishment.post(this.current_url + "/accomplishment", {
        preserveScroll: true,
        onSuccess: () => {
          if (!this.accomplishment.id) {
            this.$toast.add({
              severity: "success",
              summary: "Accomplished!",
              detail: "Accomplishment saved!",
              life: 3000,
            });
          } else {
            this.$toast.add({
              severity: "success",
              summary: "Updated!",
              detail: "Accomplishment updated!",
              life: 3000,
            });
          }
          this.edit_accomplishment_modal = false;
          this.clear_accomplishment();
          this.get_data()
        },
      });
    },

    add_accomplishment(row) {
      this.core_function = row;
      this.accomplishment.id = null;
      this.accomplishment.pms_rsm_success_indicator_id =
        row.pms_rsm_success_indicator_id;
      this.edit_accomplishment_modal = true;
    },

    cancel_accomplishment() {
      this.edit_accomplishment_modal = false;
      this.clear_accomplishment();
    },

    edit_accomplishment(row) {
      this.core_function = row;
      this.accomplishment.id =
        row.pms_pcr_core_function_data.id;
      this.accomplishment.pms_rsm_success_indicator_id =
        row.pms_rsm_success_indicator_id;
      this.accomplishment.actual =
        row.pms_pcr_core_function_data.actual;
      this.accomplishment.quality =
        row.pms_pcr_core_function_data.quality;
      this.accomplishment.efficiency =
        row.pms_pcr_core_function_data.efficiency;
      this.accomplishment.timeliness =
        row.pms_pcr_core_function_data.timeliness;
      this.accomplishment.percent =
        row.pms_pcr_core_function_data.percent;
      this.accomplishment.remarks =
        row.pms_pcr_core_function_data.remarks;
      this.edit_accomplishment_modal = true;
    },
    clear_accomplishment() {
      this.accomplishment.id = null;
      this.accomplishment.pms_rsm_success_indicator_id = null;
      this.accomplishment.actual = null;
      this.accomplishment.quality = null;
      this.accomplishment.efficiency = null;
      this.accomplishment.timeliness = null;
      this.accomplishment.percent = null;
      this.accomplishment.remarks = null;
      this.accomplishment.not_applicable = null;
    },
    confirm_accomplishment_reset(row) {
      // console.log(row.pms_pcr_core_function_data.id);
      this.$confirm.require({
        message: "Resetting this accomplishment will empty its values, proceed?",
        header: "Reset Confirmation",
        icon: "pi pi-info-circle",
        acceptClass: "p-button-danger",
        accept: () => {
          this.$inertia.delete(
            this.current_url +
            "/accomplishment/" +
            row.pms_pcr_core_function_data.id,
            {
              preserveScroll: true,
              onSuccess: () => {
                this.$toast.add({
                  severity: "info",
                  summary: "Confirmed",
                  detail: "Accomplishment resetted",
                  life: 3000,
                });
              },
            }
          );
        },
        reject: () => {
          // this.$toast.add({
          //   severity: "error",
          //   summary: "Rejected",
          //   detail: "You have rejected",
          //   life: 3000,
          // });
        },
      });
    },
    indent(level) {
      var margin = "";
      if (level > 0) {
        margin = "margin-left:" + level * 20 + "px;";
      }
      return margin;
    },
    validate() { },
    submit_form() { },
    get_data() {

      axios.post("/api/pms/get_core_functions_editor_data", {
        pms_pcr_status_id: this.pms_pcr_status.id,
        pms_period_id: this.pms_pcr_status.pms_period_id,
        sys_employee_id: this.pms_pcr_status.sys_employee_id
      }).then(({ data }) => {
        // console.log("Core function table data:", data);
        this.rows = data.rows
        this.total_percentage_weight = data.total_percentage_weight
        this.total_average_rating = data.total_average_rating
      })

    }
  },
  created() {
    this.get_data()
  },
  mounted() {
    // Inertia.reload({ only: ["rows"] });
  },
};
</script>
