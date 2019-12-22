<template>
<!-- name phone_numer -->
  <div class="container--small">
  <h2 class="form__headmsg">名前・電話番号変更</h2>
    <form class="form" @submit.prevent="change">
        <Name v-model="form" :nameLabel="nameLabel" />
        <PhoneNumber v-model="form" :phoneNumberLabel="phoneNumberLabel" />
        <button type="submit" class="form__item form__button">変更</button>
    </form>
  </div>
</template>
<script>

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
      change() {
          this.$router.push('/owners')
      }
    }
  }
</script>
