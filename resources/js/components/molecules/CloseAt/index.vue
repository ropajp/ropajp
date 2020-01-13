<template>
  <div>
    <label class="form__label" for="open_at">{{ closeAtLabel }}</label>
    <div class="form__time-wrapper">
        <select v-model="hours" @change="onChange" class="form__time">
            <option></option>
                <option v-for="(text,value) in options(24)" :value="value" v-text="text"></option>
        </select>
    <span>：</span>
        <select v-model="minutes" @change="onChange" class="form__time">
            <option></option>
                <option v-for="(text,value) in options(60)" :value="value" v-text="text"></option>
        </select>
     </div>
  </div>
</template>
<script>
  export default {
    props: {
        value: {
            type: Object,
            required: true
        },
        closeAtLabel: ''
    },
    data() {
      return {
        hours: '',
        minutes: ''
      }
    },
    methods: {
        onChange() {
            this.value.close_at = this.hours.toString().padStart(2, '0') + ':' + this.minutes.toString().padStart(2, '0')
        },
        options(limitValue) {
          let options = {};

            for(let i = 0 ; i < limitValue ; i++) {
                options[i] = i.toString().padStart(2, '0');
            }
            return options;
        }
    },
    watch: {
        value() {
            this.$emit('input', this.value)
        }
    }
  }
</script>
