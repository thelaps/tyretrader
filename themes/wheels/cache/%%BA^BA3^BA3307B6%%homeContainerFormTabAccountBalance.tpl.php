<?php /* Smarty version 2.6.26, created on 2015-04-05 20:02:21
         compiled from container/forms/homeTabs/homeContainerFormTabAccountBalance.tpl */ ?>
<div class="tab" data-role="tab">
    <form action="<?php echo $this->_tpl_vars['baseLink']; ?>
/?view=api&load=paymentcenter" class="form form-filter" enctype="multipart/form-data">
        <input type="hidden" name="fnc" value="payBallance">
        <div class="row row-table">
            <div class="area-cell">
                <h4>Платежные реквизиты</h4>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Номер карты</label>
                        </div>
                        <div class="cell">
                            <input type="text" name="payment[card_num]" value="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Срок действия</label>
                        </div>
                        <div class="cell">
                            <select name="payment[card_exp_month]">
                            <?php $_from = $this->_tpl_vars['viewData']->container['expiration']->months; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['month']):
?>
                                <option value="<?php echo $this->_tpl_vars['month']; ?>
"><?php echo $this->_tpl_vars['month']; ?>
</option>
                            <?php endforeach; endif; unset($_from); ?>
                            </select>
                            /
                            <select name="payment[card_exp_year]">
                                <?php $_from = $this->_tpl_vars['viewData']->container['expiration']->years; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['year']):
?>
                                <option value="<?php echo $this->_tpl_vars['year']; ?>
"><?php echo $this->_tpl_vars['year']; ?>
</option>
                                <?php endforeach; endif; unset($_from); ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>CVV<sup>трех значное число с обратной стороны</sup></label>
                        </div>
                        <div class="cell">
                            <input type="password" name="payment[card_cvv]" value="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-table">
            <div class="area-cell area-one-cell">
                <div class="row">
                    <div class="field two-cell align-right">
                        <div class="cell">
                            <label>Моб. телефон<sup>для смс авторизации</sup></label>
                        </div>
                        <div class="cell">
                            <input type="text" name="payment[phone]" value="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field two-cell align-right">
                        <div class="cell">
                            <label>Сумма пополнения</label>
                        </div>
                        <div class="cell">
                            <input type="text" name="payment[amount]" value="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit">Оплатить</button>
    </form>
</div>