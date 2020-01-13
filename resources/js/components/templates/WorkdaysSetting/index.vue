<template>
<!--  -->
  <div class="form--wrapper">
    <div class="form--loginwrapper">
  <h2 class="form__headmsg">営業情報変更</h2>
    <form class="form" @submit.prevent="change">
        <OpenAt v-model="form" :openAtLabel="openAtLabel" />
        <CloseAt v-model="form" :closeAtLabel="closeAtLabel" />
        <DayOff v-model="form" :dayOffLabel="dayOffLabel" />
        <button type="submit" class="form__item form__button">変更</button>
    </form>
    </div>
  </div>
</template>
<script>
  import { OK } from '../../../util'
  import OpenAt from '../../molecules/OpenAt/index.vue'
  import CloseAt from '../../molecules/CloseAt/index.vue'
  import DayOff from '../../molecules/DayOff/index.vue'

  export default {
    components: {
      OpenAt,
      CloseAt,
      DayOff,
    },
    data() {
      return {
        form: {
          open_at: '',
          close_at: '',
          day_off: '',
        },
        openAtLabel: '開店時間',
        closeAtLabel: '閉店時間',
        dayOffLabel: '定休日',
      }
    },
    methods: {
      async fetchWorkdaysData() {
          const response = await axios.get(`/api/owners/setting/workdays/select/${this.shopId}`)
          this.form.open_at = response.data.open_at
          this.form.close_at = response.data.close_at
          this.form.day_off = response.data.day_off
      },
      async change() {
          const response = await axios.post(`/api/owners/setting/workdays/update`, {id: this.shopId, form: this.form})

      if (response.data.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }
      this.$store.commit('message/setContent', {
        content: '営業情報が更新されました！',
        timeout: 3000
      })

      this.$router.push('/owners/setting/workdays')
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
          await this.fetchWorkdaysData()
        },
        immediate: true
      }
    }
  }
</script>
