<template>
  <div class="col-md-6">
    <div class="row" style="margin-left: 5px;">
      <div class="col-md-12">
        <div class="input-group">
          <input type="text" placeholder="输入关键字" v-model="keyword" class="form-control">
          <span class="input-group-btn">
              <button type="button" class="btn btn-info" @click="doSearch">搜索</button>
              <button class="btn btn-default" @click="reset">重置</button>
          </span>
        </div>
      </div>
    </div>
  </div>
</template>
<style>

</style>
<script>
  import {setQuery} from '../../app/Utils'
  export default{
    props     : {
      url     : {
        type   : String,
        default: ''
      },
      onSearch: {
        type   : Function,
        default: url => {

        }
      },
      addQuery: {
        type   : Function,
        default: () => {
          return {};
        }
      }
    },
    created(){

    },
    data(){
      return {
        keyword: ''
      }
    },
    components: {},
    methods   : {
      doSearch() {
        var keyword = this.keyword.trim();
        if (0 >= keyword.length) {
          vueApp.$emit('page.refresh');
          return;
        }
        var query = this.addQuery();
        var q     = {
          filter: keyword,
          page  : 1
        };
        if (typeof query == 'object') {
          for (let i in query) {
            q[i] = query[i];
          }
        }
        vueApp.$emit('page.query', q);
      },
      reset(){
        vueApp.$emit('page.refresh');
        this.keyword           = '';
        let path               = location.href.split('#', 2)[1];
        window.Vue.cache[path] = {};
      }
    },
    mounted(){
      let path     = this.$route.path, cache = window.Vue.cache[path] || Vue.cacheKeyDefault;
      this.keyword = cache.filter;
    }
  }
</script>