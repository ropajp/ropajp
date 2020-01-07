//Vue Routerファイル
import Vue from 'vue'
import VueRouter from 'vue-router'

//ページコンポーネントをインポートする
//共通
// 状態管理モジュール
import store from './store'
// エラー画面
// ステータス500
import SystemError from './components/atoms/SystemError/index.vue'
// ステータス404
import NotFound from './components/atoms/NotFoundError/index.vue'
// 店舗詳細ページ
import ShopDetail from './components/templates/ShopDetail/index.vue'
// 店舗リスト
import ShopList from './components/templates/ShopList/index.vue'
// 利用規約
import TermsOfService from './components/templates/TermsOfService/index.vue'
// カスタマーページ
// ホームページ
import Home from './components/templates/Home/index.vue'
// カスタマーログインページ
import Login from './components/templates/Login/index.vue'
// カスタマー新規登録画面
import Register from './components/templates/Register/index.vue'
// カスタマーパスワードリセットページ
import ForgotPasswords from './components/templates/ForgotPassword/index.vue'
// 店舗ページ
// 店舗ログインページ
import OwnerLogin from './components/templates/OwnerLogin/index.vue'
// 店舗新規登録ページ
import OwnerRegister from './components/templates/OwnerRegister/index.vue'
// 店舗パスワードリセットページ
import OwnerForgotPassword from './components/templates/OwnerForgotPassword/index.vue'
// 店舗情報変更
// セッティングリスト
import SettingList from './components/templates/SettingList/index.vue'
// メールアドレス、パスワード管理
import LoginInfoSetting from './components/templates/LoginInfoSetting/index.vue'
// 店舗名、電話番号管理
import NamePhoneSetting from './components/templates/NamePhoneSetting/index.vue'
// 店舗写真管理
import PhotoSetting from './components/templates/PhotoSetting/index.vue'
// 店舗カテゴリー、対象性別、取り扱いブランド
import DetailSetting from './components/templates/DetailSetting/index.vue'
// 店舗住所変更
import AddressSetting from './components/templates/AddressSetting/index.vue'

// vueRouterを使用することを宣言
Vue.use(VueRouter)

// 以下、画面遷移のロジックを記述
const routes = [
  // ホーム画面
  {
    path: '/',
    component: Home
  },
  //利用規約
  {
    path: '/terms-of-service',
    component: TermsOfService 
  },
  // 店舗リスト画面 key: 検索入力値
  {
    path: `/shop-list/:key`,
    component: ShopList
  },
  // 店舗詳細画面 id: 店舗ID
  {
    path: '/shops/:id',
    component: ShopDetail,
    // :idをpropsとして受け取る
    props: true
  },
  // カスタマーログイン画面
  {
    path: '/login',
    component: Login,
    // 画面遷移する前にチェック
    beforeEnter(to, from, next) {
      // もしカスタマーがログインユザーなら
      if(store.getters['auth/userCheck']) {
        // POPUP表示
        alert('このページを利用するためにはログアウトする必要があります。')
        // ホーム画面へ遷移
        next('/')
        // それ以外なら
      } else {
        // 次の処理へ移動
        next()
      }
    }
  },
  // カスタマー新規登録画面　処理の流れはカスタマーログイン画面と同じ
  {
    path: '/register',
    component: Register,
    beforeEnter(to, from, next) {
      if(store.getters['auth/userCheck']) {
        alert('このページを利用するためにはログアウトする必要があります。')
        next('/')
      } else {
        next()
      }
    }
  },
  {
    path: '/forgot-passwords',
    component: ForgotPasswords,
    // 画面遷移する前にチェック
    beforeEnter(to, from, next) {
      // もしカスタマーがログインユザーなら
      if(store.getters['auth/userCheck']) {
        // POPUP表示
        alert('このページを利用するためにはログアウトする必要があります。')
        // ホーム画面へ遷移
        next('/')
        // それ以外なら
      } else {
        // 次の処理へ移動
        next()
      }
    }
  },
  // 店舗ログイン画面
  {
    path: '/owners/owner-login',
    component: OwnerLogin,
    // 遷移する前にチェック
    beforeEnter(to, from, next) {
      // もしログイン済みユーザがこの画面に遷移しようとしたら
      if(store.getters['auth/shopCheck']) {
        // POPUP表示
        alert('このページを利用するためにはログアウトする必要があります。')
        // 店舗ホーム画面へ遷移
        next('/owners')
        // それ以外なら
      } else {
        // 次の処理へ移動
        next()
      }
    }
  },
  // 店舗新規登録画面　処理の流れは店舗ログイン画面と同じ
  {
    path: '/owners/owner-register',
    component: OwnerRegister,
    beforeEnter(to, from, next) {
      if(store.getters['auth/shopCheck']) {
        alert('このページを利用するためにはログアウトする必要があります。')
        next('/owners')
      } else {
        next()
      }
    }
  },
  // 店舗パスワードリセット
  {
    path: '/owners/owner-forgot-passwords',
    component: OwnerForgotPassword,
    // 画面遷移する前にチェック
    beforeEnter(to, from, next) {
      // もしカスタマーがログインユザーなら
      if(store.getters['auth/shopCheck']) {
        // POPUP表示
        alert('このページを利用するためにはログアウトする必要があります。')
        // ホーム画面へ遷移
        next('/owners')
        // それ以外なら
      } else {
        // 次の処理へ移動
        next()
      }
    }
  },
  // 店舗設定変更リスト画面
  {
    path: '/owners/setting',
    component: SettingList,
    // 遷移前に行う
    beforeEnter(to, from, next) {
      // もし店舗ログインしていないユーザがこの画面に遷移しようとしたら
      if(!store.getters['auth/shopCheck']) {
        // POPUP
        alert('このページを利用するには、ログインが必要です。')
        // 店舗ログイン画面へ移動
        next('/owners/owner-login')
        // ログイン済みなら
      } else {
        // 次の処理へ移動
        next()
      }
    }
  },
  // 店舗名前、電話番号変更画面　処理の流れは店舗設定変更リストと同じ
  {
    path: '/owners/setting/name-phone',
    component: NamePhoneSetting,
    beforeEnter(to, from, next) {
      if(!store.getters['auth/shopCheck']) {
        alert('このページを利用するには、ログインが必要です。')
        next('/owners/owner-login')
      } else {
        next()
      }
    }
  },
  // メールアドレス、パスワード変更画面　処理の流れは店舗設定変更リストと同じ
  {
    path: '/owners/setting/login-info',
    component: LoginInfoSetting,
    beforeEnter(to, from, next) {
      if(!store.getters['auth/shopCheck']) {
        alert('このページを利用するには、ログインが必要です。')
        next('/owners/owner-login')
      } else {
        next()
      }
    }
  },
  // 店舗写真変更画面　処理の流れは店舗設定変更リストと同じ
  {
    path: '/owners/setting/photos',
    component: PhotoSetting,
    beforeEnter(to, from, next) {
      if(!store.getters['auth/shopCheck']) {
        alert('このページを利用するには、ログインが必要です。')
        next('/owners/owner-login')
      } else {
        next()
      }
    }
  },
  // 店舗カテゴリー、対象性別、取り扱いブランド変更画面　処理の流れは店舗設定変更リストと同じ
  {
    path: '/owners/setting/detail',
    component: DetailSetting,
    beforeEnter(to, from, next) {
      if(!store.getters['auth/shopCheck']) {
        alert('このページを利用するには、ログインが必要です。')
        next('/owners/owner-login')
      } else {
        next()
      }
    }
  },
  // 店舗住所変更画面　処理の流れは店舗設定変更リストと同じ
  {
    path: '/owners/setting/address',
    component: AddressSetting,
    beforeEnter(to, from, next) {
      if(!store.getters['auth/shopCheck']) {
        alert('このページを利用するには、ログインが必要です。')
        next('/owners/owner-login')
      } else {
        next()
      }
    }
  },
  // ステータス500がレスポンスされた場合
  {
    path: '/500',
    component: SystemError
  },
  // ステータス404がレスポンスされた場合
  {
    path: '*',
    component: NotFound
  }
  ]


  const router = new VueRouter({
    mode: 'history',
    // ページ移動したときにページの一番上に移動する。
    scrollBehavior() {
      return { x: 0, y: 0 }
    },
    routes,
  })

//app.jsでインポートする
export default router
