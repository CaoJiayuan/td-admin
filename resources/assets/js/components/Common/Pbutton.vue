<template>
  <button :class="bClass" type="button" v-if="granted" @click="click"><i :class="bIcon" v-if="bIcon.length"></i> {{
    bTitle }}
  </button>
</template>
<style>

</style>
<script>

  export default{
    props        : {
      bClass : {
        type   : String,
        default: 'btn btn-info'
      },
      bAction: {
        type   : String,
        default: ''
      },
      bIcon  : {
        type   : String,
        default: ''
      },
      click  : {
        type   : Function,
        default: (e) => {
        }
      }
    },
    created(){

    },
    data(){
      return {
        granted: false,
        timer  : null,
        bTitle : ''
      }
    },
    components   : {},
    methods      : {},
    mounted(){
      let self   = this;
      this.timer = setTimeout(() => {
        let p = permission.find(self.bAction);
        if (p.granted) {
          self.bTitle = p.display_name;
        }
      }, 200)
    },
    beforeDestroy: function () {
      clearTimeout(this.timer);
    }
  }
</script>