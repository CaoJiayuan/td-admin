<template>
  <th @click="order" :class="tClass">{{tTitle}}</th>
</template>
<style>

</style>
<script>
  export default{
    props     : {
      tTitle: {
        type   : String,
        default: ''
      },
      column: {
        type   : String,
        default: ''
      },
      url   : {
        type   : String,
        default: ''
      },
    },
    created(){

    },
    data(){
      return {
        asc   : false,
        tClass: 'sorting'
      }
    },
    components: {},
    methods   : {
      order(){
        this.tClass = this.asc ? 'sorting_asc' : 'sorting_desc';
        let sort    = this.asc ? this.column + '|' + 'asc' : this.column + '|' + 'desc';
        vueApp.$emit('page.sort', sort);
        this.asc = !this.asc;
      }
    },
    mounted(){

    }
  }
</script>