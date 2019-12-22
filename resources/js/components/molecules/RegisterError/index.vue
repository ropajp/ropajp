<template>
  <div>
    <div v-if="registerErrors" class="error">
        <ul v-if="registerErrors.name">
            <li v-for="msg in registerErrors.name" :key="msg">{{ msg }}</li>
        </ul>
        <ul v-if="registerErrors.email">
          <li v-for="msg in registerErrors.email" :key="msg">{{ msg }}</li>
        </ul>
        <ul v-if="registerErrors.password">
          <li v-for="msg in registerErrors.password" :key="msg">{{ msg }}</li>
        </ul>
        <ul v-if="registerErrors.password_confirmation">
          <li v-for="msg in registerErrors.password_confirmation" :key="msg">{{ msg }}</li>
        </ul>
    </div>
  </div>
</template>
<script>
  export default {
    computed: {
      registerErrors() {
        return this.$store.state.auth.registerErrorMessages
      }
    },
    methods: {
        clearError() {
          this.$store.commit('auth/setRegisterErrorMessages', null)
      }
    },
    created() {
      this.clearError()
    }
  }
</script>
