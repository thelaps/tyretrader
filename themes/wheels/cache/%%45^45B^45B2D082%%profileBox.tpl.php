<?php /* Smarty version 2.6.26, created on 2016-01-18 19:01:57
         compiled from widget/profileBox.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'widget/profileBox.tpl', 60, false),)), $this); ?>
<?php if ($this->_tpl_vars['viewData']->profile->isLoggedin()): ?>
<?php echo '
<!-- Start SiteHeart code -->
<script>
    (function(){
        var widget_id = 795350;
        _shcp =[{widget_id : widget_id}];
        var lang =(navigator.language || navigator.systemLanguage
                || navigator.userLanguage ||"en")
                .substr(0,2).toLowerCase();
        var url ="widget.siteheart.com/widget/sh/"+ widget_id +"/"+ lang +"/widget.js";
        var hcc = document.createElement("script");
        hcc.type ="text/javascript";
        hcc.async =true;
        hcc.src =("https:"== document.location.protocol ?"https":"http")
                +"://"+ url;
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hcc, s.nextSibling);
    })();
</script>
<!-- End SiteHeart code -->
'; ?>

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
        <?php if ($this->_tpl_vars['viewData']->profile->user->roleid == 2): ?><li><a href="<?php echo $this->_tpl_vars['baseLink']; ?>
/?view=admin_panel&load=price_panel">Обработка прайсов</a></li><?php endif; ?>
        <?php if ($this->_tpl_vars['viewData']->x_entry): ?><li><a href="<?php echo $this->_tpl_vars['baseLink']; ?>
/?view=admin_panel&load=user_panel" class="exitFromUser">Список пользователей</a></li><?php endif; ?>
        <!--<li><a href="#">Объявления</a></li>-->
    </ul>
</div>
<div class="currency-panel">
   Курс валют:
    <?php $_from = $this->_tpl_vars['viewData']->profile->currency; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['currency']):
?>
        <?php echo $this->_tpl_vars['currency']->iso; ?>
 - <?php echo ((is_array($_tmp=$this->_tpl_vars['currency']->rate)) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>

    <?php endforeach; endif; unset($_from); ?>
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
        <a href="<?php echo $this->_tpl_vars['baseLink']; ?>
/?view=index&load=forgot" class="lostAccess">Забыли пароль</a>
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