<template>
    <div class="container--small">
      <div class="form--registerwrapper">
        <h2 class="form__headmsg">新規店舗登録</h2>
        <div class="form--routeWrapper">
              <FormMsgCmp :msg="msg" />
              <RouteToAnotherPageCmp  :to="to" :btnName="btnName" />
        </div>
          <OwnerRegisterCmp />
      </div>
    </div>
</template>
<script>

import OwnerRegisterCmp from '../../organisms/OwnerRegisterForm/index.vue'
import FormMsgCmp from '../../atoms/Paragraph/index.vue'
import RouteToAnotherPageCmp from '../../atoms/Route/index.vue'

export default {
  components: {
    OwnerRegisterCmp,
      FormMsgCmp,
      RouteToAnotherPageCmp
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
