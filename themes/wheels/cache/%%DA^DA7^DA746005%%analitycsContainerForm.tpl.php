<?php /* Smarty version 2.6.26, created on 2014-07-01 00:39:38
         compiled from container/forms/analitycsContainerForm.tpl */ ?>
<div class="widget">
    <form action="<?php echo $this->_tpl_vars['baseLink']; ?>
/?view=api&load=opt" class="form form-filter">
        <input type="hidden" name="fnc" value="analitycs">
        <!--<input type="hidden" name="tyre[notcompany_id]" value="<?php echo $this->_tpl_vars['viewData']->profile->user->companyid; ?>
">
        <input type="hidden" name="wheel[notcompany_id]" value="<?php echo $this->_tpl_vars['viewData']->profile->user->companyid; ?>
">-->
        <div class="area-brand">
            <div class="field">
                <label>Вид</label>
                <ul class="opt-group" data-role="switcher" data-name="product-type">
                    <li>
                        <input id="tyre" data-target=".tyre-options" type="radio" name="product-type" value="tyre" checked>
                        <label for="tyre">Шины</label>
                    </li>
                    <li>
                        <input id="disc" data-target=".disc-options" type="radio" name="product-type" value="wheel">
                        <label for="disc">Диски</label>
                    </li>
                </ul>
            </div>
            <div class="row tyre-options" data-name="product-type">
                <div class="field align-left">
                    <label>Бренд</label>
                    <select name="tyre[manufacturer]" class="dataFilter" data-filter="#modelTab_1">
                        <!--Легковой 1, легкогрузовой 2, индустр 3, грузовой 4, мото 5-->
                        <option value="">Не выбран</option>
                        <?php $_from = $this->_tpl_vars['viewData']->container['formData']->manufacturer['1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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
                    <select id="modelTab_1" name="tyre[model]">
                        <option value="">Не выбрана</option>
                        <?php $_from = $this->_tpl_vars['viewData']->container['formData']->model['1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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
            <!-- Select brand -->
            <div class="row disc-options" data-name="product-type">
                <div class="field align-left">
                    <label>Бренд</label>
                    <select name="wheel[manufacturer]" class="dataFilter" data-filter="#modelTab_0">
                        <option value="">Не выбран</option>
                    <?php $_from = $this->_tpl_vars['viewData']->container['formData']->manufacturer['0']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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
                    <select id="modelTab_0" name="wheel[model]">
                        <option value="">Не выбрана</option>
                    <?php $_from = $this->_tpl_vars['viewData']->container['formData']->model['0']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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
        <div class="area-type">
            <!-- Tyre options -->
            <div class="tyre-options" data-name="product-type">
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
$this->_smarty_include(array('smarty_include_tpl_file' => "container/forms/tyreWidth.tpl", 'smarty_include_vars' => array('id' => "s_t-width")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    </div>
                    <span>/</span>
                    <div>
                        <label for="s_t-height">Высота шины</label>
                        <!--<input id="s_t-height" class="size-s" type="text" name="tyre[size_h][]">-->
                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "container/forms/tyreHeight.tpl", 'smarty_include_vars' => array('id' => "s_t-height")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    </div>
                    <span>R</span>
                    <div>
                        <label for="s_radial">Диаметр</label>
                        <!--<input id="s_radial" class="size-s" type="text" name="tyre[size_r][]">-->
                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "container/forms/tyreRadius.tpl", 'smarty_include_vars' => array('id' => 's_radial')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    </div>
                </div>
            </div>

            <div class="disc-options" data-name="product-type">
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
        <div class="buttons-set">
            <button type="reset">ОЧИСТИТЬ</button>
            <button type="submit">ПОКАЗАТЬ</button>
        </div>
    </form>
</div>