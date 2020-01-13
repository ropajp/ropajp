<template>
  <div>
    <label for="postcode" class="form__label">{{ postcodeLabel }}</label>
    <input
        type="text"
        class="form__item form__text"
        id="postcode"
        placeholder="ハイフンなしで入力してください"
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
