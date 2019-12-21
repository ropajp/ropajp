<template>
  <nav class="navbar">
          <RouterLink class="navbar__brand" to="/">
              Ropa.com
          </RouterLink>
          <SearchBar
              class="navbar__search"
          />
          <div class="navbar__auth">
            <span v-if="isLogin">
                 {{ username }}
              </span>
              <button class="button button--middle navbar--login" @click="logout" v-if="isLogin">
                  ログアウト
              </button>
              <div v-else>
                  <RouterLink class="button button--middle--link navbar--register" to="/register">
                      新規登録
                  </RouterLink>
                  <RouterLink class="button button--middle--link navbar--login" to="/login">
                      ログイン
                  </RouterLink>
              </div>
         </div>
  </nav>
</template>
<script>
import SearchBar from '../../molecules/SearchBar/index.vue'

  export default {
    components: {
      SearchBar
    },
    computed: {
      isLogin() {
        return this.$store.getters['auth/userCheck']
      },
      username() {
        return this.$store.getters['auth/username']
      }
    },
    methods: {
      async logout() {

        var   message = 'ログアウトしますか？'

        if(confirm(message)) {

          await this.$store.dispatch(`auth/logout`)
          alert('ログアウトしました')

          this.$router.push(`/login`)
          }
      }
    }
  }
</script>
