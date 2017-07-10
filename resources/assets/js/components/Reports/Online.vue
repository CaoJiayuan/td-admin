<template>
    <div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-8">
                <h2>在线人数统计</h2>
                <ol class="breadcrumb">
                    <li>
                        <router-link to="/">首页</router-link>
                    </li>
                    <li class="active"><strong>在线人数统计</strong></li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12 well" style="background-color: rgb(255, 255, 255);">
                    <div class="ibox float-e-margins">
                        <div class="row">
                            <div class="col-md-12" style="padding-bottom:15px">
                                <div class="row" style="margin-left: 5px;">
                                    <div class="col-md-12">
                                        <div  class="col-md-3">
                                            <div class="block" style="width: 100%">
                                                <el-date-picker
                                                        v-model="value6"
                                                        format="yyyy/MM/dd"
                                                        type="daterange"
                                                        placeholder="选择日期范围">
                                                </el-date-picker>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <button @click="query()" class="btn btn-info" type="button">
                                                <i class="fa fa-search"></i>&nbsp;&nbsp;查&nbsp;&nbsp;询
                                            </button>
                                            <button  @click="exports()" class="btn btn-info" type="button" style="margin-left: 10px">
                                                <i class="glyphicon glyphicon-download-alt"></i>&nbsp;&nbsp;导&nbsp;&nbsp;出
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div id="main" style="width: 100%;height:500px;margin-top: 10px">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
</style>
<script>

    export default{
        created(){},
        data(){
            return {
                datas:[],
                value6:"",
                url:"/api/Statistics/OnlineStatChart",
                dbegin:'',
                dend:'',
            }
        },
        components: {},
        methods: {
            query(){
                var timearr=$('.el-input__inner').val().split(' - ');
                var begin=timearr[0];
                var end=timearr[1];
                this.dbegin=begin;
                this.dend=end;
                if(timearr!='') {

                    axios.get('/api/Statistics/OnlineStatChart?begin='+begin+'&end='+end).then(function(res){
                        var xdata=[];
                        var ydata=[];
                        if(res.data.length>0)
                        {
                            for(var i=0;i<res.data.length;i++)
                            {
                                xdata.push(res.data[i].date);
                                ydata.push(res.data[i].num);
                            }
                        }
                        console.log(xdata);
                        console.log(ydata);
                        // 基于准备好的dom，初始化echarts实例
                        var myChart = echarts.init(document.getElementById('main'));
                        var option = {
                            title: {
                                text: '在线人数统计趋势图',
                                subtext: '趋势图'
                            },
                            tooltip: {
                                trigger: 'axis',
                                axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                                    type : 'shadow'        // 默认为直线，可选为：‘line‘ | ‘shadow‘
                                }
                            },
                            legend: {
                                data:['最高在线','最低在线']
                            },
                            toolbox: {
                                show: true,
                                feature: {
                                    //  dataZoom: {
                                    //      yAxisIndex: 'none'
                                    // },
                                    dataView: {readOnly: false},
                                    magicType: {type: ['line', 'bar']},
                                    //restore: {},
                                    saveAsImage: {}
                                }
                            },
                            xAxis:  {
                                type: 'category',
                                boundaryGap: false,
                                axisLabel:{
                                    interval:0,
                                    rotate:-60,
                                    margin:2,
                                    textStyle:{
                                        color:"#222"
                                    }
                                },
                                //data: ['2017-04-10','2017-04-09','2017-04-08','2017-04-07','2017-04-06','2017-04-05','2017-04-04','2017-04-03','2017-04-02','2017-04-01']
                                data:xdata
                            },
                            yAxis: {
                                type: 'value',
                                axisLabel: {
                                    formatter: '{value}'
                                }
                            },
                            series: [
                                {
                                    name:'在线人数',
                                    type:'line',
                                    //data:[5, 6,6, 7, 5, 6, 7,7.2,6.5,5.2],
                                    data:ydata,
                                    markPoint: {
                                        data: [
                                            {type: 'max', name: '最大值'},
                                            {type: 'min', name: '最小值'}
                                        ]
                                    },
                                    markLine: {
                                        data: [
                                            {type: 'average', name: '平均值'}
                                        ]
                                    }
                                }
                            ]
                        };
                        // 使用刚指定的配置项和数据显示图表。
                        myChart.setOption(option);

                    }).catch(function(res){
                        console.log(res)
                    });


                }
                else {
                    toastrNotification('error', '请选择正确的日期');
                }
            },
            exports()
            {
                location.href='/OnlineExcel?begin='+this.dbegin.toString().replace('///g','-')+'&end='+this.dend.toString().replace('///g','-');
            }
        },
        mounted(){
            axios.get('/api/Statistics/OnlineStatChart').then(function(res){
                var xdata=[];
                var ydata=[];
                if(res.data.length>0)
                {
                    for(var i=0;i<res.data.length;i++)
                    {
                        xdata.push(res.data[i].date);
                        ydata.push(res.data[i].num);
                    }
                }
                console.log(xdata);
                console.log(ydata);
                // 基于准备好的dom，初始化echarts实例
                var myChart = echarts.init(document.getElementById('main'));
                var option = {
                    title: {
                        text: '在线人数统计趋势图',
                        subtext: '趋势图'
                    },
                    tooltip: {
                        trigger: 'axis',
                        axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                            type : 'shadow'        // 默认为直线，可选为：‘line‘ | ‘shadow‘
                        }
                    },
                    legend: {
                        data:['最高在线','最低在线']
                    },
                    toolbox: {
                        show: true,
                        feature: {
                            //  dataZoom: {
                            //      yAxisIndex: 'none'
                            // },
                            dataView: {readOnly: false},
                            magicType: {type: ['line', 'bar']},
                            //restore: {},
                            saveAsImage: {}
                        }
                    },
                    xAxis:  {
                        type: 'category',
                        boundaryGap: false,
                        axisLabel:{
                            interval:0,
                            rotate:-60,
                            margin:2,
                            textStyle:{
                                color:"#222"
                            }
                        },
                        //data: ['2017-04-10','2017-04-09','2017-04-08','2017-04-07','2017-04-06','2017-04-05','2017-04-04','2017-04-03','2017-04-02','2017-04-01']
                        data:xdata
                    },
                    yAxis: {
                        type: 'value',
                        axisLabel: {
                            formatter: '{value}'
                        }
                    },
                    series: [
                        {
                            name:'在线人数',
                            type:'line',
                            //data:[5, 6,6, 7, 5, 6, 7,7.2,6.5,5.2],
                            data:ydata,
                            markPoint: {
                                data: [
                                    {type: 'max', name: '最大值'},
                                    {type: 'min', name: '最小值'}
                                ]
                            },
                            markLine: {
                                data: [
                                    {type: 'average', name: '平均值'}
                                ]
                            }
                        }
                    ]
                };
                // 使用刚指定的配置项和数据显示图表。
                myChart.setOption(option);

            }).catch(function(res){
                console.log(res)
            });

            var nowDate = new Date();
            var year = nowDate.getFullYear();
            var month = nowDate.getMonth() + 1 < 10 ? "0" + (nowDate.getMonth() + 1)
                    : nowDate.getMonth() + 1;
            var day = nowDate.getDate() < 10 ? "0" + nowDate.getDate() : nowDate
                    .getDate();
            var dateStr = year + "/" + month + "/" + day;


            $(".el-input__inner").val(dateStr+' - '+dateStr);


        }
    }
</script>