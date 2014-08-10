{if $viewData->profile->isLoggedin()}
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
        <!--<li><a href="#">Объявления</a></li>-->
    </ul>
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
    </form>
    <ul id="nav" class="link-group align-right">
        <li><a href="{$baseLink}/">Главная</a></li>
        <!--<li><a href="#">Покупка</a></li>-->
        <li><a href="{$baseLink}/?load=sold">Продажа</a></li>
    </ul>
</div>
{/if}