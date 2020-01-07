<template>
  <div>
    <label for="postcode">{{ postcodeLabel }}</label>
    <input
        type="text"
        class="form__item form__text"
        id="postcode"
        placeholder="例）123-4567"
        v-model="value.postcode"
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
        postcodeLabel: ''
    },
    watch: {
        value() {
            this.$emit('input', this.value);
        }
    }
  }
</script>
