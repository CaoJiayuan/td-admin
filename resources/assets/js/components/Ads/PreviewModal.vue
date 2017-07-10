<template>
    <div class="modal fade" id="preview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="z-index: 99999!important;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body clearfix">
                    <div v-html="content"></div>
                </div>
                <div class="modal-footer">
                    <button type="button"  class="btn btn-default" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
  export default{
    created(){

    },
    props:['content'],
    data(){
      return {
      }
    },
    components: {
    },
    methods: {
    },
    mounted(){
    }
  }
</script>