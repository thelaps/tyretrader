<?php /* Smarty version 2.6.26, created on 2013-03-25 20:57:36
         compiled from post.tpl */ ?>
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

	<div class="container">
		<div class="sixteen columns head">
			<h1 class="remove-bottom" style="margin-top: 40px">Jumper Engine (basic theme)</h1>
			<h5>Version --</h5>
			<hr />
		</div>
        <div class="columns">
            <h3 class="remove-bottom" style="margin-top: 40px"><?php echo $this->_tpl_vars['viewData']['post']->title; ?>
</h3>
            <div class="columns">
                <img src="<?php echo $this->_tpl_vars['viewData']['post']->src; ?>
">
            </div>
            <p>
                <?php echo $this->_tpl_vars['viewData']['post']->text; ?>

            </p>
            <del><?php echo $this->_tpl_vars['viewData']['post']->date; ?>
</del>
            <hr />
        </div>

	</div><!-- container -->


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'layout/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>