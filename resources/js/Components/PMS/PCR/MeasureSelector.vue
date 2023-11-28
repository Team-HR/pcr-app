<template>
  <div class="field">
    <div class="font-bold text-xl">{{ name }}</div>
    <template v-for="(option, i) in options" :key="i">
      <div v-if="option" class="ml-2">
        <!-- <RadioButton
          :inputId="`${name}${i}`"
          :name="name"
          :value="5 - i"
          required
          @input="changeInput"
          v-model="content"
        /> -->
        <input
          style="transform: scale(1.5)"
          type="radio"
          :id="`${name}${i}`"
          :name="name"
          :value="5 - i"
          required
          @input="changeInput"
          v-model="content"
        />
        <label class="text-xl ml-2" :for="`${name}${i}`">{{
          `${5 - i} - ${option}`
        }}</label>
      </div>
    </template>
  </div>
</template>

<script>
export default {
  props: {
    name: null,
    options: null,
    modelValue: null,
  },
  emits: ["update:modelValue"],
  data() {
    return {
      content: this.modelValue,
    };
  },
  methods: {
    changeInput(event) {
      this.$emit("update:modelValue", event.target.value); // previously was `this.$emit('input', title)`
    },
  },
};
</script>
