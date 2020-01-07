<template>
    <div class="form--wrapper">
        <div class="form--registerwrapper">
          <div class="form--routeWrapper">
              <Paragraph class="form__msg" :msg="msg" />
              <Route
                  class="form__upperButton"
                  :to="to"
                  :btnName="btnName"
              />
              </div>
              <RegisterForm />
          </div>
        </div>
</template>
<script>

  import Paragraph from '../../atoms/Paragraph/index.vue'
  import Route from '../../atoms/Route/index.vue'
  import RegisterForm from '../../organisms/RegisterForm/index.vue'

export default {
  components: {
    Paragraph,
    Route,
    RegisterForm
  },
  data() {
     return {
       msg: '既にアカウントをお持ちの方はこちら',
       btnName: 'ログイン',
       to: '/login'
    }
  }
}
</script>
