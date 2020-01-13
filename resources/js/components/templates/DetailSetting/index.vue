<template>
<!-- category gender_for brands shop_detail -->
   <div class="form--wrapper">
    <div class="form--loginwrapper">
    <h2 class="form__headmsg">店舗詳細情報変更</h2>
      <form class="form" @submit.prevent="change">
          <Category v-model="form" :categoryLabel="categoryLabel" />
          <GenderFor v-model="form" :genderForLabel="genderForLabel" />
          <Brands v-model="form" :brandsLabel="brandsLabel" />
          <ShopDetail v-model="form" :shopDetailLabel="shopDetailLabel" />
          <button type="submit" class="form__item form__button">変更</button>
      </form>
      </div>
    </div>
  </template>
  <script>
  import { OK } from '../../../util'
  import Category from '../../molecules/Category/index.vue'
  import GenderFor from '../../molecules/GenderFor/index.vue'
  import Brands from '../../molecules/Brands/index.vue'
  import ShopDetail from '../../molecules/ShopDetail/index.vue'

    export default {
      components: {
      Category,
      GenderFor,
      Brands,
      ShopDetail
      },
      data() {
        return {
          form: {
          category: '',
          brands: '',
          gender_for: '',
          shop_detail: ''
          },
          categoryLabel: '店舗カテゴリー',
          brandsLabel: '取り扱いブランド',
          genderForLabel: '対象性別',
          shopDetailLabel: '店舗紹介文'
        }
      },
      methods: {
        async fetchDetailData() {
          const response = await axios.get(`/api/owners/setting/detail/select/${this.shopId}`)
          this.form.category = response.data.category
          this.form.brands = response.data.brands
          this.form.gender_for = response.data.gender_for
          this.form.shop_detail = response.data.shop_detail
        },
        async change() {
            const response = await axios.post(`/api/owners/setting/detail/update`, {id: this.shopId, form: this.form})

            if (response.data.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }
      this.$store.commit('message/setContent', {
        content: '詳細情報が更新されました！',
        timeout: 3000
      })

            this.$router.push('/owners/setting/detail')
        }
      },
      computed: {
        // ストアから店舗IDを取得
        shopId(){
          return this.$store.getters['auth/shopId']
        }
      },
      watch: {
        $route: {
          // 画面遷移時にfetchDetailDataを更新
          async handler() {
            await this.fetchDetailData() 
          },
          immediate: true
        }
      }
    }
  </script>
