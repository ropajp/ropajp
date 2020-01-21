<template>
  <nav class="navbar">
    <RouterLink class="navbar__brand" to="/owners">
      Ropa.jp
    </RouterLink>
    <!-- ログイン状態の場合 -->
    <RouterLink class="navbar__configLink navbar__item" v-if="isLogin"   to="/owners/setting">
      店舗情報変更
    </RouterLink>
    <RouterLink class="navbar__page-check navbar__item" v-if="isLogin" @click.native="toShopPage" :to="to">
      表示チェックはこちら
    </RouterLink>
    <div class="navbar__auth">
    <div v-if="isLogin" class="navbar__item">
      <span>
         <i class="fas fa-store"></i> {{ shopname }}
      </span>
      <button class="button button--logoutLink" @click="logout">ログアウト</button>
      </div>
      <!-- ログインしてない場合 -->
      <div v-else class="navbar__item">
      <RouterLink class="button button--middle--link navbar--register" to="/owners/owner-register">
       新規店舗登録
      </RouterLink>
      <RouterLink class="button button--middle--link navbar--login" to="/owners/owner-login">
        店舗ログイン
      </RouterLink>
        </div>
    </div>
  </nav>
</template>
<script>
  export default {
    data() {
      return {
        to: ''
      }
    },
    computed: {
      isLogin() {
        return this.$store.getters['auth/shopCheck']
      },
      shopname() {
        return this.$store.getters['auth/shopname']
      },
      shopId() {
        return this.$store.getters['auth/shopId']
      }
    },
    methods: {
      async logout() {

        var   message = 'ログアウトしますか？'

        if(confirm(message)) {
          
          await this.$store.dispatch(`auth/ownerLogout`)
          alert('ログアウトしました')

          this.$router.push(`/owners/owner-login`)

          }
      },
      toShopPage() {
        const id =this.shopId
        this.to = '/owners/shops/' + id
      }
    }
  }
</script>
