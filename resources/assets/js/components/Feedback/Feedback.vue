<template>
    <div>
        <div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-8">
                    <h2><strong>意见反馈列表</strong></h2>
                    <ol class="breadcrumb">
                        <li>
                            <router-link to="/">首页</router-link>
                        </li>
                        <li class="active"><strong>意见反馈列表</strong></li>
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
                        </div>
                        <div class="ibox-content">
                            <table class="table table-bordered dataTable">
                                <thead>
                                <tr>
                                    <order :column="'id'" :url="url" :tTitle="'序号'"></order>
                                    <th class="col-lg-2">用户昵称</th>
                                    <th>手机号</th>
                                    <th>邮箱</th>
                                    <th class="col-lg-4">反馈内容</th>
                                    <!--<th class="col-lg-2">反馈图片</th>-->
                                    <order :column="'created_at'" :url="url" :tTitle="'提交时间'"></order>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in feedback">
                                    <td>{{item.id}}</td>
                                    <td v-if="item.user">
                                        <span v-if="item.user.nick_name">{{item.user.nick_name}}</span>
                                        <span v-else>匿名用户</span>
                                    </td>
                                    <td v-else>匿名用户</td>
                                    <td>{{item.mobile}}</td>
                                    <td v-if="item.email">{{item.email}}</td>
                                    <td v-else>未提交</td>
                                    <td>{{item.content}}</td>
                                    <!--<td v-if="item.img">-->
                                        <!--<img src="item.img" width="100px" height="100px" data-toggle="modal" data-target="#myModal" @click="preview(item.img)">-->
                                    <!--</td>-->
                                    <!--<td v-else>未提交</td>-->
                                    <td>{{item.created_at}}</td>
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
        url: '/api/feedback',
        feedback:{},
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
       this.feedback = data;
      },
      preview(img){
        this.pic = img;
      }
    },
    mounted(){
    }
  }
</script>