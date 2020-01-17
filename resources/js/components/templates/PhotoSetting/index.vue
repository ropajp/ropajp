<template>
  <div class="photo-form">
      <h2 class="title">写真を登録する</h2>
      <p>ここに登録した写真は検索結果に表示されます。</p>
      <div v-show="loading" class="panel">
        <Loader>送信中...</Loader>
      </div>
      <form v-show="! loading" class="form" enctype="multipart/form-data" @submit.prevent="submit">
      <div class="errors" v-if="errors">
        <ul v-if="errors.photo">
            <li v-for="msg in errors.photo" :key="msg">{{ msg }}</li>
        </ul>
      </div>
        <input class="photo-form__choose-photo" type="file" @change="onFileChange">
        <output v-if="preview">
        <img class="photo-form__item" :src="preview" alt="">
        </output>
        <div class="photo-form__button">
          <button type="submit" class="button button--inverse">登録</button>
        </div>
      </form>
      <!-- 登録済みの写真を表示 -->
      <h4>登録済みの写真</h4>
      <div v-if="selectedIndexes.length<0">
        まだ登録された写真はありません。
      </div>
      <div v-else class="photo-form__image" :class="imageCss(index)" v-for="(image, index) in photoList.photos" :key="image.id">
        <i class="fa fa-check-circle icon" v-if="isSelected(index)"></i>
        <span class="photo-form__cover-label" v-if="image.cover_photo_flg==1">カバー写真</span>
        <img
            class="photo-form__item"
            :src="image['url']"
            alt=""
            ref="image"
            @click="onImageSelect(index)"
          >
      </div>
        <div class="photo-form__tips">
        <h3><i class="fas fa-info-circle"></i> 説明</h3>
        <p>
        1. 登録した写真をクリックし下の緑ボタンからページ編集を行ってください。
        </p>
        <p>
        2. カバー写真に登録された写真は一番最初に表示されます。
        </p>
        <p>
        3. 綺麗に表示させるには、横長の画像がおすすめです。
        </p>
        <p>
        4. 複数の画像を登録しましょう。
        </p>
        <p>
        5. 選択したファイルが表示されない場合、拡張子を変更する必要があります。
        </p>
        </div>
        <div class="photo-form__edit">
          <p><span v-text="selectedIndexes.length"></span> 件選択しています。</p>
          <button @click="clear" class="button button--inverse"><i class="fa fa-times"></i> 選択解除</button>
          <button @click="eliminate" class="button button--inverse"><i class="fa fa-trash-alt"></i> 削除</button>
          <button @click="cover" class="button button--inverse"><i class="fa fa-images"></i>カバー写真</button>
        </div>
      </div>
</template>
<script>

  import { CREATED, UNPROCESSABLE_ENTITY } from '../../../util'
  import Loader from '../../atoms/Loader/index.vue'

  export default {
    components: {
      Loader
    },
    data() {
      return {
        preview: null,
        photo: null,
        errors: null,
        loading: false,
        selectedIndexes: [],
        photoList: [],
      }
    },
    methods: {
    onFileChange (event) {
      if (event.target.files.length === 0) {
        this.reset()
        return false
      }
      if (! event.target.files[0].type.match('image.*')) {
        this.reset()
        return false
      }
      const reader = new FileReader()
      reader.onload = e => {
        this.preview = e.target.result
      }
      reader.readAsDataURL(event.target.files[0])
      this.photo = event.target.files[0]
    },
    reset () {
      this.preview = ''
      this.photo = null
      this.$el.querySelector('input[type="file"]').value = null
    },
    async submit () {
      this.loading = true
      const formData = new FormData()
      formData.append('photo', this.photo)
      const response = await axios.post(`/api/owners/setting/photos/add/${this.shopId}`,  formData)
      this.loading = false
      if (response.status === UNPROCESSABLE_ENTITY) {
        this.errors = response.data.errors
        return false
     }
      this.reset()
      this.$emit('input', false)
      if (response.data.status !== CREATED) {
        this.$store.commit('error/setCode', response.status)
        return false
      }
      this.$store.commit('message/setContent', {
        content: '写真が投稿されました！',
        timeout: 3000
      })
       this.photoList = response.data.shop
    },
    // 画像が選択されているか - 返り値: boolean
    isSelected(index) {
      return(this.selectedIndexes.includes(index))
    },
    onImageSelect(imageIndex) {
      // もし選択されているなら
      if(this.isSelected(imageIndex)) {
        // 選択されていない画像を残す
        this.selectedIndexes = this.selectedIndexes.filter((selectedIndex) => {
          return (selectedIndex !== imageIndex)
        })
      } else {
        this.selectedIndexes.push(imageIndex)
      }
    },
    imageCss(imageIndex) {
      let classes = ['selectable-box']
      if(this.isSelected(imageIndex)) {
        // 選択中ならクラス属性にactiveを追加
        classes.push('active')
      }
      return classes
    },
    clear() {
      this.selectedIndexes = [];
    },
    // 写真削除
    async eliminate() {
      // 選択された写真を数える
      let count = this.selectedIndexes.length
      // もし選択された写真が0以下なら
      if(count <= 0) {
        alert('削除する写真を選択してください。' )
      } else {
        // 最終確認
        let result = confirm(count + '件の写真を削除します')
        // もしconfirmが偽なら
      if(!result) {
        // 選択を解除
        this.clear()
      } else {
        // 写真格納用配列
        let arr = []
        // 選択された写真の数だけ繰り返す
        for(let i = 0; i < this.photoList.photos.length; i++) {
          // もし写真が選択されていたら
          if(this.isSelected(i)) {
            // 配列に追加
            arr.push(this.photoList.photos[i].id)
          }
        }
        // ajax - 店舗ID & 配列
      const response = await axios.delete(`/api/owners/setting/photos/eliminate`, {params: {id: this.shopId, arr}})
      alert('削除が完了しました。')
      // 選択をクリア
      this.clear()
      // レスポンスを格納
      this.photoList = response.data
        }
      }
    },
    async cover() {
      if(this.selectedIndexes.length != 1) {
        alert('カバー写真を設定するには写真を1枚だけ選択してください')
      } else {
        let coverPhoto =''
        // 選択された写真の数だけ繰り返す
        for(let i = 0; i < this.photoList.photos.length; i++) {
          // もし写真が選択されていたら
          if(this.isSelected(i)) {
            // 配列に追加
             coverPhoto = this.photoList.photos[i].id
          }
        }
        const response = await axios.post('/api/owners/setting/photos/cover',  {id: this.shopId, photo: coverPhoto})

        this.clear()
        this.photoList = response.data
      }
    },
    // 写真をフェッチ
    async fetchPhotos() {
        const response = await axios.get(`/api/owners/setting/photos/select/${this.shopId}`)
        this.photoList = response.data
    }
  },
  computed: {
    // ストアから店舗Idを取得
    shopId() {
      return this.$store.getters['auth/shopId']
    }
  },
  // 監視
  watch: {
    $route: {
      // 画面遷移時にfetchShopを実行
      async handler() {
        await this.fetchPhotos()
      },
      immediate: true
    }
  }
}
</script>
