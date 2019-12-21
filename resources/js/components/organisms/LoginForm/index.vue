<template>
      <div>
          <form class="form" @submit.prevent="login">
          <LoginError />
          <Email v-model="form" :emailLabel="emailLabel"/>
          <Password v-model="form" :passwordLabel="passwordLabel" />
          <RouterLink class="form__item" to="/forgot-passwords">
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
        form : {
          email:'',
          password: ''
        },
        emailLabel: 'メールアドレス',
        passwordLabel: 'パスワード'
      }
    },
    methods: {
      changeEmail(user_email) {
        this.user_email = user_email
      },
      async login() {
          // Auth.jsのログインAPIを呼び出す
          await this.$store.dispatch('auth/login', this.form)

           if(this.apiStatus) {
            // トップページに遷移するsetLogin
            this.$router.push('/')
          }
        }
       },
       computed: {
         apiStatus() {
           return this.$store.state.auth.apiStatus
         }
       }
}
</script>
