<template>
  <div>
    <!-- <header> -->
      <Navbar />
    <!-- </header> -->
    <main>
      <div class="container">
        <RouterView />
        <Message />
      </div>
    </main>
    <!-- <Footer /> -->
  </div>
</template>

<script>
import Navbar from '../../organisms/Navbar/index.vue'
import Footer from '../../organisms/Footer/index.vue'
import Message from '../../atoms/Message/index.vue'

import { NOT_FOUND, UNAUTHORIZED, INTERNAL_SERVER_ERROR } from '../../../util'
export default {
  components: {
    Message,
    Navbar,
    Footer,
    },
  computed: {
    errorCode () {
      return this.$store.state.error.code
    }
  },
  watch: {
    errorCode: {
      async handler (val) {
        // 500の場合
        if (val === INTERNAL_SERVER_ERROR) {
          this.$router.push('/500')
          // 419の場合
        } else if (val === UNAUTHORIZED) {
          // トークンリフレッシュ
          await axios.get('/api/refresh-token')
          // ストアのユーザをクリア
          this.$store.commit('auth/setUser', null)
          // ログイン画面へ
          this.$router.push('/login')
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
