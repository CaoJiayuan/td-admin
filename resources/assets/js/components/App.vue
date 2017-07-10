<template>
    <div>
        <navigation></navigation>
        <div class="gray-bg" id="page-wrapper" style="min-height: 760px;">
            <top-bar></top-bar>
            <router-view></router-view>
        </div>
    </div>
</template>
<style>

</style>
<script>
  import Navigation from './Layouts/Navigation.vue'
  import TopBar from './Layouts/TopBar.vue'
  export default{
    created(){
    },
    data(){
      return {}
    },
    components: {
      Navigation,
      TopBar
    },
    methods: {},
    mounted(){
//      $.material.init();
    }
  }
</script>