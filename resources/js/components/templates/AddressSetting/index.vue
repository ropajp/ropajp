<template>
  <!-- 住所変更 -->
  <div class="container--small">
  <h2 class="form__headmsg">住所情報変更</h2>
    <form class="form" @submit.prevent="change">
        <Postcode v-model="form" :postcodeLabel="postcodeLabel" />
        <State v-model="form" :stateLabel="stateLabel" />
        <City v-model="form" :cityLabel="cityLabel" />
        <TownStreet v-model="form" :townStreetLabel="townStreetLabel" />
        <button type="submit" class="form__item form__button">変更</button>
    </form>
  </div>
</template>
<script>
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
      change() {
          this.$router.push('/owners')
      }
    }
  }
</script>
