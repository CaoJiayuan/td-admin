<template>
  <div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
      <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
          <li class="nav-header" style="padding:0px">
            <div class="dropdown profile-element">
                            <span>
                                <img alt="image" width="220px" src="/img/logo.jpg"/>
                             </span>
            </div>
          </li>
          <li v-for="nav in navigation" v-if="nav.granted">
            <template v-if="nav.node.length != 0">
              <a href="#">
                <i :class="nav.icon"></i>
                <span class="nav-label">{{ nav.display_name }}</span>
                <span class="fa arrow"></span>
              </a>
              <ul class="nav nav-second-level">
                <li v-for="nod in nav.node" v-if="nod.granted">
                  <router-link :to="nod.path" v-on:click.native="resetCache(nod.path)">{{ nod.display_name }}</router-link>
                </li>
              </ul>
            </template>
            <template v-if="nav.node.length == 0">
              <template v-if="nav.path != '#'">
                <router-link :to="nav.path" v-on:click.native="resetCache(nav.path)"><i :class="nav.icon"></i><span class="nav-label">{{ nav.display_name }}</span></router-link>
              </template>
            </template>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</template>
<style>

</style>
<script>
  export default{
    created(){
    },
    data(){
      return {
        navigation : []
      }
    },
    components: {},
    methods   : {
      resetCache : function (path) {
        window.Vue.cache = {};
      }
    },
    mounted() {
      axios.get('/api/permission/navigation').then(response => this.navigation = response.data);
    }
  }
</script>