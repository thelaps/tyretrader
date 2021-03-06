<script>
    {literal}
    $(document).ready(function(){
        var minAmount = {/literal}{$viewData->_contentmodel->getText('MIN_REFILL')}{literal};
        $('input[name="payment[amount]"]').bind({
            change: function(){
                if ($(this).val() < minAmount) {
                    $(this).val(minAmount);
                }
            }
        });
    });
    {/literal}
</script>
<div class="tab" data-role="tab">
    <form action="{$baseLink}/?view=api&load=paymentcenter" class="form form-filter" enctype="multipart/form-data">
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
                            <input type="text" name="payment[amount]" value="{$viewData->_contentmodel->getText('MIN_REFILL')}">
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