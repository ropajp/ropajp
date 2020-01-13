<template>
    <div class="form--wrapper">
      <div class="form--registerwrapper">
        <h2 class="form__headmsg">新規店舗登録</h2>
        <div class="form--routeWrapper">
              <Paragraph class="form__msg" :msg="msg" />
              <Route
                  class="form__upperButton"
                  :to="to"
                  :btnName="btnName"
              />
        </div>
          <OwnerRegisterCmp />
      </div>
    </div>
</template>
<script>

import OwnerRegisterCmp from '../../organisms/OwnerRegisterForm/index.vue'
import Paragraph from '../../atoms/Paragraph/index.vue'
import Route from '../../atoms/Route/index.vue'

export default {
  components: {
    OwnerRegisterCmp,
    Paragraph,
    Route
  },
  data() {
  return {
    msg: 'すでに登録済みの方はこちら',
    btnName: '店舗ログイン',
    to: '/owners/owner-login',
  }
  }
}
</script>
