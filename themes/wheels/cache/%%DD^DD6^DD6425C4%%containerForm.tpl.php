<?php /* Smarty version 2.6.26, created on 2015-04-13 18:40:00
         compiled from container/forms/paymentCenter/containerForm.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'container/forms/paymentCenter/containerForm.tpl', 10, false),)), $this); ?>
<div id="main" data-role="main">
    <h2>Пакет: <?php echo $this->_tpl_vars['viewData']->container['package']->title; ?>
</h2>
    <div class="widget">
        <form action="<?php echo $this->_tpl_vars['baseLink']; ?>
/?view=api&load=paymentcenter" class="form">
            <input type="hidden" name="fnc" value="buyPackage">
            <input type="hidden" name="sku" value="<?php echo $this->_tpl_vars['viewData']->container['package']->sku; ?>
">
            <h5>
            <?php echo $this->_tpl_vars['viewData']->container['package']->description; ?>

            </h5>
            <h5>Стоимость: <?php echo ((is_array($_tmp=$this->_tpl_vars['viewData']->container['package']->cost)) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
грн./мес.</h5>
            <hr>
            <div class="row-submit">
                <button type="submit">Оплатить в счет балланса</button>
            </div>
        </form>
    </div>
</div>