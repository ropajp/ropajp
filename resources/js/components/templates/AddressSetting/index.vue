<template>
  <!-- 住所変更 -->
  <div class="form--wrapper">
    <div class="form--loginwrapper">
  <h2 class="form__headmsg">住所情報変更</h2>
    <form class="form" @submit.prevent="change">
        <Postcode v-model="form" :postcodeLabel="postcodeLabel" />
        <State v-model="form" :stateLabel="stateLabel" />
        <City v-model="form" :cityLabel="cityLabel" />
        <TownStreet v-model="form" :townStreetLabel="townStreetLabel" />
        <button type="submit" class="form__item form__button">変更</button>
    </form>
    </div>
  </div>
</template>
<script>
  import { OK } from '../../../util'
  import Postcode from '../../molecules/Postcode/index.vue'
  import State from '../../molecules/State/index.vue'
  import City from '../../molecules/City/index.vue'
  import TownStreet from '../../molecules/TownStreet/index.vue'

  export default {
    components: {
      Postcode,
      State,
      City,
      TownStreet
    },
    data() {
      return {
        form: {
          postcode: '',
          state: '',
          city: '',
          town_street: ''
        },
        postcodeLabel: '郵便番号',
        stateLabel: '都道府県',
        cityLabel: '市町村',
        townStreetLabel: '番地・建物名など',
      }
    },
    methods: {
      async fetchAddressData() {
          const response = await axios.get(`/api/owners/setting/address/select/${this.shopId}`)
          this.form.postcode = response.data.postcode
          this.form.state = response.data.state
          this.form.city = response.data.city
          this.form.town_street = response.data.town_street
      },
      async change() {
          const response = await axios.post(`/api/owners/setting/address/update`, {id: this.shopId, form: this.form})

      if (response.data.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }
      this.$store.commit('message/setContent', {
        content: '住所情報が更新されました！',
        timeout: 3000
      })
      this.$router.push('/owners/setting/address')
      }
    },
    computed: {
      // ストアから店舗Idを取得
      shopId(){
        return this.$store.getters['auth/shopId']
      }
    },
    watch: {
      $route: {
        // 画面遷移時にfetchAddressData実行
        async handler() {
          await this.fetchAddressData()
        },
        immediate: true
      }
    }
  }
</script>
