<template>
    <div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-8">
                <h2><strong>广告位列表</strong></h2>
                <ol class="breadcrumb">
                    <li><router-link to="/">首页</router-link></li>
                    <li class="active"><strong>广告位列表</strong></li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>序号</th>
                                    <th>广告位名称</th>
                                    <th>图片尺寸</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in positions">
                                    <td>{{item.code}}</td>
                                    <td>{{item.name}}</td>
                                    <td>{{item.size}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        data(){
          return {
            positions: {}
          }
        },
        methods:{
            getPosition(){
                axios.get('/api/adsPosition').then(response => {
                    this.positions = response.data;
                }).catch(error=>{
                    toastrNotification('error',error.message);
                });
            },
        },
        mounted(){
            this.getPosition();
        }
    }
</script>