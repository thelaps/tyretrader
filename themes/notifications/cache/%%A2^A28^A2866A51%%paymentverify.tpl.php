<?php /* Smarty version 2.6.26, created on 2015-12-24 17:18:53
         compiled from paymentverify.tpl */ ?>
<html>
    <head>
        <title>Попытка верификации оплаты</title>
    </head>
    <body>
        Пользователь: [#<?php echo $this->_tpl_vars['data']['invoice']->user->id; ?>
] <?php echo $this->_tpl_vars['data']['invoice']->user->firstname; ?>
 <?php echo $this->_tpl_vars['data']['invoice']->user->lastname; ?>
<br><br>
        Платеж: [#<?php echo $this->_tpl_vars['data']['invoice']->id; ?>
] <?php echo $this->_tpl_vars['data']['invoice']->title; ?>
 <?php echo $this->_tpl_vars['data']['invoice']->price; ?>
<br><br>

        Данные коллбека:<br>
        <div style="background: #d6f4f9; display: block; padding: 40px;">
            <h5><span style="font-weight: normal;">SIGN:</span> <?php echo $this->_tpl_vars['data']['post']['data']; ?>
</h5><br>
            <h5><span style="font-weight: normal;">DATA:</span> <?php echo $this->_tpl_vars['data']['post']['signature']; ?>
</h5><br>
        </div>
    </body>
</html>