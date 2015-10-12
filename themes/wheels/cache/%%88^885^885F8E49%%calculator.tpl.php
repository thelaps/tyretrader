<?php /* Smarty version 2.6.26, created on 2015-10-13 01:44:50
         compiled from container/calculator.tpl */ ?>
<div id="main" data-role="main">
    <h2><?php echo $this->_tpl_vars['viewData']->_content->title; ?>
</h2>
    <p><?php echo $this->_tpl_vars['viewData']->_content->content; ?>
</p>
<div class="tab-widget" data-role="tabs">
<ul>
    <li class="active" data-action="post" data-target=".price-grid">
        Оптовые цены
    </li>
    <li data-action="post" data-target=".price-grid">
        Розничные цены
    </li>
</ul>
<div class="tabs-holder">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "container/forms/optTabs/calcContainerFormTab1.tpl", 'smarty_include_vars' => array('dataIndex' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "container/forms/optTabs/calcContainerFormTab2.tpl", 'smarty_include_vars' => array('dataIndex' => 2)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</div>
<div class="block wide">
    <table class="table price-grid">
        <thead>
        <tr>
            <th class="col-id">ID</th>
            <th class="col-provider"><!--<div class="sortable desc">-->ПОСТАВЩИК<!--</div>--></th>
            <th class="col-brand"><!--<div class="sortable asc">-->БРЕНД<!--</div>--></th>
            <th>РАЗБРОС ЦЕН</th>
            <th>ПРОЦЕНТ</th>
            <th>Ф. ЗНАЧ.</th>
            <th>НЕ МЕНЕЕ</th>
            <th>НЕ БОЛЕЕ</th>
            <th>ДОСТАВКА</th>
            <th>ПЕРВОД</th>
            <th>БАНК</th>
            <th>ИЗМЕНИТЬ</th>
            <th>УДАЛИТЬ</th>
        </tr>
        </thead>
        <tbody>
        <?php $_from = $this->_tpl_vars['viewData']->container['listItems']->items; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
        <tr>
            <td class="col-id"><?php echo $this->_tpl_vars['row']->id; ?>
</td>
            <td class="col-provider"><a href="#"><?php echo $this->_tpl_vars['row']->company; ?>
</a></td>
            <td class="col-brand"><?php echo $this->_tpl_vars['row']->manufacturer; ?>
</td>
            <td><?php echo $this->_tpl_vars['row']->min_cost; ?>
-<?php echo $this->_tpl_vars['row']->max_cost; ?>
</td>
            <td><?php echo $this->_tpl_vars['row']->percentage; ?>
%</td>
            <td><?php echo $this->_tpl_vars['row']->fixed_cost; ?>
</td>
            <td><?php echo $this->_tpl_vars['row']->not_less; ?>
</td>
            <td><?php echo $this->_tpl_vars['row']->not_more; ?>
</td>
            <td><?php echo $this->_tpl_vars['row']->shipping; ?>
</td>
            <td><?php echo $this->_tpl_vars['row']->transfer; ?>
</td>
            <td><?php echo $this->_tpl_vars['row']->bank; ?>
</td>
            <td><button type="button" class="edit margin-edit" data-id="<?php echo $this->_tpl_vars['row']->id; ?>
">edit</button></td>
            <td><button type="button" class="delete margin-delete" data-id="<?php echo $this->_tpl_vars['row']->id; ?>
">delete</button></td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
        </tbody>
    </table>
</div>

</div>