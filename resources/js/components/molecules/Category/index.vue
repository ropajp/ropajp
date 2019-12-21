<!--カテゴリー -->
<template>
  <div>
    <label for="category">{{ categoryLabel }}</label>
    <input
        type="text"
        class="form__item form__text"
        id="category"
        placeholder="例）カジュアル"
        v-model="value.category"
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
      categoryLabel: ''
    },
    watch: {
      value() {
        this.$emit('input', this.value)
      }
    }
  }
</script>
