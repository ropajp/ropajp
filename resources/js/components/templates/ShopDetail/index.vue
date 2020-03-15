<template>
  <div v-if="shop" class="shop-detail">
    <div class="slider-box" v-cloak>
      <div class="slider-main">
        <a href="javascript:void(0);" class="slider-prev-btn" v-on:click="sliderPrev"><i></i></a>
            <div class="slider-content-box"
                  ref="SliderContentBox"
            >
              <transition v-bind:name="transitionName">
                   <div class="slider-content"
                          v-for="(image, index) in shop.photos"
                          v-if="visibleContent == index"
                          :key="image.id"
                   >
                        <img class="slider-content__img"
                            :src="image['url']"
                            ref="image"
                        >
                  </div>
              </transition>
          </div><!-- slider-content-box -->
      <a href="javascript:void(0);" class="slider-next-btn" @click="sliderNext"><i></i></a>
      </div><!-- slider-main -->
      <div class="slider-footer">
         <ul>
            <li class="slider-footer-dot"
                v-for="(image, index) in shop.photos"
                :class="{'is-visible': visibleContent == index}"
            ></li>
         </ul>
      </div>
  </div><!-- slider-box -->

      <div class="shop-detail__pane">
          <div class="shop-detail__favorite-btn">
              <button
                  class="favorite favorite--favorite"
                  :class="{ 'favorite--favorited': shop.favorite_by_user }"
                  title="favorite shop"
                  @click="onFavoriteClick"
                  >
                  <i class="icon ion-md-heart"></i>
              </button>
           </div>
          <div class="shop-detail__intro">
              <div class="shop-detail__username">
                  {{ shop.name }}
              </div>
              <div class="shop-detail__state">
                  {{ shop.state }}{{ shop.city }}
              </div>
              <div class="shop-detail__category">
                  {{ shop.gender_for }}   {{ shop.category }}
              </div>
              <div v-if="shop.open_at !== null && shop.close_at !== null"  class="shop-detail__bussiness-info">
                  営業時間: {{ shop.open_at }} ~ {{ shop.close_at }}
              </div>
              <div v-if="shop.day_off !== null" class="shop-detail__bussiness-info" >
                  定休日: {{ shop.day_off }}
              </div>
          </div>

          <div class="shop-detail__content">
              <h5 class="shop-detail__sub-title">
                  <i class="fas fa-tshirt"></i>　
                  <span class="mini-title">取り扱いブランド</span>
              </h5>
                  <div v-if="shop.brands == null " class="shop-detail__sub-content">
                    <span class="mini-title">情報がありません</span>
                  </div>
                  <div v-else class="shop-detail__sub-content">
                    <span class="mini-contents">{{ shop.brands }}</span>
                  </div>
              <h5 class="shop-detail__sub-title">
                  <i class="fas fa-map-marker-alt"></i>　
                  <span class="mini-title">住所</span>
              </h5>
                  <div v-if="shop.state == null || shop.city == null || shop.town_street ==null" class="shop-detail__sub-content">
                    <span class="mini-title">情報がありません</span>
                  </div>
                  <div v-else class="shop-detail__sub-content">
                    <span class="mini-contents">{{shop.state}}{{shop.city}}{{shop.town_street}}</span>
                  </div>
              <h5 class="shop-detail__sub-title">
                  <i class="fas fa-link"></i>URL
              </h5>
                  <div v-if="shop.url == null " class="shop-detail__sub-content">
                    <span class="mini-title">情報がありません</span>
                  </div>
                  <div  v-else class="shop-detail__sub-content"> 　
                      <a v-bind:href="shop.url" class="mini-contents  shop-detail__url" target="_blank">{{ shop.url }}</a>
                  </div>
              <h5 class="shop-detail__sub-title">
                  <i class="fas fa-store"></i>
                  <span class="mini-title">店舗紹介</span>
              </h5>
                  <div v-if="shop.shop_detail == null " class="shop-detail__sub-content">
                    <span class="mini-title">情報がありません</span>
                  </div>
                  <div v-else class="shop-detail__sub-content">
                    <span class="mini-contents">{{shop.shop_detail}}</span>
                  </div>
          </div>


          <h3 class="shop-detail__title">
              <i class="icon ion-md-chatboxes">コメント</i>
          </h3>
          <form v-if="isLogin" @submit.prevent="addComment" class="form shop-detail__form">

            <div v-if="commentErrors" class="errors">
              <ul v-if="commentErrors.content">
                <li v-for="msg in commentErrors.content" :key="msg">{{ msg }}</li>
              </ul>
            </div>

            <textarea
                class="form__item shop-detail__item"
                 v-model="commentContent"
                 placeholder="口コミを入力してください"
            >
            </textarea>
              <div class="">
                <button type="submit" class="button button--inverse button--middle">投稿する</button>
              </div>
          </form>
          <span v-else>※コメントするにはログインしてください。</span>
        <ul v-if="shop.comments.length > 0" class="shop-detail__comments">
            <li
              v-for="comment in shop.comments"
              class="shop-detail__content shop-detail__commentItem"
            >
                <p class="shop-detail__content shop-detail__commentBody">
                  {{ comment.content }}
                </p>
                <p class="shop-detail__content shop-detail__commentInfo">
                  {{ comment.author.name }}　{{ comment.created_at }}
                </p>
            </li>
        </ul>
        <p v-else>
          {{ shop.name }}へのコメントはまだありません
        </p>
      </div>
  </div>
</template>
<script>
  import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../../../util'

  export default {
    props: {
      // URIのid
      id: {
        type: String,
        required: true
      }
    },
    data() {
      return {
        // 店舗フェッチ用
        shop: null,
        // コメントの内容
        commentContent: '',
        // コメントエラー時
        commentErrors: null,
        landscape: false,
        portrait: false,
        winWidth: window.innerWidth,
        visibleContent: 0,
        transitionName: 'show-next'
      }
    },
    methods: {
      // 店舗情報取得
      async fetchShop() {
        const response = await axios.get(`/api/shops/${this.id}`)
        // ステータスがOK以外の時
        if(response.status != OK) {
          this.$store.commit('error/setCode', response.status)
          return false
        }
        // レスポンスデータをshop変数に格納
        this.shop = response.data
      },
      async addComment() {
        // ajax
        const response = await axios.post(`/api/shops/${this.id}/comments`, {
          // 入力されたコメント
          content: this.commentContent
        })

        // バリデーション
        if(response.status === UNPROCESSABLE_ENTITY) {
          // レスポンスされたエラーメッセージを格納
          this.commentErrors = response.data.errors
          return false
        }

        // 入力されたコメントをクリア
        this.commentContent = ''
        // 表示されたエラーメッセージをクリア
        this.commentErrors = null

        // その他のエラーハンドリング
        if(response.status != CREATED) {
          // storeのエラーメッセージをコミット
          this.$store.commit('error/setCode', response.status)
          return false
        }

        // コメントの投稿があった時、コメントのみを更新する
        this.$set(this.shop, 'comments', [
          response.data,
          ...this.shop.comments
        ])
      },
      onFavoriteClick() {
        if(! this.isLogin) {
          alert('店舗をお気に入りに追加するにはログインしてください')
          return false
        }

        if(this.shop.favorite_by_user) {
          this.unfavorite()
        } else {
          this.favorite()
        }
      },
      async favorite() {
        const response = await axios.put(`/api/shops/${this.id}/favorite`)

        if(response.status !== OK) {
          this.$store.commit('error/setCode', response.status)
          return false
        }

        // this.$set(this.shop, 'favorites_count', this.shop.favorites_count + 1)
        this.$set(this.shop, 'favorite_by_user', true)
      },
      async unfavorite() {
        const response = await axios.delete(`/api/shops/${this.id}/favorite`)

        if(response.status !== OK) {
          this.$store.commit('error/setCode', response.status)
          return false
        }

        // this.$set(this.shop, 'favorites_count', this.shop.favorites_count - 1)
        this.$set(this.shop, 'favorite_by_user', false)
      },
      // スライダー
      // スライダーを戻す処理
      sliderPrev() {
         this.transitionName = 'show-prev'
         // indexが0の写真を表示時スライドする場合
         if(this.visibleContent === 0) {
           // 一番最後の写真に移動
            this.visibleContent = this.shop.photos.length - 1
            // それ以外の場合
         } else {
           // 前のindexの写真に移動
           this.visibleContent--
         }
       },
       // 次のスライダーに遷移
       sliderNext() {
         this.transitionName = 'show-next'
         // indexが一番最後の写真を表示している場合
         if(this.visibleContent === this.shop.photos.length -1) {
           // 一番最初の画像にする
           this.visibleContent = 0
           // それ以外の場合
         } else {
           // 次のindexの写真に移動
           this.visibleContent++
         }
       },
       // ウィンドウを更新する処理
       setWindowWitdth() {
         this.winWidth = window.innerWidth
       },
    created: function() {
      // リサイズ時にウィンドウサイズを更新する処理を設定
      window.addEventListener('resize', this.setWindowWidth, false)
       }
     },
    beforeDestroy: function() {
      // リサイズ時にウィンドウサイズを更新する処理を削除
      window.removeEventListener('resize', this.setWindowWidth, false)
    },
    computed: {
      // ログインチェック
      isLogin() {
        return this.$store.getters['auth/userCheck']
      }
    },
    watch: {
      $route: {
        // 画面遷移時にfetchShopを実行
        async handler() {
          await this.fetchShop()
        },
        immediate: true
      }
    }
  }
</script>
