<?php /* Smarty version 2.6.26, created on 2013-04-28 19:11:40
         compiled from posts.tpl */ ?>
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
        <div class="sixteen columns">
            <ul class="allPosts">
            <?php $_from = $this->_tpl_vars['viewData']['posts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['post']):
?>
                <li><img src="<?php echo $this->_tpl_vars['post']->src; ?>
" title="<?php echo $this->_tpl_vars['post']->title; ?>
"><a href="?view=posts&id=<?php echo $this->_tpl_vars['post']->id; ?>
"><?php echo $this->_tpl_vars['post']->title; ?>
</a></li>
            <?php endforeach; endif; unset($_from); ?>
            </ul>
            <hr />
        </div>

	</div><!-- container -->


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'layout/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>