<template>
   <header class="home">
     <div class="home__photo">
        <SearchBar class="home__search"/>
     </div>
   </header>
</template>
<script>
   import SearchBar from '../../molecules/SearchBar/index.vue'
    export default {
      components: {
        SearchBar
      },
      data() {
        return {
          // 初期化
          search: []
        }
      }
    }
</script>
