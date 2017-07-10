<template>
  <li class="list-group-item node-treeview1">
    <span style="font-weight: bold;" v-if="hasNode" :class="open ?'icon expand-icon glyphicon glyphicon-minus':'icon expand-icon glyphicon glyphicon-plus'" @click="open = !open"></span>
    <input type="checkbox" class="tree-check" v-model="data.granted" @change="check">
    <span class="tree-title">{{ data.display_name }}</span>
    <ul v-if="hasNode" v-show="open" >
      <tree :data="d" :parent="data" :syncParent="changeParent" v-for="d in data.node"></tree>
    </ul>
  </li>
</template>
<style>

</style>
<script>
  export default{
    name      : 'tree',
    props     : {
      data      : {
        type   : Array,
        default: []
      },
      parent    : {
        type   : Array,
        default: null
      },
      syncParent: {
        type   : Function,
        default: (parent) => {
        }
      }
    },
    created(){

    },
    data(){
      return {
        open : false
      }
    },
    computed  : {
      hasNode: function () {
        return this.data.node && this.data.node.length
      }
    },
    components: {},
    methods   : {
      check(){
        this.changeNode(this.data.node, this.data.granted);
        this.syncParent();
        typeof vueApp == 'undefined' || vueApp.$emit('tree.data.change', this.data);
      },
      changeNode(node, selected) {
        console.log('Event change');
        if (node && node.length > 0) {
          node.forEach(item => {
            item.granted = selected;
            if (item.node && item.node.length > 0) {
              this.changeNode(item.node, selected);
            }
          });
        }
      },
      changeParent(){
        if (this.hasNode) {
          let count = 0;
          this.data.node.forEach(i => {
            i.granted && count++;
          });
          this.data.granted = count > 0;
        }
        return this.syncParent()
      }
    },
    mounted(){
    }
  }
</script>