<!-- 市町村 -->
<template>
  <div>
    <label for="city" class="form__label">{{ cityLabel }}</label>
    <input
        type="text"
        class="form__item form__text"
        id="city"
        placeholder="例）渋谷区"
        v-model="value.city"
    >
  </div>
</template>
<script>
  export default {
    props: {
      value: {
        type: Object,
        required: true
      },
      cityLabel: ''
    },
    watch: {
      value() {
        this.$emit('input', this.value)
      }
    }
}
</script>
