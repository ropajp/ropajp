<template>
  <div class="container--small">
      <div class="form--loginwrapper">
          <div class="form--routeWrapper">
              <p class="form__msg">初めて店舗登録される方はこちら</p>
              <RouterLink class="form__item form__upperButton" to="/owners/owner-register">
              新規店舗登録
              </RouterLink>
          </div>
          <form class="form" @submit.prevent="login">
          <div v-if="loginErrors" class="errors">
            <ul v-if="loginErrors.email">
                <li v-for="msg in loginErrors.email" :key="msg">{{ msg }}</li>
            </ul>
            <ul v-if="loginErrors.password">
                <li v-for="msg in loginErrors.password" :key="msg">{{ msg }}</li>
            </ul>
          </div>
            <label for="login-email">店舗メールアドレス</label>
              <input type="text" class="form__item form__text" id="login-email" placeholder="登録したメールアドレス" v-model="loginForm.email">
            <label for="login-password" class="form">店舗パスワード</label>
              <input type="password" class="form__item form__text" id="login-password" placeholder="8文字以上" v-model="loginForm.password">
              <RouterLink class="form__item" to="/owners/owner-forgot-passwords">
              パスワードをお忘れですか？
              </RouterLink>
            <button type="submit" class="form__item form__button">ログイン</button>
          </form>
          </div>
  </div>
</template>
<script>
  export default {
    data() {
      return {
        loginForm: {
          email: '',
          password: ''
        }
      }
    },
    computed: {
      apiStatus() {
        return this.$store.state.auth.apiStatus
      },
      loginErrors() {
        return this.$store.state.auth.loginErrorMessages
      }
    },
    methods: {
      async login() {
          // Auth.jsのログインAPIを呼び出す
          await this.$store.dispatch('auth/ownerLogin', this.loginForm)

          if(this.apiStatus) {
            // トップページに遷移する
            this.$router.push('/owners')
          }
      },
      clearError() {
        this.$store.commit('auth/setLoginErrorMessages', null)
      }
    },
    //ログインページを表示するタイミングでエラーメッセージをクリア
    created() {
      this.clearError()
    }
  }
</script>
