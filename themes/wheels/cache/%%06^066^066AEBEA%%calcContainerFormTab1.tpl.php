<?php /* Smarty version 2.6.26, created on 2014-05-03 13:48:20
         compiled from container/forms/optTabs/calcContainerFormTab1.tpl */ ?>
<div class="tab" data-role="tab">
    <form action="<?php echo $this->_tpl_vars['baseLink']; ?>
/?view=api&load=calculator" class="form form-filter">
        <input type="hidden" name="fnc" value="addMargin">
        <input type="hidden" name="calculator[id]" value="">
        <input type="hidden" name="calculator[type]" value="wholesale">
        <div class="row">
            <div class="area-brand">
                <div class="row">
                    <div class="field align-left">
                        <label>Бренд</label>
                        <select name="calculator[manufacturer_id]" class="dataFilter" data-filter="#modelTab_<?php echo $this->_tpl_vars['dataIndex']; ?>
">
                            <!--Легковой 1, легкогрузовой 2, индустр 3, грузовой 4, мото 5-->
                            <option value="">Не выбран</option>
                        <?php $_from = $this->_tpl_vars['viewData']->container['formData']->manufacturer; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                            <?php if ($this->_tpl_vars['row']->manufacturer_type == 'tyre'): ?>
                                <option value="<?php echo $this->_tpl_vars['row']->manufacturer_id; ?>
"><?php echo $this->_tpl_vars['row']->manufacturer_name; ?>
</option>
                            <?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?>
                        </select>
                    </div>
                    <div class="field align-right">
                        <label>Модель</label>
                        <select id="modelTab_<?php echo $this->_tpl_vars['dataIndex']; ?>
" name="calculator[model_id]">
                            <option value="">Не выбрана</option>
                        <?php $_from = $this->_tpl_vars['viewData']->container['formData']->model; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                            <?php if ($this->_tpl_vars['row']->manufacturer_type == 'tyre'): ?>
                                <option style="display: none;" data-manufacturer="<?php echo $this->_tpl_vars['row']->manufacturer_id; ?>
" value="<?php echo $this->_tpl_vars['row']->model_id; ?>
"><?php echo $this->_tpl_vars['row']->model_name; ?>
</option>
                            <?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-left">
                        <label>Город</label>
                        <select name="calculator[city_id]" class="cityFilter" data-filter="#companyTab_<?php echo $this->_tpl_vars['dataIndex']; ?>
">
                            <!--Легковой 1, легкогрузовой 2, индустр 3, грузовой 4, мото 5-->
                            <option value="">Все</option>
                        <?php $_from = $this->_tpl_vars['viewData']->container['formData']->cities; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                            <option value="<?php echo $this->_tpl_vars['row']->region_id; ?>
"><?php echo $this->_tpl_vars['row']->name; ?>
</option>
                        <?php endforeach; endif; unset($_from); ?>
                        </select>
                    </div>
                    <div class="field align-right">
                        <label>Поставщик</label>
                        <select id="companyTab_<?php echo $this->_tpl_vars['dataIndex']; ?>
" name="calculator[company_id]">
                            <option value="">Все</option>
                        <?php $_from = $this->_tpl_vars['viewData']->container['formData']->companies; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                            <option data-city="<?php echo $this->_tpl_vars['row']->regionid; ?>
" value="<?php echo $this->_tpl_vars['row']->id; ?>
"><?php echo $this->_tpl_vars['row']->name; ?>
 (<?php echo $this->_tpl_vars['row']->city; ?>
)</option>
                        <?php endforeach; endif; unset($_from); ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="area-type">
                <div class="field">
                    <label>Сезон</label>
                    <ul class="opt-group justify" data-role="seasons">
                        <li>
                            <input type="checkbox" name="calculator[season]" value="2" id="s_season-1"<?php if ($this->_tpl_vars['viewData']->container['class']->whatSeason(2)): ?> checked="checked"<?php endif; ?>>
                            <label for="s_season-1">Летняя</label>
                        </li>
                        <li>
                            <input type="checkbox" name="calculator[season]" value="1" id="s_season-2"<?php if ($this->_tpl_vars['viewData']->container['class']->whatSeason(1)): ?> checked="checked"<?php endif; ?>>
                            <label for="s_season-2">Зимняя</label>
                        </li>
                        <li>
                            <input type="checkbox" name="calculator[season]" value="3" id="s_season-3"<?php if ($this->_tpl_vars['viewData']->container['class']->whatSeason(3)): ?> checked="checked"<?php endif; ?>>
                            <label for="s_season-3">Всесезонная</label>
                        </li>
                    </ul>
                </div>
                <div class="size-field">
                    <div>
                        <label for="s_t-width">Ширина шины</label>
                        <!--<input id="s_t-width" class="size-s" type="text" name="tyre[size_w][]">-->
                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "container/forms/tyreWidth.tpl", 'smarty_include_vars' => array('id' => "s_t-width",'isAll' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    </div>
                    <span>/</span>
                    <div>
                        <label for="s_t-height">Высота шины</label>
                        <!--<input id="s_t-height" class="size-s" type="text" name="tyre[size_h][]">-->
                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "container/forms/tyreHeight.tpl", 'smarty_include_vars' => array('id' => "s_t-height",'isAll' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    </div>
                    <span>R</span>
                    <div>
                        <label for="s_radial">Диаметр</label>
                        <!--<input id="s_radial" class="size-s" type="text" name="tyre[size_r][]">-->
                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "container/forms/tyreRadius.tpl", 'smarty_include_vars' => array('id' => 's_radial','isAll' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    </div>
                </div>
            </div>
            <div class="buttons-set">
                <button type="reset">ОЧИСТИТЬ</button>
                <button type="submit">СОХРАНИТЬ</button>
            </div>
        </div>
        <hr>
        <div class="price-calc size-field">
            <div>
                <label>Процент</label>
                <input name="calculator[percentage]" class="size-s" type="text">
            </div>
            <div>
                <label>Разброс цен</label>
                <input name="calculator[min_cost]" class="size-m" type="text">
                <span>до</span>
                <input name="calculator[max_cost]" class="size-m" type="text">
            </div>
            <div>
                <label>Фикс. значение</label>
                <input name="calculator[fixed_cost]" class="size-m" type="text">
            </div>
            <div class="group">
                <div>
                    <label>Не менее</label>
                    <input name="calculator[not_less]" class="size-m" type="text">
                </div>
                <div>
                    <label>Не более</label>
                    <input name="calculator[not_more]" class="size-m" type="text">
                </div>
            </div>
            <div>
                <label>Доставка</label>
                <input name="calculator[shipping]" class="size-s" type="text">
            </div>
            <div>
                <label>Перевод</label>
                <input name="calculator[transfer]" class="size-s" type="text">
            </div>
            <div>
                <label>Банк. расходы</label>
                <input name="calculator[bank]" class="size-m" type="text">
            </div>
        </div>
    </form>
</div>