<template>
  <div class="loader">
    <p class="loading__text">
      <slot>
        ローディング中...
      </slot>
    </p>
    <div class="loader__item loader__item--heart">
      <div></div>
    </div>
  </div>
</template>
