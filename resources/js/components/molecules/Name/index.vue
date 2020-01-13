<template>
  <div>
    <label class="form__label" for="username">{{ nameLabel }}</label>
    <input
        type="text"
        class="form__item form__text"
        id="username"
        placeholder="スペースなしで入力してください"
        v-model="value.name"
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
        nameLabel: ''
    },
    watch: {
        value() {
            this.$emit('input', this.value);
        }
    }
  }
</script>
