<template>
      <div>
          <div v-if="loginErrors" class="errors">
            <ul v-if="loginErrors.email">
                <li v-for="msg in loginErrors.email" :key="msg">{{ msg }}</li>
            </ul>
            <ul v-if="loginErrors.password">
                <li v-for="msg in loginErrors.password" :key="msg">{{ msg }}</li>
            </ul>
          </div>
          </div>
</template>
<script>
  export default {
    computed: {
      loginErrors() {
        return this.$store.state.auth.loginErrorMessages
      }
    },
    methods: {
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
