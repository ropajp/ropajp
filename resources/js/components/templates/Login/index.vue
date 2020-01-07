<template>
  <div class="form--wrapper">
      <div class="form--loginwrapper">
          <div class="form--routeWrapper">
              <Paragraph class="form__msg" :msg="msg" />
              <Route
                  class="form__upperButton"
                  :to="to"
                  :btnName="btnName"
              />
              </div>
              <LoginForm />
          </div>
  </div>
</template>
<script>

import LoginForm from '../../organisms/LoginForm/index.vue'
import Paragraph from '../../atoms/Paragraph/index.vue'
import Route from '../../atoms/Route/index.vue'

  export default {
    components: {
        LoginForm,
        Paragraph,
        Route
    },
    data() {
      return {
        msg: '会員登録をしていない方はこちら',
        btnName: '新規会員登録',
        to: '/register'
      }
    }
  }
</script>
