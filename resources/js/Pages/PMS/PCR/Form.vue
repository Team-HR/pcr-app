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
        <span><i class="bi bi-book mr-2"></i> PERFORMANCE COMMITMENT AND REVIEW</span></template>
      <template #subtitle>
        <span class="text-xl">{{ $page.props.auth.user.sys_department_name }} ( {{ period.period }},
          {{ period.year }})</span>
        <br />
        Accomplish/Review your Performance Commitments</template>
      <template #content>
        

        <PcrForm :pms_pcr_status="form_status" />

      </template>
    </Card>
    <Toast />
  </auth-layout>
</template>
<script>
import AuthLayout from "@/Layouts/Authenticated";
import { router } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3'
import PcrForm from "@/Components/Pms/Pcr/Form.vue";


export default {
  props: {
    period: null,
    form_status: null,
  },
  components: {
    AuthLayout,
    PcrForm
  },
  data() {
    return {
      current_url: document.location.pathname,
      items: [],
      form: useForm(this.form_status),
    };
  },

  methods: {
    
    go_back() {
      window.history.back();
    },

  },

  mounted() {

  },
};
</script>
