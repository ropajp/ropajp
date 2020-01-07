<!-- 取り扱いブランド -->
<template>
  <div>
    <label for="brands">{{ brandsLabel }}</label>
    <textarea
        type="text"
        class="form__item form__text"
        id="brands"
        placeholder="例）全角または半角スペースで区切って入力してください。"
        v-model="value.brands"
      >
      </textarea>
  </div>
</template>
<script>
  export default {
    props: {
      value: {
        type: Object,
        required: true
      },
      brandsLabel: ''
    },
    watch: {
      value() {
        this.$emit('input', this.value)
      }
    }
  }
</script>
