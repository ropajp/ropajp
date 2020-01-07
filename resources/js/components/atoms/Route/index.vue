<template>
  <div>
    <RouterLink
          class="route"
          :to="to">
    {{ btnName }}
    </RouterLink>
  </div>
</template>
<script>
  export default {
    props: {
      btnName: '',
      to: {
        type: String,
        required: true
      }
    }
  }
</script>
