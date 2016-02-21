<?php /* Smarty version 2.6.26, created on 2016-02-21 12:56:52
         compiled from container/forms/optTabs/optContainerFormTab1Merged.tpl */ ?>
<div class="tab" data-role="tab">
    <form action="<?php echo $this->_tpl_vars['baseLink']; ?>
/?view=api&load=opt" class="form form-order">
        <input type="hidden" name="fnc" value="opt">
        <input type="hidden" name="filter[manufacturer]" value="BT" class="filter-manufacturer">
        <input type="hidden" name="filter[model]" value="BT" class="filter-model">
        <input type="hidden" name="filter[stock_1]" value="TB" class="filter-stock_1">
        <input type="hidden" name="filter[date]" value="TB" class="filter-date">
        <input type="hidden" name="filter[price_1]" value="BT" class="filter-price_1">
        <input type="hidden" name="tyre[type_transport][]" value="1">
        <input type="hidden" name="tyre[type_transport][]" value="2">
        <input type="hidden" name="filter[sqlscopename]" value="BT" class="filter-sqlscopename">
        <input type="hidden" name="tyre[duo]" value="0">
        <div class="order-options">
            <div class="h-separator"></div>
            <!-- Tyres Options -->
            <div class="row tyre-options" data-name="product-type">
                <!-- Select brand -->
                <div class="area-brand">
                    <div class="row">
                        <div class="field align-left">
                            <label>Бренд</label>
                            <select name="tyre[manufacturer]" class="dataFilter jcf-ignore" data-filter="#modelTab_<?php echo $this->_tpl_vars['dataIndex']; ?>
">
                                <!--Легковой 1, легкогрузовой 2, индустр 3, грузовой 4, мото 5-->
                                <option value="">Не выбран</option>
                            <?php $_from = $this->_tpl_vars['viewData']->container['formData']->manufacturer[$this->_tpl_vars['dataIndex']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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
                            <select class="jcf-ignore" id="modelTab_<?php echo $this->_tpl_vars['dataIndex']; ?>
" name="tyre[model]">
                                <option value="">Не выбрана</option>
                            <?php $_from = $this->_tpl_vars['viewData']->container['formData']->model[$this->_tpl_vars['dataIndex']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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
                </div>
                <div class="area-brand">
                    <div class="row">
                        <div class="field align-left">
                            <label>Город</label>
                            <select name="tyre[city]" class="cityFilter jcf-ignore" data-filter="#companyTab_<?php echo $this->_tpl_vars['dataIndex']; ?>
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
                            <select class="jcf-ignore" id="companyTab_<?php echo $this->_tpl_vars['dataIndex']; ?>
" name="tyre[company_id]">
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
                <!-- Select type and size -->
                <div class="area-type">
                    <!-- Tyre options -->
                    <div class="field">
                        <label>Сезон</label>
                        <ul class="opt-group justify" data-role="seasons">
                            <li>
                                <input type="checkbox" name="tyre[season][]" value="2" id="s_season-1"<?php if ($this->_tpl_vars['viewData']->container['class']->whatSeason(2)): ?> checked="checked"<?php endif; ?>>
                                <label for="s_season-1">Летняя</label>
                            </li>
                            <li>
                                <input type="checkbox" name="tyre[season][]" value="1" id="s_season-2"<?php if ($this->_tpl_vars['viewData']->container['class']->whatSeason(1)): ?> checked="checked"<?php endif; ?>>
                                <label for="s_season-2">Зимняя</label>
                            </li>
                            <li>
                                <input type="checkbox" name="tyre[season][]" value="3" id="s_season-3"<?php if ($this->_tpl_vars['viewData']->container['class']->whatSeason(3)): ?> checked="checked"<?php endif; ?>>
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
$this->_smarty_include(array('smarty_include_tpl_file' => "container/forms/tyreRadius.tpl", 'smarty_include_vars' => array('id' => 's_radial','isAll' => true,'enableCSize' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                        </div>
                    </div>
                </div>
                <div class="area-type-additional">
                    <div class="additional-box-switch">
                        <input type="checkbox" name="tyre[duo]" value="1" id="tyre-duo" class="blockToggle" data-block="#blockToggle">
                        <label for="tyre-duo">Разношинные</label>
                    </div>
                    <div id="blockToggle" class="additional-box" style="display: none;">
                        <!-- Tyre options -->
                        <div class="size-field">
                            <div>
                                <label for="as_t-width">Ширина шины</label>
                                <!--<input id="as_t-width" class="size-s" type="text" name="tyre[size_w][]">-->
                                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "container/forms/tyreWidth.tpl", 'smarty_include_vars' => array('id' => "as_t-width")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                            </div>
                            <span>/</span>
                            <div>
                                <label for="as_t-height">Высота шины</label>
                                <!--<input id="as_t-height" class="size-s" type="text" name="tyre[size_h][]">-->
                                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "container/forms/tyreHeight.tpl", 'smarty_include_vars' => array('id' => "as_t-height")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                            </div>
                            <span>R</span>
                            <div>
                                <label for="as_radial">Диаметр</label>
                                <!--<input id="as_radial" class="size-s" type="text" name="tyre[size_r][]">-->
                                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "container/forms/tyreRadius.tpl", 'smarty_include_vars' => array('id' => 'as_radial')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="order-submit">
            <button type="submit">Подобрать</button>
        </div>
    </form>
</div>