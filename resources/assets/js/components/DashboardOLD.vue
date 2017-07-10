<template>
    <div class="container" style="margin-top: 10px">
        <div class="row">
            <div class="col-md-4">
                <div class="panelccc" style="background-color:#EB4D3C;">
                    <div class="col-md-12 paneltitle">
                        黄金延期    Au(t+d)
                    </div>
                    <div id="glodnum" class="col-md-12 paneldata">
                        {{autd.last}}
                    </div>
                    <div  class="col-md-12 panelpersent">
                        {{autd.up_down}}      {{autd.up_rate}}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panelccc"  style="background-color: #1ABC9C;">

                    <div class="col-md-12 paneltitle">
                        迷你黄金延期    mAu(t+d)
                    </div>
                    <div id="minglodnum" class="col-md-12 paneldata">
                        {{agtd.last}}
                    </div>
                    <div class="col-md-12 panelpersent">
                        {{agtd.up_down}}      {{agtd.up_rate}}
                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="panelccc" style="background-color: #3598DB;">
                    <div class="col-md-12 paneltitle">
                        白银延期    Ag(t+d)
                    </div>
                    <div id="silvernumber" class="col-md-12 paneldata">
                        {{mAutd.last}}
                    </div>
                    <div class="col-md-12 panelpersent">
                        {{mAutd.up_down}}      {{mAutd.up_rate}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="padding-top:35px;text-align: center;">
            <div class="col-md-3 txttitle framenumber1" >当前在线人数</div>
            <div class="col-md-3 txttitle framenumber1">当日注册人数</div>
            <div class="col-md-3 txttitle framenumber1">当日开户人数</div>
            <div class="col-md-3 txttitle framenumber1">当日交易人数</div>
        </div>
        <div class="row" style="text-align: center;" >
            <div class="col-md-3 txtnumber framenumber" >{{currentnum}}</div>
            <div class="col-md-3 txtnumber framenumber" >{{registernum}}</div>
            <div class="col-md-3 txtnumber framenumber">{{opennum}}</div>
            <div class="col-md-3 txtnumber framenumber">{{tradenum}}</div>
        </div>

        <div id="main" style="width: 100%;height:500px;margin-top: 10px">

        </div>
    </div>
</template>
<style >

    .panelccc
    {
        height: 150px;border-radius:10px;box-shadow: 0px 2px 1px;
    }
    .paneltitle
    {
        font-weight:500;height: 50px;text-align: center;font-size:20px;line-height: 50px;color: #ffffff;
    }
    .paneldata
    {
        font-weight: 500;height: 50px;text-align: center;font-size:36px;color: #ffffff;
    }
    .panelpersent
    {
        font-weight: 500;height: 50px;text-align: center;font-size:13px;line-height: 50px;color: #ffffff;
    }

    .framenumber1
    {
        background-color: #fff;
        border: 1px solid #DDDDDD;
        border-bottom: none;
        border-radius: 4px;
        -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
    .framenumber
    {
        background-color: #fff;
        border: 1px solid #DDDDDD;
        border-top:none;
        border-radius: 4px;
        -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
.txttitle
{
    font-size: 24px;font-weight: 300;color: #515151;
}
.txtnumber
{
    font-size: 48px;font-weight: 300;color: #EB4D3C;
}
</style>
<script>
    export default{
        created(){

        },
        data(){
            return {
                autd:{
                    last:'0.00',
                    up_down:'0.00',
                    up_rate:'0.00%'
                },
                agtd:{
                    last:'0.00',
                    up_down:'0.00',
                    up_rate:'0.00%'
                },
                mAutd:{
                    last:'0.00',
                    up_down:'0.00',
                    up_rate:'0.00%'
                },
                currentnum:0,
                registernum:0,
                opennum:0,
                tradenum:0,
                timer:'',
            }
        },
        components: {},
        methods: {

         },
        mounted(){
            var curr=this;
            this.timer=  setInterval(function(){
                axios.get('/api/Statistics/Dashboard').then(function(res){
                    curr.autd=res.data[0];
                    curr.agtd=res.data[1];
                    curr.mAutd=res.data[2];
                }).catch(function(res){

                });

            },3000);

            /*获取数据信息*/
            axios.get('/api/Statistics/StatisticsNum').then(function(res){

                console.log(res);
                if(res.data[0].registernum==null || res.data[0].registernum=='null' || res.data[0].registernum==undefined) {
                    curr.registernum =0;
                }
                else {
                    curr.registernum = res.data[0].registernum;
                }
                if(res.data[0].opennum==null ||res.data[0].opennum=='null' || res.data[0].opennum==undefined) {
                    curr.opennum=0
                }
                else {
                    curr.opennum= res.data[0].opennum;
                }
                if(res.data[0].tradenum==null ||res.data[0].tradenum=='null' || res.data[0].tradenum==undefined) {
                    curr.tradenum=0;
                }
                else {
                    curr.tradenum= res.data[0].tradenum;
                }
                if(res.data[1].currentnum==null ||res.data[1].currentnum=='null' || res.data[1].currentnum==undefined) {
                    curr.currentnum=0;
                }else{
                    curr.currentnum=res.data[1].currentnum;
                }

                var chardata=[];
                chardata.push(res.data[0].audefernum);
                chardata.push(res.data[0].maudefernum);
                chardata.push(res.data[0].agdefernum);
                // 基于准备好的dom，初始化echarts实例
                var myChart = echarts.init(document.getElementById('main'));
                // 指定图表的配置项和数据
                var option = {
                    title: {
                        text: '各合约交易手数'
                    },
                    tooltip: {},
                    legend: {

                    },
                    xAxis: {
                        data: ["黄金延期","迷你黄金延期","白银延期"]
                    },
                    yAxis: {},
                    series: [{
                        name: '交易手数',
                        type: 'bar',
                        data: chardata,
                        itemStyle: {
                            normal: {
                                label: {
                                    show: true,
                                    formatter: '{b}:{c}',
                                    position: 'top',
                                    textStyle: {
                                        color: '#615a5a',
                                        fontWeight:'bold',
                                        fontSize:18
                                    },
                                },
                                color: function(params) {
                                    // build a color map as your need.
                                    var colorList = [
                                        '#EB4D3C','#1ABC9C','#3598DB'
                                    ];
                                    return colorList[params.dataIndex]
                                }
                            }
                        }
                    }]
                };
                // 使用刚指定的配置项和数据显示图表。
                myChart.setOption(option);

            }).catch(function(res){
                console.log(res)
            });
        },
        beforeDestroy: function () {
            clearInterval(this.timer);
        }

    }
</script>