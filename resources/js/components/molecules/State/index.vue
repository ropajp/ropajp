<!-- 都道府県 -->
<template>
  <div>
    <label for="state" class="form__label">{{ stateLabel }}</label>
    <input
        type="text"
        class="form__item form__text"
        id="state"
        placeholder="例）東京都"
        v-model="value.state"
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
      stateLabel: ''
    },
    watch: {
      value() {
        this.$emit('input', this.value)
      }
    }
  }
</script>
