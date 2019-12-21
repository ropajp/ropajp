<template>
      <div>
            <label for="password-confirmation" class="form__label"> {{ passwordConfirmationLabel }}</label>
            <input
              type="password"
              id="password-confirmation"
              class="form__item form__text"
              placeholder="確認用パスワード"
              v-model="value.password_confirmation"
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
            passwordConfirmationLabel: ''
        },
        watch: {
            value() {
                this.$emit('input', this.value);
            }
        }
      }
</script>
