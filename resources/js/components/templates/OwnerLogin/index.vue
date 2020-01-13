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
        <OwnerLoginForm />
  </div>
 </div>
</template>
<script>

  import OwnerLoginForm from '../../organisms/OwnerLoginForm/index.vue'
  import Paragraph from '../../atoms/Paragraph/index.vue'
  import Route from '../../atoms/Route/index.vue'

  export default {
    components: {
      OwnerLoginForm,
      Paragraph,
      Route
    },
    data() {
      return {
        msg: '会員登録してない方はこちら',
        btnName: '新規店舗登録',
        to: '/owners/owner-register'
      }
    }
  }
</script>
