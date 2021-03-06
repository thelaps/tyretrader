{if $viewData->profile->isLoggedin()}
{literal}
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
{/literal}
<div class="panel profile-panel">
    <div class="profile-info">
                    <span class="name">
                        <a href="{$baseLink}/?load=home">{$viewData->profile->user->firstname}.</a>
                    </span>
                    <span class="messages">
                        <span class="ico ico-email"></span>
                        <a href="{$baseLink}/?load=messages">(0)</a>
                    </span>
        <span class="balance">Баланс: <b>{$viewData->profile->user->balance}</b> грн.</span>
    </div>
    <div class="services">
        <select class="alt alterLocation">
            <option>Сервисы</option>
            <option value="{$baseLink}/?load=export">Экспорт прайс-листа</option>
            <option value="{$baseLink}/?load=analitycs">Аналитика</option>
            <option value="{$baseLink}/?load=calculator">Калькулятор цен</option>
            <option value="{$baseLink}/?load=viewsettings">Настройки отображения</option>
        </select>
        <form action="{$baseLink}/?view=api&load=account" class="inline-form">
            <input type="hidden" name="fnc" value="logout">
            <a class="link" type="submit" href="#">Выход</a>
        </form>
    </div>
    <ul id="nav" class="link-group">
        <li><a href="{$baseLink}/">Главная</a></li>
        <!--<li><a href="#">Покупка</a></li>
        <li><a href="{$baseLink}/?load=sold">Продажа</a></li>-->
        <li><a href="{$baseLink}/?load=opt">Опт</a></li>
        {if $viewData->profile->user->roleid == 2}<li><a href="{$baseLink}/?view=admin_panel&load=price_panel">Обработка прайсов</a></li>{/if}
        {if $viewData->x_entry}<li><a href="{$baseLink}/?view=admin_panel&load=user_panel" class="exitFromUser">Список пользователей</a></li>{/if}
        <!--<li><a href="#">Объявления</a></li>-->
    </ul>
</div>
<div class="currency-panel">
   Курс валют:
    {foreach item=currency from=$viewData->profile->currency}
        {$currency->iso} - {$currency->rate|number_format:2}
    {/foreach}
</div>
{else}
<div class="panel">
    <form action="{$baseLink}/?view=api&load=account" class="inline-form">
        <input type="hidden" name="fnc" value="auth">
        <label for="login-name">Логин:</label>
        <input type="text" name="login" id="login-name">
        <label for="password">Пароль:</label>
        <input type="password" name="pass" id="password">
        <input type="submit" value="Вход">
        <a href="{$baseLink}/?view=index&load=registration" class="registration">Регистрация</a>
        <a href="{$baseLink}/?view=index&load=forgot" class="lostAccess">Забыли пароль</a>
    </form>
    <ul id="nav" class="link-group align-right">
        <li><a href="{$baseLink}/">Главная</a></li>
        <!--<li><a href="#">Покупка</a></li>-->
        <li><a href="{$baseLink}/?load=sold">Продажа</a></li>
    </ul>
</div>
{/if}