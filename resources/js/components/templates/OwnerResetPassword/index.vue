<template>
  <div class="form--wrapper">
      <div class="form--loginwrapper">
          <div v-show="loading" class="panel">
            <Loader>送信中...</Loader>
          </div>
          <div v-if="status" class="panel">
            {{ message }}
          </div>
          <form class="form" @submit.prevent="reset" v-show="! loading">
          　<LoginError />
          　<Paragraph class="form__headmsg" :msg="passwordChangeMsg" /><br>
            <Email
                 v-model="form" 
                 :emailLabel="emailLabel"
                 />
            <Password 
                v-model="form" 
                :passwordLabel="passwordLabel"
                />
            <PasswordConfirmation 
                v-model="form"
                :passwordConfirmationLabel="passwordConfirmationLabel"
            />
            <button type="submit" class="form__item form__button">パスワードリセット</button>
          </form>
          </div>
  </div>
</template>
<script>

  import Loader from '../../atoms/Loader/index.vue'
  import Paragraph from '../../atoms/Paragraph/index.vue'
  import Route from '../../atoms/Route/index.vue'
  import LoginError from '../../molecules/LoginError/index.vue'
  import Email from '../../molecules/Email/index.vue'
  import Password from '../../molecules/Password/index.vue'
  import PasswordConfirmation from '../../molecules/PasswordConfirmation/index.vue'

  export default {
    components: {
      Loader,
      LoginError,
      Paragraph,
      Route,
      Email,
      Password,
      PasswordConfirmation
     },
    data() {
      return {
        form: {
          email: '',
          password: '',
          password_confirmation: '',
          token: ''
        },
        loading: false,
        message: 'パスワードの変更が完了しました。ログインしてください。',
        status: false,
        errors: null,
        emailLabel: 'メールアドレス',
        passwordLabel: '新規パスワード',
        passwordConfirmationLabel: '確認用パスワード',
        msg: 'ログイン画面はこちら',
        passwordChangeMsg: '新しいパスワードを入力してください。',
        btnName: 'ログイン',
        to: '/login'
      }
    },
    computed: {
      apiStatus() {
        return this.$store.state.auth.apiStatus
      }
    },
    methods: {
      async reset() {
          this.form.token = this.$route.query.token

          // ローディングメッセージ表示
          this.loading = true
          
          // Auth.jsのログインAPIを呼び出す
          const response = await axios.post(`/api/owners/ownerPassword/reset`, this.form)
        
          // ローディングメッセージ非表示
          this.loading = false

          this.status = response.data.value 
          if(this.status == true) {
            alert(this.message)
            // ログインページに遷移する
            this.$router.push('/owners/owner-login')
          }
      }
    }
  }
</script>
