<template>
    <div>
        <div class="modal fade" id="NewsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                                <th>独家专栏标题</th>
                                <th>操作时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in news">
                                <td>{{item.id}}</td>
                                <td>{{item.title}}</td>
                                <td>{{item.updated_at}}</td>
                                <td>
                                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#preview" @click="preview(item.content)">预览</button>
                                    <button class="btn btn-sm btn-info" @click="choose(item.id,item.title)">确认选中</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <page :url="url" :onPageChanges="page"></page>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="closeNewsModal" class="btn btn-default" data-dismiss="modal">关闭</button>
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
        url  : '/api/news/scoops',
        news:{},
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
        this.news = data;
      },
      preview(content)
      {
        this.content = content;
      },
      choose(id,title){
        $("#closeNewsModal").trigger({type: "click"});
        var data = {'id':id,'title':title};
        this.onChoose(data);
      }
    },
    mounted(){
    }
  }
</script>