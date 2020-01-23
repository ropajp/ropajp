<template>
  <div>
    <form class="form" @submit.prevent="register">
      <RegisterError />
        <Paragraph :msg="msg" class="form__label"/>
        <Name v-model="form" :nameLabel="nameLabel" />
        <Email v-model="form" :emailLabel="emailLabel" />
        <Password v-model="form" :passwordLabel="passwordLabel" />
        <PasswordConfirmation v-model="form" :passwordConfirmationLabel="passwordConfirmationLabel" />
        <!-- <PhoneNumber v-model="form" :phoneNumberLabel="phoneNumberLabel" />
        <Url v-model="form" :urlLabel="urlLabel" />
        <Postcode v-model="form" :postcodeLabel="postcodeLabel" />
        <State v-model="form" :stateLabel="stateLabel" />
        <City v-model="form" :cityLabel="cityLabel" />
        <TownStreet v-model="form" :townStreetLabel="townStreetLabel" />
        <Category v-model="form" :categoryLabel="categoryLabel" />
        <GenderFor v-model="form" :genderForLabel="genderForLabel" />
        <Brands v-model="form" :brandsLabel="brandsLabel" />
        <OpenAt v-model="form" :openAtLabel="openAtLabel" />
        <CloseAt v-model="form" :closeAtLabel="closeAtLabel" />
        <DayOff v-model="form" :dayOffLabel="dayOffLabel" />
        <ShopDetail v-model="form" :shopDetailLabel="shopDetailLabel" /> -->
        <button type="submit" class="form__item form__button">新規会員登録</button>
    </form>
  </div>
</template>
<script>

  
  import RegisterError from '../../molecules/RegisterError/index.vue'
  import Paragraph from '../../atoms/Paragraph/index.vue'
  import Name from '../../molecules/Name/index.vue'
  import Email from '../../molecules/Email/index.vue'
  import Password from '../../molecules/Password/index.vue'
  import PasswordConfirmation from '../../molecules/PasswordConfirmation/index.vue'
  import PhoneNumber from '../../molecules/PhoneNumber/index.vue'
  import Url from '../../molecules/Url/index.vue'
  import Postcode from '../../molecules/Postcode/index.vue'
  import State from '../../molecules/State/index.vue'
  import City from '../../molecules/City/index.vue'
  import TownStreet from '../../molecules/TownStreet/index.vue'
  import Category from '../../molecules/Category/index.vue'
  import GenderFor from '../../molecules/GenderFor/index.vue'
  import Brands from '../../molecules/Brands/index.vue'
  import OpenAt from '../../molecules/OpenAt/index.vue'
  import CloseAt from '../../molecules/CloseAt/index.vue'
  import DayOff from '../../molecules/DayOff/index.vue'
  import ShopDetail from '../../molecules/ShopDetail/index.vue'

export default {
  components: {
      RegisterError,
      Paragraph,
      Name,
      Email,
      Password,
      PasswordConfirmation,
      PhoneNumber,
      Url,
      Postcode,
      State,
      City,
      TownStreet,
      Category,
      GenderFor,
      Brands,
      OpenAt,
      CloseAt,
      DayOff,
      ShopDetail
  },
  data() {
     return {
      form: {
          name: '',
          email: '',
          password: '',
          password_confirmation: '',
          phone_number: '',
          url: '',
          postcode: '',
          state: '',
          city: '',
          town_street: '',
          category: '',
          open_at: '',
          close_at: '',
          day_off: '',
          brands: '',
          gender_for: '',
          shop_detail: ''
      },
      msg: '*がついてる箇所は入力必須項目です。メールアドレス以外は後から変更可能です。',
      nameLabel: '* 店舗名',
      emailLabel: '*店舗メールアドレス',
      passwordLabel: '* 店舗パスワード',
      passwordConfirmationLabel: '* 確認用パスワード',
      phoneNumberLabel: '店舗電話番号',
      urlLabel: '店舗URL',
      postcodeLabel: '郵便番号',
      stateLabel: '都道府県',
      cityLabel: '市町村',
      townStreetLabel: '番地・建物名など',
      categoryLabel: '店舗カテゴリー',
      openAtLabel: '開店時間',
      closeAtLabel: '閉店時間',
      dayOffLabel: '定休日',
      brandsLabel: '取り扱いブランド',
      genderForLabel: '対象性別',
      shopDetailLabel: '店舗紹介文'
    }
  },
  computed: {
    apiStatus() {
      return this.$store.state.auth.apiStatus
    }
  },
  methods: {
    async register() {
        //authストアのregisterアクションを呼び出す
        await this.$store.dispatch('auth/ownerRegister', this.form)
        
        if(this.apiStatus) {
          alert('登録が完了しました！ログインしてください。')
          //トップページに移動する
          this.$router.push('/owners/owner-login')
        }
     }
  }
}
</script>
