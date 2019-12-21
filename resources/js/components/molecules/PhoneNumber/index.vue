<template>
  <div>
    <label for="phone_number">{{ phoneNumberLabel }}</label>
    <input
        type="text"
        class="form__item form__text"
        id="phone_number"
        placeholder="例）000-1234-5678"
        v-model="value.phone_number"
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
            phoneNumberLabel: ''
        },
        watch: {
            value() {
                this.$emit('input', this.value);
            }
        }
      }
</script>
