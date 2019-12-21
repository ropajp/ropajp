// 商品一覧
<template>
  <div class="shop-list">
    <div class="grid">
    <!-- 店舗リストを表示 -->
      <div v-if="shops.total == 0">
        検索結果は0件でした。
      </div>
      <Shop
          class="grid__item"
          v-for="shop in shops.data"
           :key="shop.id"
           :items="shop"
      />
    </div>
    <pagination :data="shops" @pagination-change-page="fetchShops">
      <span class="sign" slot="prev-nav">&lt;</span>
      <span class="sign" slot="next-nav">&gt;</span>
    </pagination>
  </div>
</template>
<script>
  import { OK } from '../../../util'
  import Shop from '../../organisms/Shop/index.vue'

  export default {
    components: {
      // 子コンポーネント
      Shop
    },
    data() {
      return {
        // 初期化 レスポンスデータを格納
          shops: {}
        }
    },
    methods: {
      // 店舗リストを取得するメソッド
      async fetchShops(page = 1) {
        // URLパラメータから値を取得
        let key = this.$route.params.key
        // 店舗データを取得する
        const response = await axios.get(`/api/shop-list/${key}?page=` + page)
          // レスポンスステータスがOK以外の時に
          if(response.status !== OK) {
            // エラーステータスを返す
            this.store.commit('error/setCode', response.status)
            return false
        }
        // データ取得
        this.shops = response.data
      },
   },
    // 監視
    watch: {
      $route: {
        // 画面遷移時にfetchShopを実行
        async handler() {
          await this.fetchShops()
        },
        immediate: true
      }
    }
  }
</script>
