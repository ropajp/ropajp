<!-- 店舗紹介 -->
<template>
  <div>
    <label for="shop_detail">{{ shopDetailLabel }}</label>
    <textarea
          type="text"
          class="form__item form__text"
          id="shop_detail"
          placeholder="例）この店舗は・・・"
          v-model="value.shop_detail">
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
      shopDetailLabel: ''
    },
    watch: {
      value() {
        this.$emit('input', this.value)
      }
    }
  }

</script>
