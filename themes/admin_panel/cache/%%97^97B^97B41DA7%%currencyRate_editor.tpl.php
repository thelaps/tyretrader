<?php /* Smarty version 2.6.26, created on 2016-02-21 12:56:57
         compiled from widget/currencyRate_editor.tpl */ ?>
<div class="widget_editor currencyRate_table">
    <button class="close">Закрыть</button>
    <button class="currencyRate_add" data-action="add">Добавить курс</button>
    <button class="currencyRate_delete" data-action="delete">Удалить курс</button>
    <fieldset>
        <legend>Список курса валют v0.13a</legend>
        <div class="scrollLayer">
            <table>
                        </table>
        </div>
    </fieldset>
</div>

<form action="?view=admin_panel&load=api_panel&fnc=add" class="widget_editor add_edit_currencyRate">
    <button class="close">Закрыть</button>
    <fieldset>
        <legend class="currencyRateLegend">Добавить курс валют</legend>
        <input type="hidden" name="fnc" value="currencyRate">
        <input type="text" name="currencyRate[rate]" value="" placeholder="Курс">
        <label>Валюта</label>
        <select name="currencyRate[iso]">
            <option selected disabled="true" value=""> - </option>
        <?php $_from = $this->_tpl_vars['viewData']['currencyRate']['iso']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['currencyRate']):
?>
            <option value="<?php echo $this->_tpl_vars['currencyRate']; ?>
"><?php echo $this->_tpl_vars['currencyRate']; ?>
</option>
        <?php endforeach; endif; unset($_from); ?>
        </select>
        <button class="save">Сохранить</button>
    </fieldset>
</form>