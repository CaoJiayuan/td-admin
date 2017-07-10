<template>
    <div>
        <div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-8">
                    <h2><strong>广告列表</strong></h2>
                    <ol class="breadcrumb">
                        <li>
                            <router-link to="/">首页</router-link>
                        </li>
                        <li class="active"><strong>广告列表</strong></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title" style="height:65px;">
                            <search :url="url"></search>

                            <router-link to="/ads/add" v-if="permission.can('ads.ads.add')">
                                <button class="btn btn-info">新增广告</button>
                            </router-link>

                        </div>
                        <div class="ibox-content">
                            <table class="table table-bordered dataTable">
                                <thead>
                                <tr>
                                    <order :column="'id'" :url="url" :tTitle="'序号'"></order>
                                    <th class="col-lg-2">广告标题</th>
                                    <th>操作时间</th>
                                    <th>图片</th>
                                    <th class="col-lg-2">广告内容</th>
                                    <th>类型</th>
                                    <th class="col-lg-1">广告位</th>
                                    <th class="col-lg-1">状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in ads">
                                    <td>{{item.id}}</td>
                                    <td>{{item.title}}</td>
                                    <td>{{item.updated_at}}</td>
                                    <td>
                                        <img :src="item.img" width="100px" height="100px" data-toggle="modal" data-target="#myModal" @click="preview(item.img)">
                                    </td>
                                    <td v-if="item.resource_name">{{item.resource_name}}</td>
                                    <td v-else>{{item.url}}</td>
                                    <td v-for="items in type" v-if="item.type==items.code">{{items.name}}</td>
                                    <td v-for="items in positions" v-if="item.ad_position_id==items.code">
                                        {{items.name}}
                                    </td>
                                    <td v-if="item.status==0">已禁用</td>
                                    <td v-if="item.status==1">已启用</td>
                                    <td>
                                        <router-link :to="{ name: 'ads/edit', params: { id: item.id }}" v-if="permission.can('ads.ads.edit')">
                                            <button class="btn btn-sm btn-info">编辑</button>
                                        </router-link>
                                        <button v-if="item.status==0 && permission.can('ads.ads.delete')" class="btn btn-sm btn-info" @click="modifyStatus(item.id)">启用</button>
                                        <button v-if="item.status==1 && permission.can('ads.ads.delete')" class="btn btn-sm btn-danger" @click="modifyStatus(item.id)">禁用</button>
                                        <button class="btn btn-sm btn-danger" @click="deleteAds(item.id)" v-if="permission.can('ads.ads.delete')">删除
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <page :url="url" :onPageChanges="page"></page>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myModal" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title text-center">查看图片</h3>
                    </div>
                    <div class="modal-body" id="pic">
                        <img :src="pic">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    </div>
                </div>`
            </div>
        </div>

    </div>
</template>
<script>
  import Search from './../Common/Search.vue'
  import Order from './../Common/OrderThead.vue'
  import Page from './../Common/Paginator.vue'
  export default{
    created(){

    },
    data(){
      return {
        url: '/api/at',
        ads: {},
        positions:{},
        type:{},
        pic:''
      }
    },
    components: {
      Search,
      Order,
      Page
    },
    methods: {
      page(data){
        this.ads = data;
        this.positions = data.positions;
        this.type = data.type;
        Vue.delete(this.ads,'positions');
        Vue.delete(this.ads,'type');
      },
      edit(id){

      },
      modifyStatus(id){
        axios.get('/api/at/modifyStatus/' + id).then(response =>{
          toastrNotification('success', '修改状态成功');
          vueApp.$emit('page.refresh', this.url);
        }).catch(error =>{
          toastrNotification('error', error);
        });
      },
      deleteAds(id){
        var opts = {
          title: '确认删除?',
          text: '你将无法恢复数据!',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: '是,确定删除!',
          cancelButtonText: '不,取消删除',
          closeOnConfirm: false,
          closeOnCancel: false
        };

        sweetAlert(opts,
          function (isConfirm) {
            if (isConfirm) {
              axios.get('/api/at/delete/' + id).then(response => {
                sweetAlert("已经删除", "数据已经删除!", "success");
                vueApp.$emit('page.refresh', this.url);
            }).catch(error =>{
                toastrNotification('error', error.message);
            });
            } else {
              sweetAlert("取消", "数据没有删除!", "error");
            }
          });
      },
      preview(img){
        this.pic = img;
      }
    },
    mounted(){
    }
  }
</script>