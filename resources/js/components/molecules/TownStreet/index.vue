<!--  番地・建物名 -->
<template>
  <div>
    <label for="town_street">{{ townStreetLabel }}</label>
    <input
        type="text"
        class="form__item form__text"
        id="town_street"
        placeholder="例）神宮前1-1-1"
        v-model="value.town_street"
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
      townStreetLabel: ''
    },
    watch: {
      value() {
        this.$emit('input', this.value)
      }
    }
  }
</script>
