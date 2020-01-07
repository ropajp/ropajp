<template>
  <div>
    <label class="form__label" for="url">{{ urlLabel }}</label>
    <input
        type="text"
        class="form__item form__text"
        id="url"
        placeholder="例）店舗のHP、ブログのURLを入力してください"
        v-model="value.url"
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
        urlLabel: ''
    },
    watch: {
        value() {
            this.$emit('input', this.value);
        }
    }
  }
</script>
