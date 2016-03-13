<?php /* Smarty version 2.6.26, created on 2016-03-12 20:49:11
         compiled from container/forms/homeTabs/homeContainerFormTabPackages.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'container/forms/homeTabs/homeContainerFormTabPackages.tpl', 10, false),)), $this); ?>
<div id="packages_grid">
    <?php $_from = $this->_tpl_vars['viewData']->container['packages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['package']):
?>
    <div class="package_item">
        <form action="<?php echo $this->_tpl_vars['baseLink']; ?>
/?view=api&load=paymentcenter" class="form form-filter" enctype="multipart/form-data">
            <input type="hidden" name="fnc" value="buyPackage">
            <input type="hidden" name="sku" value="<?php echo $this->_tpl_vars['package']->sku; ?>
">
            <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['package']->id; ?>
">
            <h4><?php echo $this->_tpl_vars['package']->title; ?>
</h4>
            <p><?php echo $this->_tpl_vars['package']->description; ?>
</p>
            <button type="submit">Купить за <?php echo ((is_array($_tmp=$this->_tpl_vars['package']->cost)) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
грн./мес. на <?php if ($this->_tpl_vars['package']->amount > 0): ?><?php echo $this->_tpl_vars['package']->amount; ?>
<?php endif; ?>мес.</button>
        </form>
    </div>
    <hr/>
    <?php endforeach; endif; unset($_from); ?>
</div>