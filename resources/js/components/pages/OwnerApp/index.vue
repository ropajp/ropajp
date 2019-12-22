<template>
  <div>
    <header>
      <OwnerNavbar />
    </header>
    <main>
      <div class="container">
        <Message />
        <RouterView />
      </div>
    </main>
  </div>
</template>

<script>
import OwnerNavbar from '../../organisms/OwnerNavbar/index.vue'
import OwnerFooter from '../../organisms/OwnerFooter/index.vue'
import Message from '../../atoms/Message/index.vue'

import { NOT_FOUND, UNAUTHORIZED, INTERNAL_SERVER_ERROR } from '../../../util'
export default {
  components: {
    Message,
    OwnerNavbar,
    OwnerFooter
  },
  computed: {
    errorCode () {
      return this.$store.state.error.code
    }
  },
  watch: {
    errorCode: {
      async handler (val) {
        if (val === INTERNAL_SERVER_ERROR) {
          this.$router.push('/500')
        } else if (val === UNAUTHORIZED) {
          // トークンリフレッシュ
          await axios.get('/api/refresh-token')
          // ストアのユーザをクリア
          this.$store.commit('auth/setShop', null)
          // ログイン画面へ
          this.$router.push('/owners/owner-login')
        } else if (val === NOT_FOUND) {
            this.$router.push('/not-found')
         }
      },
      immediate: true
    },
    $route () {
      this.$store.commit('error/setCode', null)
    }
  }
}
</script>
