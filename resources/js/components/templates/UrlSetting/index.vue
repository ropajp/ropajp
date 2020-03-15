<template>
<!--  -->
  <div class="form--wrapper">
    <div class="form--loginwrapper">
  <h2 class="form__headmsg">店舗URL変更</h2>
    <form class="form" @submit.prevent="change">
        <Url v-model="form" :urlLabel="urlLabel" />
        <button type="submit" class="form__item form__button">変更</button>
    </form>
    </div>
  </div>
</template>
<script>
  import { OK } from '../../../util'
  import Url from '../../molecules/Url/index.vue'

  export default {
    components: {
      Url
    },
    data() {
      return {
        form: {
          url: '店舗URL'
        },
        urlLabel: '店舗URL',
        
      }
    },
    methods: {
      async fetchUrlData() {
          const response = await axios.get(`/api/owners/setting/url/select/${this.shopId}`)
          this.form.url = response.data.url
      },
      async change() {
          const response = await axios.post(`/api/owners/setting/url/update`, {id: this.shopId, form: this.form})

      if (response.data.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }
      this.$store.commit('message/setContent', {
        content: '営業情報が更新されました！',
        timeout: 3000
      })

      this.$router.push('/owners/setting/url')
      }
    },
    computed: {
      // ストアから店舗IDを取得
      shopId() {
        return this.$store.getters['auth/shopId']
      }
    },
    watch: {
      $route: {
        // 画面遷移時にfetchWorkdaysDataを実行
        async handler() {
          await this.fetchUrlData()
        },
        immediate: true
      }
    }
  }
</script>
