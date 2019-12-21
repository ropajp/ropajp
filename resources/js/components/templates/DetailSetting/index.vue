<template>
<!-- category gender_for brands shop_detail -->
    <div class="container--small">
    <h2 class="form__headmsg">店舗詳細情報変更</h2>
      <form class="form" @submit.prevent="change">
          <Category v-model="form" :categoryLabel="categoryLabel" />
          <GenderFor v-model="form" :genderForLabel="genderForLabel" />
          <Brands v-model="form" :brandsLabel="brandsLabel" />
          <ShopDetail v-model="form" :shopDetailLabel="shopDetailLabel" />
          <button type="submit" class="form__item form__button">変更</button>
      </form>
    </div>
  </template>
  <script>

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
        change() {
            this.$router.push('/owners')
        }
      }
    }
  </script>
