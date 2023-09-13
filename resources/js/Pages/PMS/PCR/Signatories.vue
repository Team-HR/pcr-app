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
  <auth-layout>
    <Card class="w-full">
      <template #title>
        <Button label="Back" class="p-button-sm p-button-raised p-button-text mb-3" icon="bi bi-arrow-left"
                @click="go_back()"></Button>
        <br />
        <span><i class="bi bi-book mr-2"></i> PERFORMANCE COMMITMENT AND REVIEW | Set
          Signatories</span></template>
      <template #subtitle>
        <span class="text-xl">{{ $page.props.auth.user.sys_department_name }} ( {{ period.period }},
          {{ period.year }})</span>
        <br />
        Set signatories</template>
      <template #content>
        <form @submit.prevent="submit_form()" class="w-full ml-5">
          <div class="field">
            <h3>SUPERVISOR:</h3>
            <Dropdown v-if="this.form_type.agency == 'lgu'" showClear v-model="form.immediate_supervisor"
                      :options="employees" optionLabel="full_name" placeholder="Select the supervisor" :filter="true"
                      filterPlaceholder="Search name" class="mr-2 w-4" />
            <InputText v-else placeholder="Name of your supervisor" class="w-4" v-model="form.immediate_supervisor" />
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
          <Button icon="bi bi-save" label="Save" type="submit"></Button>
        </form>
      </template>
    </Card>
  </auth-layout>
</template>
<script>
import AuthLayout from "@/Layouts/Authenticated";

export default {
  props: {
    employees: null,
    form_type: null,
    period: null,
  },
  components: {
    AuthLayout,
  },
  data() {
    return {
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
    };
  },
  methods: {
    validate() { },
    submit_form() {
      // console.log(this.form);
      this.form.post(this.current_url, {
        onSuccess: () => {
          this.go_back();
        },
      });
    },
    go_back() {
      // window.history.back();
      var pathname = document.location.pathname;
      pathname = pathname.split("/");
      pathname = `/${pathname[1]}/${pathname[2]}/${pathname[3]}`;
      // console.log(pathname);
      this.$inertia.get(
        pathname,
        {},
        {
          replace: true,
          onSuccess: () => {
            // if (toast) {
            //   this.$toast.add(toast);
            // }
          },
        }
      );
    },
  },
  created() {
    // console.log(this.form_type.signatories_inputs);
    this.form.immediate_supervisor = this.form_type.signatories_inputs.immediate_supervisor;
    this.form.department_head = this.form_type.signatories_inputs.department_head;
    this.form.head_of_agency = this.form_type.signatories_inputs.head_of_agency;
    if (this.form_type.agency == "lgu") {
      this.form.head_of_agency = "JOHN T. RAYMOND, JR.";
    }
  },
  mounted() { },
};
</script>
