<?php /* Smarty version 2.6.26, created on 2016-01-31 17:49:24
         compiled from widget/company_editor.tpl */ ?>
<div class="widget_editor company_table">
    <button class="close">Закрыть</button>
    <button class="company_add" data-action="add">Добавить поставщика</button>
    <button class="company_delete" data-action="delete">Удалить поставщика</button>
    <fieldset>
        <legend>Список поставщиков v0.15a</legend>
        <div class="suggest">
            <i class="clearSuggest"></i>
            <input type="text" class="citySuggest" placeholder="Фильтр по городам">
            <div class="suggestList">
                <ul>
                    <li><a>test a</a></li>
                    <li><a>test a</a></li>
                    <li><a>test a</a></li>
                    <li><a>test a</a></li>
                    <li><a>test a</a></li>
                    <li><a>test a</a></li>
                </ul>
            </div>
        </div>
        <div class="scrollLayer">
            <table id="cityFilter">
            <?php $_from = $this->_tpl_vars['viewData']['raw_companies']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['company']):
?>
                <tr data-id="<?php echo $this->_tpl_vars['company']->id; ?>
" data-name="<?php echo $this->_tpl_vars['company']->name; ?>
" data-city="<?php echo $this->_tpl_vars['company']->cityId; ?>
">
                    <td><input type="checkbox" value="<?php echo $this->_tpl_vars['company']->id; ?>
"></td>
                    <td><?php echo $this->_tpl_vars['company']->id; ?>
</td>
                    <td><?php echo $this->_tpl_vars['company']->name; ?>
</td>
                    <td><?php echo $this->_tpl_vars['company']->city; ?>
</td>
                </tr>
            <?php endforeach; endif; unset($_from); ?>
            </table>
        </div>
    </fieldset>
</div>
<script>
    var haystack = <?php echo '{'; ?>

    <?php $this->assign('counter', 0); ?>
    <?php $_from = $this->_tpl_vars['viewData']['city']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['region']):
?>
        <?php $_from = $this->_tpl_vars['region']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['city']):
?>
                <?php if ($this->_tpl_vars['counter'] != 0): ?>, <?php endif; ?><?php echo $this->_tpl_vars['city']->id; ?>
<?php echo ':'; ?>
"<?php echo $this->_tpl_vars['city']->name; ?>
"
            <?php $this->assign('counter', $this->_tpl_vars['counter']+1); ?>
        <?php endforeach; endif; unset($_from); ?>
    <?php endforeach; endif; unset($_from); ?>
    <?php echo '}'; ?>
;

    <?php echo '
    $(function(){
        $(\'.citySuggest\').suggest(haystack,{
            onmatch:function(e){
                $(\'#cityFilter\').find(\'tr:not([data-city="\'+ e.id+\'"])\').hide();
            },onmismatch:function(){
                $(\'#cityFilter\').find(\'tr\').show();
            }
        });
    });
    '; ?>

</script>


<form action="?view=admin_panel&load=api_panel&fnc=add" class="widget_editor add_edit_company">
    <button class="close">Закрыть</button>
    <fieldset>
        <legend class="companyLegend">Добавить поставщика</legend>
        <input type="hidden" name="fnc" value="company">
        <input type="hidden" name="company[id]" value="">
        <fieldset>
            <legend>Поставщик <text class="hideIfEdit">(логин - почта, пароль - "123123")</text></legend>
            <label>Сумма на счету</label>
            <input type="text" name="user[balance]" value="0.00">
            <label>Продлить на</label>
            <select name="company[expire]">
                <option value="0" selected>не продлевать</option>
                <option value="1">1 мес.</option>
                <option value="2">2 мес.</option>
                <option value="3">3 мес.</option>
            </select>
            <label>Email</label>
            <input type="text" name="user[email]">
            <label>Имя</label>
            <input type="text" name="user[firstName]">
            <label>Фамилия</label>
            <input type="text" name="user[lastName]">
            <label>Телефон</label>
            <input type="text" name="user[phone]">
            <label>Юр. Название компании</label>
            <input type="text" name="company[name]" value="">
        </fieldset>
                    <fieldset>
                        <legend>Регион</legend>
                        <select name="company[city_id]">
                        <?php $_from = $this->_tpl_vars['viewData']['city']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['region']):
?>
                            <optgroup label="<?php echo $this->_tpl_vars['key']; ?>
">
                                <?php $_from = $this->_tpl_vars['region']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['city']):
?>
                                    <option value="<?php echo $this->_tpl_vars['city']->id; ?>
"><?php echo $this->_tpl_vars['city']->name; ?>
</option>
                                <?php endforeach; endif; unset($_from); ?>
                            </optgroup>
                        <?php endforeach; endif; unset($_from); ?>
                        </select>
                    </fieldset>
                    <fieldset>
                        <legend>Индивидуальный курс</legend>
                        <label>Валюта</label>
                        <select name="company[iso]">
                            <option selected disabled="true" value=""> - </option>
                            <?php $_from = $this->_tpl_vars['viewData']['currencyRate']['iso']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['currencyRate']):
?>
                            <option value="<?php echo $this->_tpl_vars['currencyRate']; ?>
"><?php echo $this->_tpl_vars['currencyRate']; ?>
</option>
                            <?php endforeach; endif; unset($_from); ?>
                        </select>
                        <label>Значение курса</label>
                        <input type="text" name="company[rate]" placeholder="Пример: '1.0000'">
                    </fieldset>
        <button class="save">Сохранить</button>
    </fieldset>
</form>