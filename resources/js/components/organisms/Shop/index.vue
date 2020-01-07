<template>
  <div class="shop">
    <RouterLink  class="shop__link" :to="`/shops/${items.id}`">
    <div class="shop__wrapper">
      <!-- 店舗写真を繰り返し表示 -->
        <img
        v-for="item in items.photos"
        :key = "item.id"
        class="shop__image"
        :class="imageClass"
        :src="item['url']"
        @load="setAspectRatio"
        ref="image"
        >
      </div>
      <!-- 都道府県・市町村 -->
      <div class="shop__address">
        {{ items.state }}{{ items.city }}
      </div>
      <!-- 店舗名表示 -->
      <div class="shop__name">
        {{ items.name }}
      </div>
      <!-- 対象性別・カテゴリー -->
      <div class="shop__target">
        {{ items.gender_for }} {{ items.category }}
      </div>
    </RouterLink>
  </div>
</template>
<script>
  export default {
    props: {
      // このコンポーネントは一つの店舗データとしてitemsを受け取る
      items: {
        // オブジェクトを受け取る
         type: Object
         }
    },
    data () {
   return {
     landscape: false,
     portrait: false
      }
 },
 computed: {
   imageClass () {
     return {
       // 横長クラス
       'shop__image--landscape': this.landscape,
       // 縦長クラス
       'shop__image--portrait': this.portrait
     }
   }
 },
 methods: {
   setAspectRatio () {
     if (! this.$refs.image) {
       return false
     }
     const height = this.$refs.image.clientHeight
     const width = this.$refs.image.clientWidth
     // 縦横比率 3:4 よりも横長の画像
     this.landscape = height / width <= 0.75
     // 横長でなければ縦長
     this.portrait = ! this.landscape
   },
   //  親コンポーネントshop-listにお気にいり情報を伝える
   // クリック時イベントお気に入りイベント発生
   favorite() {
     // favoriteを親コンポーネントとバインディング
     this.$emit('favorite', {
       // 親に伝える情報
       id: this.items.id,
       favorite: this.items.favorite_by_user
     })
   }
 },
 // 監視
 watch: {
   $route() {
     // ページが切り替わってから画像が読み込まれるまでの間に
     // 前のページの同じ位置にあった画像の表示が残ってしまうことを防ぐ
     this.landscape = false
     this.portrait = false
   }
 }
}
</script>
