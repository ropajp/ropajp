<template>
  <div>
    <label for="gender_for">{{ genderForLabel }}</label>
    <input
        type="text"
        class="form__item form__text"
        id="gender_for"
        placeholder="例）ユニセックス"
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
