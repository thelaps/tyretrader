<?php /* Smarty version 2.6.26, created on 2014-08-26 23:27:45
         compiled from registersuccess.tpl */ ?>
Приветствуем вас <?php echo $this->_tpl_vars['data']->firstname; ?>
 <?php echo $this->_tpl_vars['data']->lastname; ?>
!<br><br>

Вы только что успешно ззарегистрировались на портале <a href="http://tyretrader.com">tyretrader</a><br>

Ваши регистрационные данные для входа в систему:<br>
<div style="background: #d6f4f9; display: block; padding: 40px;">
    <h5><span style="font-weight: normal;">Логин:</span> <?php echo $this->_tpl_vars['data']->login; ?>
</h5><br>
    <h5><span style="font-weight: normal;">Пароль:</span> <?php echo $this->_tpl_vars['data']->pass; ?>
</h5><br>
</div>