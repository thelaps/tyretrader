<?php /* Smarty version 2.6.26, created on 2016-02-21 12:56:57
         compiled from widget/manufacturer_editor.tpl */ ?>
<div class="widget_editor debug_editor">
    <button class="close">Закрыть</button>
    <fieldset>
        <legend>Ручная обработка v0.27a</legend>
        <fieldset>
            <legend id="workAreaTitle">Выделите часть строки названия</legend>
            <input readonly="true" type="text" name="unaccepted" style="width: 100%; font-size: 16px;" />
            <input type="text" name="unaccepted[hash]" value="">
        </fieldset>
        <form class="manufacturer area" action="?view=admin_panel&load=api_panel&fnc=add">
            <input type="hidden" name="fnc" value="manufacturer">
            <fieldset>
                <legend>Добавить синоним/производителя</legend>
                <div class="gridpanel">
                    <script>
                        <?php echo '
                        $(document).ready(function(){
                            $(\'.manufacturerTypeChanger\').bind({
                                change: function(){
                                    var checked = $(this).val();
                                    switch (checked){
                                        case \'newManufacturer\':
                                            var sManufacturer = $(this).closest(\'.row\').find(\'[name="synonym[synonym]"]\').val();
                                            $(this).closest(\'.row\').find(\'[name="manufacturer[name]"]\').removeAttr(\'readonly\').changeVal(sManufacturer);
                                            $(this).closest(\'.row\').find(\'[name="synonym[synonym]"]\')
                                                    .attr(\'readonly\',true).val(\'\');
                                            break;
                                        case \'synonymManufacturer\':
                                            var sManufacturer = $(this).closest(\'.row\').find(\'[name="manufacturer[name]"]\').val();
                                            $(this).closest(\'.row\').find(\'[name="manufacturer[name]"]\')
                                                    .attr(\'readonly\',true).changeVal();
                                            $(this).closest(\'.row\').find(\'[name="synonym[synonym]"]\').removeAttr(\'readonly\').changeVal(sManufacturer);
                                            break;
                                        case \'bothManufacturer\':
                                            var sManufacturer1 = $(this).closest(\'.gridpanel\').find(\'[name="synonym[synonym]"]\').val();
                                            var sManufacturer2 = $(this).closest(\'.gridpanel\').find(\'[name="manufacturer[name]"]\').val();
                                            $(this).closest(\'.gridpanel\').find(\'[name="manufacturer[name]"]\').removeAttr(\'readonly\').changeVal((sManufacturer1!=\'\')?sManufacturer1:sManufacturer2);
                                            $(this).closest(\'.gridpanel\').find(\'[name="synonym[synonym]"]\').removeAttr(\'readonly\').changeVal((sManufacturer1!=\'\')?sManufacturer1:sManufacturer2);
                                            break;
                                    }
                                }
                            });
                        });
                        '; ?>

                    </script>
                    <div class="row">
                        <div class="panel">
                            <label><input type="radio" value="bothManufacturer" name="manufacturerTypeChanger" class="manufacturerTypeChanger">Новый производитель и синоним</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="panel">
                            <label><input type="radio" value="newManufacturer" name="manufacturerTypeChanger" class="manufacturerTypeChanger">Новый производитель</label>
                            <label>Новый производитель</label>
                            <input type="text" name="manufacturer[name]" placeholder="Производитель" readonly />
                            <label>Тип</label>
                            <select name="manufacturer[type]">
                                <option value="1">Шины</option>
                                <option value="2">Диски</option>
                            </select>
                        </div>
                        <div class="panel">
                            <label><input type="radio" value="synonymManufacturer" name="manufacturerTypeChanger" class="manufacturerTypeChanger" checked="true">Синоним производителя</label>
                            <label>Синоним производителя</label>
                            <input type="text" name="synonym[synonym]" class="selectionNeed" placeholder="Синоним" />
                            <label>Производитель</label>
                            <select name="synonym[manufacturer_id]">
                                <option value="" selected> - </option>
                            <?php $_from = $this->_tpl_vars['viewData']['raw_manufacturers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cnt']):
?>
                                <option value="<?php echo $this->_tpl_vars['cnt']->manufacturer_id; ?>
"><?php echo $this->_tpl_vars['cnt']->name; ?>
</option>
                            <?php endforeach; endif; unset($_from); ?>
                            </select>
                        </div>
                    </div>
                </div>
                <button class="add_manufacturerPart">Добавить</button>
            </fieldset>
        </form>
        <form class="model area" action="?view=admin_panel&load=api_panel&fnc=add">
            <input type="hidden" name="fnc" value="model">
            <fieldset>
                <legend>Добавить синоним/модель</legend>
                <div class="gridpanel">
                    <script>
                        <?php echo '
                        $(document).ready(function(){
                            $(\'.modelTypeChanger\').bind({
                                change: function(){
                                    var checked = $(this).val();
                                    switch (checked){
                                        case \'newModel\':
                                            var sModel = $(this).closest(\'.row\').find(\'[name="synonym[synonym]"]\').val();
                                            $(this).closest(\'.row\').find(\'[name="model[name]"]\').removeAttr(\'readonly\').changeVal(sModel);
                                            $(this).closest(\'.row\').find(\'[name="synonym[synonym]"]\')
                                                    .attr(\'readonly\',true).val(\'\');
                                            break;
                                        case \'synonymModel\':
                                            var sModel = $(this).closest(\'.row\').find(\'[name="model[name]"]\').val();
                                            $(this).closest(\'.row\').find(\'[name="model[name]"]\')
                                                    .attr(\'readonly\',true).changeVal();
                                            $(this).closest(\'.row\').find(\'[name="synonym[synonym]"]\').removeAttr(\'readonly\').changeVal(sModel);
                                            break;
                                        case \'bothModel\':
                                            var sModel1 = $(this).closest(\'.gridpanel\').find(\'[name="synonym[synonym]"]\').val();
                                            var sModel2 = $(this).closest(\'.gridpanel\').find(\'[name="model[name]"]\').val();
                                            $(this).closest(\'.gridpanel\').find(\'[name="model[name]"]\').removeAttr(\'readonly\').changeVal((sModel1!=\'\')?sModel1:sModel2);
                                            $(this).closest(\'.gridpanel\').find(\'[name="synonym[synonym]"]\').removeAttr(\'readonly\').changeVal((sModel1!=\'\')?sModel1:sModel2);
                                            break;
                                    }
                                }
                            });
                            $.fn.changeVal = function(needle){
                                var _this = $(this);
                                var val = _this.val();
                                if(val.length==0){
                                    _this.val(needle);
                                }
                                if(needle==undefined){
                                    _this.val(\'\');
                                }
                            }
                        });
                        '; ?>

                    </script>
                    <div class="row">
                        <div class="panel">
                            <label><input type="radio" value="bothModel" name="modelTypeChanger" class="modelTypeChanger">Новая модель и синоним</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="panel">
                            <label><input type="radio" value="newModel" name="modelTypeChanger" class="modelTypeChanger">Новая модель</label>
                            <input type="text" name="model[name]" placeholder="Модель" readonly />
                            <label>Производитель</label>
                            <select name="model[manufacturer_id]">
                                <option value="" selected> - </option>
                            <?php $_from = $this->_tpl_vars['viewData']['raw_manufacturers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cnt']):
?>
                                <option value="<?php echo $this->_tpl_vars['cnt']->manufacturer_id; ?>
"><?php echo $this->_tpl_vars['cnt']->name; ?>
</option>
                            <?php endforeach; endif; unset($_from); ?>
                            </select>
                        </div>
                        <div class="panel">
                            <label><input type="radio" value="synonymModel" name="modelTypeChanger" class="modelTypeChanger" checked="true">Синоним модели</label>
                            <input type="text" name="synonym[synonym]" class="selectionNeed" placeholder="Синоним" />
                            <label>По модели из списка существующих</label>
                            <select name="model[id]"></select>
                        </div>
                    </div>
                </div>
                <button class="add_modelPart">Добавить</button>
            </fieldset>
        </form>
        <button class="save">Сохранить</button>
    </fieldset>
</div>


<div class="widget_editor synonym_table">
    <button class="close">Закрыть</button>
    <button class="synonym_add" data-action="add">Добавить синоним</button>
    <button class="synonym_delete" data-action="delete">Удалить синоним</button>
    <fieldset>
        <legend>Список синонимов v0.21a</legend>
        <div class="gridpanel">
            <div class="row">
                <div class="panel">
                    Синоним параметра: <select name="synonym[parameter]"></select>
                </div>
                <div class="panel" style="display: none;">
                    по производителю: <select name="synonym[manufacturer_id]" disabled></select>
                </div>
            </div>
        </div>
        <div class="scrollLayer">
            <table>
                <tr>
                    <td>Оригинал</td>
                    <td>Синоним</td>
                    <td>Тип</td>
                </tr>
            </table>
        </div>
    </fieldset>
</div>

<form action="?view=admin_panel&load=api_panel&fnc=modify" class="widget_editor add_edit_syn">
    <button class="close">Закрыть</button>
    <fieldset>
        <legend>Изменить синоним</legend>
        <input type="hidden" name="fnc" value="">
        <input type="hidden" name="type" value="">
        <input type="hidden" name="synonym[id]" value="">
        <input type="text" name="synonym[synonym]" placeholder="Синоним" />
        <select name="synonym[dict]">
        </select>
        <button class="save">Сохранить</button>
    </fieldset>
</form>