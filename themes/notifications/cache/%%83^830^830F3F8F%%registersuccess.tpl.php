<?php /* Smarty version 2.6.26, created on 2015-08-03 22:35:14
         compiled from registersuccess.tpl */ ?>
<html>
    <head>
        <title>Успешная регистрация на сервисе AutoManager</title>
    </head>
    <body>
        Приветствуем вас <?php echo $this->_tpl_vars['data']->firstname; ?>
 <?php echo $this->_tpl_vars['data']->lastname; ?>
!<br><br>

        Вы только что успешно зарегистрировались на портале <a href="http://automanager.com.ua">AutoManager</a><br>

        Ваши регистрационные данные для входа в систему:<br>
        <div style="background: #d6f4f9; display: block; padding: 40px;">
            <h5><span style="font-weight: normal;">Логин:</span> <?php echo $this->_tpl_vars['data']->login; ?>
</h5><br>
            <h5><span style="font-weight: normal;">Пароль:</span> <?php echo $this->_tpl_vars['data']->pass; ?>
</h5><br>
        </div>
    </body>
</html>