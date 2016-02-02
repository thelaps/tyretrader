<?php /* Smarty version 2.6.26, created on 2014-10-12 21:29:40
         compiled from forgotdone.tpl */ ?>
<html>
    <head>
        <title>Успешная регистрация на сервисе</title>
    </head>
    <body>
        Приветствуем вас <?php echo $this->_tpl_vars['data']->user->firstname; ?>
 <?php echo $this->_tpl_vars['data']->user->lastname; ?>
!<br><br>

        Это письмо было отправлено вам после подтверждения сброса пароля<br>

        Ваши новые данные для входа в систему:<br>
        <div style="background: #d6f4f9; display: block; padding: 40px;">
            <h5><span style="font-weight: normal;">Логин:</span> <?php echo $this->_tpl_vars['data']->user->login; ?>
</h5><br>
            <h5><span style="font-weight: normal;">Пароль:</span> <?php echo $this->_tpl_vars['data']->newpass; ?>
</h5><br>
        </div>
    </body>
</html>