<?php /* Smarty version 2.6.26, created on 2016-02-21 10:55:53
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
        <div class="one-third column">
            <h4>Страницы системные</h4>
            <ul>
            <?php $_from = $this->_tpl_vars['viewData']['content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
                <?php if ($this->_tpl_vars['data']->type == 1): ?>
                <li> - <a href="?view=admin_panel&load=content_panel&fnc=edit&type=content&id=<?php echo $this->_tpl_vars['data']->id; ?>
"><?php echo $this->_tpl_vars['data']->description; ?>
</a></li>
                <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
            </ul>
        </div>
        <div class="one-third column">
            <h4>Страницы</h4>
            <ul>
            <?php $_from = $this->_tpl_vars['viewData']['content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
                <?php if ($this->_tpl_vars['data']->type == 2): ?>
                <li> - <a href="?view=admin_panel&load=content_panel&fnc=edit&type=content&id=<?php echo $this->_tpl_vars['data']->id; ?>
"><?php echo $this->_tpl_vars['data']->description; ?>
</a></li>
                <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
            </ul>
        </div>
        <div class="one-third column">
            <h4>Баннеры</h4>
            <ul>
            <?php $_from = $this->_tpl_vars['viewData']['content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
                <?php if ($this->_tpl_vars['data']->type == 3): ?>
                <li> - <a href="?view=admin_panel&load=content_panel&fnc=edit&type=banner&id=<?php echo $this->_tpl_vars['data']->id; ?>
"><?php echo $this->_tpl_vars['data']->description; ?>
</a></li>
                <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
            </ul>
        </div>
        <div class="one-third column">
            <h4>Текст</h4>
            <ul>
            <?php $_from = $this->_tpl_vars['viewData']['content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
                <?php if ($this->_tpl_vars['data']->type == 4): ?>
                <li> - <a href="?view=admin_panel&load=content_panel&fnc=edit&type=content&id=<?php echo $this->_tpl_vars['data']->id; ?>
"><?php echo $this->_tpl_vars['data']->description; ?>
</a></li>
                <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
            </ul>
        </div>
        <div class="one-third column">
            <h4>Тарифные планы</h4>
            <ul>
            <?php $_from = $this->_tpl_vars['viewData']['packages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
                    <li> - <a href="?view=admin_panel&load=content_panel&fnc=edit&type=package&id=<?php echo $this->_tpl_vars['data']->id; ?>
"><?php echo $this->_tpl_vars['data']->title; ?>
 <?php echo $this->_tpl_vars['data']->cost; ?>
</a></li>
            <?php endforeach; endif; unset($_from); ?>
            </ul>
        </div>

	</div><!-- container -->

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'layout/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>