/**
* Vuex
* Authストア
* 1.店舗新規
* 2.店舗ログイン
* 3.店舗ログアウト
* 4.店舗ログインチェック
* 5. 会員登録
* 6. ログイン
* 7. ログアウト
* 8.ユーザチェック
*/
import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../util'

const state = {
  user: null,
  shop: null,
  apiStatus: null,
  loginErrorMessages: null,
  registerErrorMessages: null
}

const getters = {
  // ログインユーザチェック
     userCheck: state => !! state.user,
     username: state => state.user ? state.user.name : '' ,
     shopCheck: state => !! state.shop,
     shopname: state => state.shop ? state.shop.name : '',
     shopId: state => state.shop ? state.shop.id: ''
  }

const mutations = {
  setUser(state, user) {
    state.user = user
  },
  setShop(state, shop) {
    state.shop = shop
  },
  setApiStatus(state, status) {
    state.apiStatus = status
  },
  setLoginErrorMessages(state, messages) {
    state.loginErrorMessages = messages
  },
  setRegisterErrorMessages(state, messages) {
    state.registerErrorMessages = messages
  }
}

const actions = {

  // 店舗新規登録
  async ownerRegister(context, data) {
    context.commit('setShop', null)
    const response = await axios.post('/api/owners/ownerRegister', data)
    // 非同期処理に成功した場合
    if(response.status === CREATED) {
      context.commit('setApiStatus', true)
      context.commit('setShop', response.data)
      return false
    }

    // 失敗した場合
    context.commit('setApiStatus', false)

    if(response.status === UNPROCESSABLE_ENTITY) {
      context.commit('setRegisterErrorMessages', response.data.errors)
    } else {
      context.commit('error/setCode', response.status, { root: true })
    }
  },
  // 店舗ログイン
  async ownerLogin(context, data) {
    context.commit('setApiStatus', null)
    const response = await axios.post('/api/owners/ownerLogin', data)

    // 非同期処理が成功した場合
    if(response.status === OK) {
        context.commit('setApiStatus', true)
        context.commit('setShop', response.data)
        return false
    }
    //失敗した場合
    context.commit('setApiStatus', false)

    if(response.status == UNPROCESSABLE_ENTITY) {
      context.commit('setLoginErrorMessages', response.data.errors)
    } else {
      // 別のストアモジュールのミューテーションをコミットする場合は第三引数
      //に{ root: true } を追加する。
      context.commit('error/setCode', response.status, { root: true })
    }
  },
  // 店舗ログアウト
  async ownerLogout(context) {
    context.commit('setApiStatus', null)
    const response = await axios.post('/api/owners/ownerLogout')

    if(response.status === OK) {
        context.commit('setApiStatus', true)
        context.commit('setShop', null)
        console.log(state.shop);
        return false
    }

    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root:true })
  },
  //会員登録
  async register(context, data) {
    context.commit('setUser', null)
    const response = await axios.post('/api/register', data)
    // 非同期処理に成功した場合
    if(response.status === CREATED) {
        context.commit('setApiStatus', true)
        context.commit('setUser', response.data)
        return false
    }

    // 失敗した場合
    context.commit('setApiStatus', false)

    if(response.status === UNPROCESSABLE_ENTITY) {
        context.commit('setRegisterErrorMessages', response.data.errors)
    } else {
        context.commit('error/setCode', response.status, { root: true })
    }
  },
  //ログインAPI
  async login(context, data) {
    context.commit('setApiStatus', null)
    const response = await axios.post('/api/login', data)

    // 非同期処理が成功した場合
    if(response.status === OK) {
      console.log(response.data)
        context.commit('setApiStatus', true)
        context.commit('setUser', response.data)
        return false
    }
    //失敗した場合
    context.commit('setApiStatus', false)

    if(response.status == UNPROCESSABLE_ENTITY) {
      context.commit('setLoginErrorMessages', response.data.errors)
    } else {
      context.commit('error/setCode', response.status, { root: true })
    }
  },
  //ログアウト
  async logout(context) {
    context.commit('setApiStatus', null)
    const response = await axios.post('/api/logout')

    if(response.status === OK) {
      context.commit('setApiStatus', true)
      context.commit('setUser', null)
      return false
    }

    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true})
  },
  // ページ更新時に一般ユーザがログイン中かチェックする
  async currentUser(context) {
    context.commit('setApiStatus', false)
    const response = await axios.get('/api/user')
    const user = response.data || null

    if(response.status === OK) {
        context.commit('setApiStatus', true)
        context.commit('setUser', user)
        return false
    }

    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  },
  // ページ更新時に店舗オーナーがログイン中かチェックする
  async currentOwner(context) {
    context.commit('setApiStatus', false)
    const response = await axios.get('/api/owners')
    const owner = response.data || null

    if(response.status === OK) {

      context.commit('setApiStatus', true)
      context.commit('setShop', owner)
      return false
    }

    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
