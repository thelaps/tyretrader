<?php /* Smarty version 2.6.26, created on 2015-04-13 16:45:06
         compiled from container/forms/homeTabs/homeContainerFormTabAccountBalance.tpl */ ?>
<div class="tab" data-role="tab">
    <form action="<?php echo $this->_tpl_vars['baseLink']; ?>
/?view=api&load=paymentcenter" class="form form-filter" enctype="multipart/form-data">
        <input type="hidden" name="fnc" value="getFormBalance">
        <div class="row row-table">
            <div class="area-cell">
                <h4>Пополнение балланса системы</h4>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Сумма пополнения</label>
                        </div>
                        <div class="cell">
                            <input type="text" name="payment[amount]" value="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-left one-cell">
                        <div class="cell">
                            <button type="submit">Пополнить</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="area-cell">
                <h4>Платежная система</h4>
                <div class="row">
                    <div class="field align-right one-cell">
                        <div class="cell">
                           <a target="_blank" href="https://www.liqpay.com"><img src="https://www.liqpay.com/static/img/logo_doc.png"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>