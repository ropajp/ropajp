<!-- パスワード -->
<template>
      <div>
            <label for="login-password" class="form__label">{{ passwordLabel }}</label>
              <input
                type="password"
                class="form__item form__text"
                id="login-password"
                placeholder="8文字以上"
                v-model="value.password"
                >
        </div>
</template>
<script>
  export default {
        props: {
            value: {
                type: Object,
                required: true
            },
            passwordLabel: ''
        },
        watch: {
            value() {
                this.$emit('input', this.value);
            }
        }
    }
</script>
