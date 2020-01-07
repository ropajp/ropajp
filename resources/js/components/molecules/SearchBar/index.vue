<!-- 検索フォームコンポーネント -->
<template>
  <form  @submit.prevent="search">
      <input
          class="search__searchBar"
          type="search"
          placeholder="キーワードを入力してください..."
          v-model="key"
      >
      <button class="search__magnify" type="submit">
          <i class="fa fa-search"></i>
      </button>
  </form>
</template>
<script>
export default {
  data() {
    return {
      // パラメータの初期化
      key: '',
    }
  },
  methods: {
    search() {
      // もしキーワード入力欄にkeyがなかったら
      if(this.key === '') {
        // keyパラメータにallを入れる
        this.key = '$all'
      }
      // urlパラメータに値を設定
      this.$router.push(`/shop-list/${this.key}`)
      this.key =''
    }
 }
}
</script>
