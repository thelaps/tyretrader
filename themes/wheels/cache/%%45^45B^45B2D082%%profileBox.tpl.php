<?php /* Smarty version 2.6.26, created on 2014-09-01 21:57:49
         compiled from widget/profileBox.tpl */ ?>
<?php if ($this->_tpl_vars['viewData']->profile->isLoggedin()): ?>
<div class="panel profile-panel">
    <div class="profile-info">
                    <span class="name">
                        <a href="<?php echo $this->_tpl_vars['baseLink']; ?>
/?load=home"><?php echo $this->_tpl_vars['viewData']->profile->user->firstname; ?>
.</a>
                    </span>
                    <span class="messages">
                        <span class="ico ico-email"></span>
                        <a href="<?php echo $this->_tpl_vars['baseLink']; ?>
/?load=messages">(0)</a>
                    </span>
        <span class="balance">Баланс: <b><?php echo $this->_tpl_vars['viewData']->profile->user->balance; ?>
</b> грн.</span>
    </div>
    <div class="services">
        <select class="alt alterLocation">
            <option>Сервисы</option>
            <option value="<?php echo $this->_tpl_vars['baseLink']; ?>
/?load=export">Экспорт прайс-листа</option>
            <option value="<?php echo $this->_tpl_vars['baseLink']; ?>
/?load=analitycs">Аналитика</option>
            <option value="<?php echo $this->_tpl_vars['baseLink']; ?>
/?load=calculator">Калькулятор цен</option>
            <option value="<?php echo $this->_tpl_vars['baseLink']; ?>
/?load=viewsettings">Настройки отображения</option>
        </select>
        <form action="<?php echo $this->_tpl_vars['baseLink']; ?>
/?view=api&load=account" class="inline-form">
            <input type="hidden" name="fnc" value="logout">
            <a class="link" type="submit" href="#">Выход</a>
        </form>
    </div>
    <ul id="nav" class="link-group">
        <li><a href="<?php echo $this->_tpl_vars['baseLink']; ?>
/">Главная</a></li>
        <!--<li><a href="#">Покупка</a></li>
        <li><a href="<?php echo $this->_tpl_vars['baseLink']; ?>
/?load=sold">Продажа</a></li>-->
        <li><a href="<?php echo $this->_tpl_vars['baseLink']; ?>
/?load=opt">Опт</a></li>
        <!--<li><a href="#">Объявления</a></li>-->
    </ul>
</div>
<?php else: ?>
<div class="panel">
    <form action="<?php echo $this->_tpl_vars['baseLink']; ?>
/?view=api&load=account" class="inline-form">
        <input type="hidden" name="fnc" value="auth">
        <label for="login-name">Логин:</label>
        <input type="text" name="login" id="login-name">
        <label for="password">Пароль:</label>
        <input type="password" name="pass" id="password">
        <input type="submit" value="Вход">
        <a href="<?php echo $this->_tpl_vars['baseLink']; ?>
/?view=index&load=registration" class="registration">Регистрация</a>
    </form>
    <ul id="nav" class="link-group align-right">
        <li><a href="<?php echo $this->_tpl_vars['baseLink']; ?>
/">Главная</a></li>
        <!--<li><a href="#">Покупка</a></li>-->
        <li><a href="<?php echo $this->_tpl_vars['baseLink']; ?>
/?load=sold">Продажа</a></li>
    </ul>
</div>
<?php endif; ?>