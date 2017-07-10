<template>
    <div>
        <div class="modal fade" id="ResourceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title text-left">
                            <search :url="url"></search>
                        </h3>
                    </div>
                    <div class="modal-body clearfix">
                        <table class="table table-bordered dataTable">
                            <thead>
                            <tr>
                                <order :column="'id'" :url="url" :tTitle="'序号'"></order>
                                <th>素材标题</th>
                                <th>操作时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in resources">
                                <td>{{item.id}}</td>
                                <td>{{item.name}}</td>
                                <td>{{item.updated_at}}</td>
                                <td>
                                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#preview" @click="preview(item.content)">预览</button>
                                    <button class="btn btn-sm btn-info" @click="choose(item.id,item.name)">确认选中</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <page :url="url" :onPageChanges="page"></page>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="closeResourceModal" class="btn btn-default" data-dismiss="modal">关闭</button>
                    </div>
                </div>
            </div>
        </div>
        <preview :content="content"></preview>
    </div>
</template>
<script>
  import Search from './../Common/Search.vue'
  import Order from './../Common/OrderThead.vue'
  import Page from './../Common/Paginator.vue'
  import Preview from './PreviewModal.vue'
  export default{
    created(){

    },
    props:{
      onChoose:{
        type:Function,
        default: data => {

        }
      }
    },
    data(){
      return {
        url  : '/api/resource',
        resources:{},
        id:'',
        content:'',
      }
    },
    components: {
      Search,
      Order,
      Page,
      Preview
    },
    methods: {
      page(data){
        this.resources = data;
      },
      preview(content)
      {
        this.content = content;
      },
      choose(id,name){
        $("#closeResourceModal").trigger({type: "click"});
        var data = {'id':id,'name':name};
        this.onChoose(data);
      }
    },
    mounted(){
    }
  }
</script>