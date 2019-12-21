<template>
      <div>
            <label for="login-dayOff" class="form__label"> {{ dayOffLabel }}</label>
            <input
              id="day-off"
              type="text"
              class="form__item form__text"
              placeholder="例）毎週水曜日"
              v-model="value.day_off"
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
            dayOffLabel: ''
        },
        watch: {
            value() {
              console.log(this.value)
                this.$emit('input', this.value);
            }
        }
      }
</script>
