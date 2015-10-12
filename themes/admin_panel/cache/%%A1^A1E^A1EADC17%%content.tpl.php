<?php /* Smarty version 2.6.26, created on 2015-10-13 02:08:11
         compiled from content.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'layout/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'layout/menu.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>



	<!-- Primary Page Layout
	================================================== -->

	<!-- Delete everything in this .container and get started on your own site! -->

    <div id="ajaxStatus">
        <span></span>
    </div>
	<div class="container">
        <div class="gridpanel">
            <div class="row widget_editor">
                <div class="panel scrollLayer">
                    <ul>
                <?php $_from = $this->_tpl_vars['viewData']['content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
                        <li>
                            <p><?php echo $this->_tpl_vars['data']->title; ?>
</p>
                            <small><?php if ($this->_tpl_vars['data']->type == 1): ?>Системная страница<?php elseif ($this->_tpl_vars['data']->type == 2): ?>Страница<?php elseif ($this->_tpl_vars['data']->type == 3): ?>Баннер<?php endif; ?></small>
                        </li>
                <?php endforeach; endif; unset($_from); ?>
                    </ul>
                </div>
            </div>
        </div>

	</div><!-- container -->

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'layout/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>