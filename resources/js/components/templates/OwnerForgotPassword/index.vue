<template>
  <div class="form--wrapper">
      <div class="form--loginwrapper">
          <div class="form--routeWrapper">
          <Paragraph class="form__headmsg" :msg="msg"/>
          <Route
              :to="to" :btnName="btnName"
              class="form__item form__upperButton"
              />
          </div>
          <div v-show="loading" class="panel">
            <Loader>送信中...</Loader>
          </div>
          <div v-if="status" class="panel">
            {{ message }}
          </div>
          <form class="form" @submit.prevent="reset" v-show="! loading">
          　<LoginErrorCmp />
          　<Paragraph class="form__headmsg" :msg="passwordChangeMsg" /><br>
            <Email v-model="form"/>
            <button type="submit" class="form__item form__button">メールを送信</button>
          </form>
          </div>
  </div>
</template>
<script>

  import Loader from '../../atoms/Loader/index.vue'
  import Paragraph from '../../atoms/Paragraph/index.vue'
  import Route from '../../atoms/Route/index.vue'
  import LoginErrorCmp from '../../molecules/LoginError/index.vue'
  import Email from '../../molecules/Email/index.vue'

  export default {
    components: {
      Loader,
      Paragraph,
      LoginErrorCmp,
      Route,
      Email
     },
    data() {
      return {
        form: {
          email: ''
        },
        loading: false,
        message: null,
        status: false,
        errors: null,
        msg: '店舗ログイン画面はこちら',
        passwordChangeMsg: 'パスワードを変更するために、パスワード変更用メールを送信してください。',
        btnName: 'ログイン',
        to: '/owners/owner-login'
      }
    },
    computed: {
      apiStatus() {
        return this.$store.state.auth.apiStatus
      }
    },
    methods: {
      async reset() {

          // ローディングメッセージ表示
          this.loading = true
          // メール送信
          const response = await axios.post('/api/owners/ownerPassword/email', this.form)
          // ローディングメッセージ非表示
          this.loading = false

          this.status = response.data.status
          if(this.status == true ) {

            this.message = response.data.message
            alert(this.message)
            // トップページに遷移する
            this.$router.push('/owners/owner-login')
          }
      }
    }
  }
</script>
