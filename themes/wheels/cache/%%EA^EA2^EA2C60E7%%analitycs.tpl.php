<?php /* Smarty version 2.6.26, created on 2015-10-13 01:43:47
         compiled from container/analitycs.tpl */ ?>
<div id="main" data-role="main">
    <h2><?php echo $this->_tpl_vars['viewData']->_content->title; ?>
</h2>
    <p><?php echo $this->_tpl_vars['viewData']->_content->content; ?>
</p>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "container/forms/analitycsContainerForm.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "container/forms/analitycsContainerCatalog.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>