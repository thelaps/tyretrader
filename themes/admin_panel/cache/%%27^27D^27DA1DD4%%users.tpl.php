<?php /* Smarty version 2.6.26, created on 2015-09-14 02:42:48
         compiled from users.tpl */ ?>
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
                    <table>
                        <?php $_from = $this->_tpl_vars['viewData']['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['user']):
?>
                        <tr>
                            <td><?php echo $this->_tpl_vars['user']->name; ?>
</td>
                            <td><?php echo $this->_tpl_vars['user']->firstname; ?>
</td>
                            <td><?php echo $this->_tpl_vars['user']->lastname; ?>
</td>
                            <td><?php echo $this->_tpl_vars['user']->balance; ?>
</td>
                        </tr>
                        <?php endforeach; endif; unset($_from); ?>
                    </table>
                </div>
            </div>
        </div>

	</div><!-- container -->

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'layout/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>