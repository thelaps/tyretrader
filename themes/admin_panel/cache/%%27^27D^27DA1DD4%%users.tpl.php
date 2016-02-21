<?php /* Smarty version 2.6.26, created on 2016-01-31 17:49:33
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
                        <thead>
                            <tr>
                                <td>Роль пользов.</td>
                                <td>Тип пользов.</td>
                                <td>Имя</td>
                                <td>Фамилия</td>
                                <td>Балланс</td>
                                <td>Компания</td>
                                <td>Активирована до</td>
                                <td>Состояние</td>
                                <td>Действия</td>
                            </tr>
                        </thead>
                        <?php $_from = $this->_tpl_vars['viewData']['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['user']):
?>
                        <tr>
                            <td class="drop_editable" data-id="<?php echo $this->_tpl_vars['user']->id; ?>
" data-field="user.roleid"><?php if ($this->_tpl_vars['user']->roleid == 1): ?>Пользователь<?php elseif ($this->_tpl_vars['user']->roleid == 2): ?>Админ<?php else: ?>Неизвестен<?php endif; ?></td>
                            <td><?php if ($this->_tpl_vars['user']->usertype == 1): ?>Пользователь<?php elseif ($this->_tpl_vars['user']->usertype == 2): ?>Компания<?php elseif ($this->_tpl_vars['user']->usertype == 3): ?>Поставщик<?php else: ?>Неизвестен<?php endif; ?></td>
                            <td class="editable" data-id="<?php echo $this->_tpl_vars['user']->id; ?>
" data-field="user.firstname"><?php echo $this->_tpl_vars['user']->firstname; ?>
</td>
                            <td class="editable" data-id="<?php echo $this->_tpl_vars['user']->id; ?>
" data-field="user.lastname"><?php echo $this->_tpl_vars['user']->lastname; ?>
</td>
                            <td class="editable" data-id="<?php echo $this->_tpl_vars['user']->id; ?>
" data-field="user.balance"><?php echo $this->_tpl_vars['user']->balance; ?>
</td>
                            <td><?php if ($this->_tpl_vars['user']->company_name != NULL): ?><?php echo $this->_tpl_vars['user']->company_name; ?>
 - (<?php echo $this->_tpl_vars['user']->city_name; ?>
)<?php else: ?> - <?php endif; ?></td>
                            <td><?php if ($this->_tpl_vars['user']->company_expire != NULL): ?><?php echo $this->_tpl_vars['user']->company_expire; ?>
<?php else: ?> - <?php endif; ?></td>
                            <td><?php if ($this->_tpl_vars['user']->company_status != NULL): ?><?php if ($this->_tpl_vars['user']->company_status == 1): ?>Включена<?php else: ?>Отключена<?php endif; ?><?php else: ?> - <?php endif; ?></td>
                            <td>
                                <a href="#" class="enterAsClient" data-id="<?php echo $this->_tpl_vars['user']->id; ?>
"></a>
                                <a href="#" class="deleteClient" data-id="<?php echo $this->_tpl_vars['user']->id; ?>
"></a>
                            </td>
                        </tr>
                        <?php endforeach; endif; unset($_from); ?>
                    </table>
                </div>
                <div class="panel">
                    Сейчас в сети: <b><?php echo $this->_tpl_vars['viewData']['statistics']->online; ?>
</b><br/>
                    За сутки в сети: <b><?php echo $this->_tpl_vars['viewData']['statistics']->last_day_online; ?>
</b>
                </div>
            </div>
        </div>

	</div><!-- container -->

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'layout/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>