<template>
  <div>
    <form class="form" @submit.prevent="login">
    <LoginError />
        <Email v-model="form" :emailLabel="emailLabel"/>
        <Password v-model="form" :passwordLabel="passwordLabel" />
        <RouterLink class="form__item" to="/owners/owner-forgot-passwords">
        パスワードをお忘れですか？
        </RouterLink>
    <button type="submit" class="form__item form__button">ログイン</button>
    </form>
  </div>
</template>
<script>

  import LoginError from '../../molecules/LoginError/index.vue'
  import Email from '../../molecules/Email/index.vue'
  import Password from '../../molecules/Password/index.vue'

  export default {
    components: {
        LoginError,
        Email,
        Password
    },
    data() {
      return {
        form: {
          email: '',
          password: ''
        },
        emailLabel: '店舗メールアドレス',
        passwordLabel: '店舗パスワード'
      }
    },
    computed: {
      apiStatus() {
        return this.$store.state.auth.apiStatus
      }
    },
    methods: {
      async login() {
          // Auth.jsのログインAPIを呼び出す
          await this.$store.dispatch('auth/ownerLogin', this.form)

          if(this.apiStatus) {
            // トップページに遷移する
            this.$router.push('/owners')
          }
      }
    }
  }
</script>
