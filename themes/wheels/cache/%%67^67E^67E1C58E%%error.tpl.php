<?php /* Smarty version 2.6.26, created on 2015-08-15 08:34:27
         compiled from error.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'layout/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>



	<!-- Primary Page Layout
	================================================== -->

	<!-- Delete everything in this .container and get started on your own site! -->
	<div class="container">
		<div class="sixteen columns head">
			<h1 class="remove-bottom" style="margin-top: 40px"><span class="errorCode"><?php echo $this->_tpl_vars['viewData']->error->code; ?>
</span> <span class="errorMessage"><?php echo $this->_tpl_vars['viewData']->error->message; ?>
</span></h1>
			<h5>Platform ver. 1.8.3</h5>
			<hr />
		</div>
		<div class="one-third column">
			<h3>Информация</h3>
			<p>

            </p>
		</div>
		<div class="one-third column">
			<h3>Контакты</h3>
			<p>Тех. поддержка:</p>
			<ul class="square">
				<li><strong>тел.:</strong>: +38 (000) 000-00-00</li>
				<li><strong>email.:</strong>: support@asd.asd</li>
				<!--<li><strong>Style Agnostic</strong>: It provides the most basic, beautiful styles, but is meant to be overwritten.</li>-->
			</ul>
		</div>
		<div class="one-third column">
			<h3>Docs &amp; Support</h3>
			<p>
                The easiest way to really get started with JE is to check out the full docs and info at <a href="http://thelaps.biz">thelaps.biz</a>. JE is also open-source and has no project on git.
            </p>
		</div>

	</div><!-- container -->


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'layout/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>