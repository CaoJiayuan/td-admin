<template>
    <div style="display: none;" class="modal inmodal fade" id="debits" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title">账户详情</h4>
                </div>
                <div class="lightBoxGallery">
                    <div class="form-group col-sm-6" style="margin-top: 10px">
                        <label class="col-sm-4 control-label">真实姓名</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" disabled="disabled" :value="debits.goldAccount.name">
                        </div>
                    </div>
                    <div class="form-group col-sm-6" style="margin-top: 10px">
                        <label class="col-sm-4 control-label">金生金账号</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" disabled="disabled" :value="debits.goldAccount.auth.app_identifier">
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="col-sm-4 control-label">交易账号</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" disabled="disabled" :value="debits.goldAccount.gold_num">
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="col-sm-4 control-label">身份证号</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" disabled="disabled" :value="debits.goldAccount.cred_num">
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="col-sm-4 control-label">银行卡号</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" disabled="disabled" :value="debits.goldAccount.bank_num">
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="col-sm-4 control-label">开户行</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" disabled="disabled" :value="debits.goldAccount.bank.comment">
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="col-sm-4 control-label">转入总额</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" disabled="disabled" :value="debits.rollIn" >
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="col-sm-4 control-label">转出总额</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" disabled="disabled" :value="debits.rollOut">
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="col-sm-4 control-label">动态权益</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" disabled="disabled" :value="debits.equity">
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="col-sm-4 control-label">白银建仓手数</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" disabled="disabled" :value="debits.AgHedgeye">
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="col-sm-4 control-label">黄金建仓手数</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" disabled="disabled" :value="debits.AuHedgeye">
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="col-sm-4 control-label">迷你黄金建仓手数</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" disabled="disabled" :value="debits.mAuHedgeye">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">返回</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
  export default{
    created(){

    },
    props:['debits'],
    data(){
      return {
      }
    },
    components: {},
    methods: {
    },
    mounted(){
    },
  }
</script>