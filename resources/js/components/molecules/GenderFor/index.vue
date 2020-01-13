<template>
  <div>
    <label for="gender_for" class="form__label">{{ genderForLabel }}</label>
    <input
        type="text"
        placeholder="例）ユニセックス"
        class="form__item form__text"
        id="gender_for"
        v-model="value.gender_for">
  </div>
</template>
<script>
  export default {
    props: {
      value: {
        type: Object,
        required: true
      },
      genderForLabel: ''
    },
    watch: {
      value() {
        this.$emit('input', this.value)
      }
    }
  }
</script>
