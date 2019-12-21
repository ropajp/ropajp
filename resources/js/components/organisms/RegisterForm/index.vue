<template>
    <div>
        <form class="form" @submit.prevent="register">
                <RegisterError />
                <Name
                    v-model="form"
                    :nameLabel="nameLabel"
                />
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
                <button type="submit" class="form__item form__button">新規会員登録</button>
            </form>
        </div>
</template>
<script>

  import Name from '../../molecules/Name/index.vue'
  import Email from '../../molecules/Email/index.vue'
  import Password from '../../molecules/Password/index.vue'
  import PasswordConfirmation from '../../molecules/PasswordConfirmation/index.vue'
  import RegisterError from '../../molecules/RegisterError/index.vue'

export default {
  components: {
    Name,
    Email,
    Password,
    PasswordConfirmation,
    RegisterError
  },
  data() {
     return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      },
      nameLabel: '氏名',
      emailLabel: 'メールアドレス',
      passwordLabel: 'パスワード',
      passwordConfirmationLabel: '確認用パスワード'
    }
  },
  methods: {
    async register() {
        //authストアのregisterアクションを呼び出す
        await this.$store.dispatch('auth/register', this.form)

        if(this.apiStatus) {
          //トップページに移動する
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
