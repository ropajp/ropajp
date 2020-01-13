<template>
      <div>
            <label for="login-email" class="form__label"> {{ emailLabel }}</label>
            <input
              id="login-email"
              type="email"
              class="form__item form__text"
              placeholder="登録したメールアドレス"
              v-model="value.email"
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
            emailLabel: ''
        },
        watch: {
            value() {
                this.$emit('input', this.value);
            }
        }
      }
</script>
