<template>
<!-- name phone_numer -->
  <div class="form--wrapper">
    <div class="form--loginwrapper">
  <h2 class="form__headmsg">名前・電話番号変更</h2>
    <form class="form" @submit.prevent="change">
        <Name v-model="form" :nameLabel="nameLabel" />
        <PhoneNumber v-model="form" :phoneNumberLabel="phoneNumberLabel" />
        <button type="submit" class="form__item form__button">変更</button>
    </form>
    </div>
  </div>
</template>
<script>
  import { OK } from '../../../util'
  import Name from '../../molecules/Name/index.vue'
  import PhoneNumber from '../../molecules/PhoneNumber/index.vue'

  export default {
    components: {
      Name,
      PhoneNumber,
    },
    data() {
      return {
        form: {
          name: '',
          phone_number: ''
        },
        nameLabel: '店舗名',
        phoneNumberLabel: '店舗電話番号'
      }
    },
    methods: {
      async fetchNamePhoneData() {
          const response = await axios.get(`/api/owners/setting/namePhone/select/${this.shopId}`)
          this.form.name = response.data.name
          this.form.phone_number = response.data.phone_number
      },
      async change() {
          const response = await axios.post(`/api/owners/setting/namePhone/update`, {id: this.shopId, form: this.form})

          if (response.data.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }
      this.$store.commit('message/setContent', {
        content: '住所情報が更新されました！',
        timeout: 3000
      })

          this.$router.push('/owners/setting/name-phone')
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
        // 画面遷移時にfetchNamePhoneDataを実行
        async handler() {
          await this.fetchNamePhoneData()
        },
        immediate: true
      }
    }
  }
</script>
