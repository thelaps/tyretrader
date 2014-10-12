<?php /* Smarty version 2.6.26, created on 2014-10-12 21:26:33
         compiled from forgotrequest.tpl */ ?>
<html>
    <head>
        <title>Успешная регистрация на сервисе</title>
    </head>
    <body>
        Приветствуем вас <?php echo $this->_tpl_vars['data']->user->firstname; ?>
 <?php echo $this->_tpl_vars['data']->user->lastname; ?>
!<br><br>

        Это письмо было отправлено вам для подтверждения сброса пароля<br>
        Если вы его не отправляли, просто проигнорируйте.<br>
        В случае если вы действительно забыли пароль, то нажмите на ссылку ниже и вам будет выслан ваш новый пароль.

        Ваша ссылка на сброс пароля:<br>
        <div style="background: #d6f4f9; display: block; padding: 40px;">
            <a href="<?php echo $this->_tpl_vars['data']->link; ?>
"><?php echo $this->_tpl_vars['data']->link; ?>
</a><br>
        </div>
    </body>
</html>