<template>
<div>
   <header class="home">
     <div class="home__photo">
        <h2 class="home__msg">アパレルショップを見つけよう</h2>
        <SearchBar class="home__search"/>
     </div>
   </header>
   <Footer />
     </div>
</template>
<script>
   import Footer from '../../organisms/Footer/index.vue'
   import SearchBar from '../../molecules/SearchBar/index.vue'
    export default {
      components: {
        SearchBar,
        Footer
      },
      data() {
        return {
          // 初期化
          search: []
        }
      }
    }
</script>
