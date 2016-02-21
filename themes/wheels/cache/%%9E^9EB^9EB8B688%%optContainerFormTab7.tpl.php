<?php /* Smarty version 2.6.26, created on 2016-02-21 12:56:52
         compiled from container/forms/optTabs/optContainerFormTab7.tpl */ ?>
<div class="tab" data-role="tab">
    <form action="<?php echo $this->_tpl_vars['baseLink']; ?>
/?view=api&load=opt" class="form form-order">
        <input type="hidden" name="fnc" value="opt">
        <input type="hidden" name="filter[manufacturer]" value="BT" class="filter-manufacturer">
        <input type="hidden" name="filter[model]" value="BT" class="filter-model">
        <input type="hidden" name="filter[stock_1]" value="TB" class="filter-stock_1">
        <input type="hidden" name="filter[date]" value="TB" class="filter-date">
        <input type="hidden" name="filter[price_1]" value="BT" class="filter-price_1">
        <input type="hidden" name="filter[sqlscopename]" value="BT" class="filter-sqlscopename">
        <input type="hidden" name="wheel[type_transport]" value="<?php echo $this->_tpl_vars['dataIndex']; ?>
">
        <div class="order-options">
            <div class="h-separator"></div>
            <div class="row disc-options" data-name="product-type">
                <!-- Select brand -->
                <div class="area-brand">
                    <div class="row">
                        <div class="field align-left">
                            <label>Бренд</label>
                            <select name="wheel[manufacturer]" class="dataFilter jcf-ignore" data-filter="#modelTab_<?php echo $this->_tpl_vars['dataIndex']; ?>
">
                                <option value="">Не выбран</option>
                            <?php $_from = $this->_tpl_vars['viewData']->container['formData']->manufacturer[$this->_tpl_vars['dataIndex']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                <?php if ($this->_tpl_vars['row']->manufacturer_type == 'wheel'): ?>
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
" name="wheel[model]">
                                <option value="">Не выбрана</option>
                            <?php $_from = $this->_tpl_vars['viewData']->container['formData']->model[$this->_tpl_vars['dataIndex']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                <?php if ($this->_tpl_vars['row']->manufacturer_type == 'wheel'): ?>
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
                            <select name="wheel[city]" class="cityFilter jcf-ignore" data-filter="#companyTab_<?php echo $this->_tpl_vars['dataIndex']; ?>
">
                                <!--Легковой 1, легкогрузовой 2, индустр 3, грузовой 4, мото 5-->
                                <option value="">Все</option>
                            <?php $_from = $this->_tpl_vars['viewData']->container['formData']->cities; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                <option value="<?php echo $this->_tpl_vars['row']->id; ?>
"><?php echo $this->_tpl_vars['row']->name; ?>
</option>
                            <?php endforeach; endif; unset($_from); ?>
                            </select>
                        </div>
                        <div class="field align-right">
                            <label>Поставщик</label>
                            <select class="jcf-ignore" id="companyTab_<?php echo $this->_tpl_vars['dataIndex']; ?>
" name="wheel[company_id]">
                                <option value="">Все</option>
                            <?php $_from = $this->_tpl_vars['viewData']->container['formData']->companies; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                <option data-city="<?php echo $this->_tpl_vars['row']->capitalid; ?>
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
                    <!-- Disc options -->
                    <div class="field">
                        <label>Тип диска</label>
                        <ul class="opt-group justify">
                            <li>
                                <input type="checkbox" name="wheel[wheel_type]" value="1" id="s_type-1">
                                <label for="s_type-1">Стальной</label>
                            </li>
                            <li>
                                <input type="checkbox" name="wheel[wheel_type]" value="2" id="s_type-2">
                                <label for="s_type-2">Литой</label>
                            </li>
                            <li>
                                <input type="checkbox" name="wheel[wheel_type]" value="3" id="s_type-3">
                                <label for="s_type-3">Кованный</label>
                            </li>
                            <!--<li>
                                <input type="checkbox" name="wheel[wheel_type]" value="4" id="s_type-4">
                                <label for="s_type-4">Составной</label>
                            </li>-->
                        </ul>
                    </div>
                    <div class="size-field">
                        <div>
                            <label for="s_width">Ширина диска</label>
                            <!--<input id="s_width" class="size-s" type="text" name="wheel[size_w][]">-->
                            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "container/forms/wheelWidth.tpl", 'smarty_include_vars' => array('id' => 's_width')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                        </div>
                        <span>/</span>
                        <div>
                            <label for="s_fixture">Крепеж диска</label>
                            <!--<input id="s_fixture" class="size-s" type="text" name="wheel[et][]">-->
                            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "container/forms/wheelEt.tpl", 'smarty_include_vars' => array('id' => 's_fixture')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                        </div>
                        <span>x</span>
                        <div>
                            <label for="s_pcd">PCD</label>
                            <!--<input id="s_pcd" class="size-s" type="text" name="wheel[pcd][]">-->
                            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "container/forms/wheelPcd.tpl", 'smarty_include_vars' => array('id' => 's_pcd')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
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