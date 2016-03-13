<h2>Регистрация</h2>
<div class="widget registration">
    <form action="{$baseLink}/?view=api&load=account" class="form">
        <input type="hidden" name="fnc" value="register">
        <input type="hidden" name="userType" value="1">
        <!--<ul class="opt-group select-user-type">
            <li>
                <input id="person" type="radio" name="userType" value="1" checked>
                <label for="person">Покупатель</label>
            </li>
            <li>
                <input id="store" type="radio" name="userType" value="2">
                <label for="store">Магазин</label>
            </li>
        </ul>
        <hr>-->
        <div class="two-columns">
            <div>
                <h3>Личные данные</h3>
                <table>
                    <tr>
                        <td><label for="fname">Имя</label></td>
                        <td><input type="text" id="fname" name="firstName"/></td>
                    </tr>
                    <tr>
                        <td><label for="lname">Фамилия</label></td>
                        <td><input type="text" id="lname" name="lastName"/></td>
                    </tr>
                    <tr>
                        <td><label for="email">Email</label></td>
                        <td><input type="email" id="email" name="email"/></td>
                    </tr>
                    <tr>
                        <td><label for="phone">Телефон</label></td>
                        <td><input type="text" id="phone" name="phone"/></td>
                    </tr>
                    <tr>
                        <td><label>Область</label></td>
                        <td>
                            <select name="regionId" class="cityFilter" data-filter="#homeCity">
                                <option value="">Все</option>
                                {foreach from=$viewData->container.city item=region}
                                    <option value="{$region.region->id}">{$region.region->name}</option>
                                {/foreach}
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Город</label></td>
                        <td>
                            <select name="cityId" class="cityFilter" id="homeCity">
                                <option value="">Все</option>
                                {foreach from=$viewData->container.city item=region}
                                    {foreach from=$region.cities item=cityofregion}
                                        <option{if $viewData->profile->user->cityid == $cityofregion->id} selected{/if} value="{$cityofregion->id}" data-city="{$cityofregion->region_id}">{$cityofregion->name}</option>
                                    {/foreach}
                                {/foreach}
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div>
                <h3>Данные для входа</h3>
                <table>
                    <tr>
                        <td><label for="u-login">Логин</label></td>
                        <td><input type="text" id="u-login" name="login"/></td>
                    </tr>
                    <tr>
                        <td><label for="u-password">Пароль</label></td>
                        <td><input type="password" id="u-password" name="pass"/></td>
                    </tr>
                    <tr>
                        <td><label for="u-password-confirm">Подтвердить</label></td>
                        <td><input type="password" id="u-password-confirm" name="confirm"/></td>
                    </tr>
                </table>
                <div class="user-agreement">
                    <input type="checkbox" id="agreement" name="agreement" value="1" />
                    <label for="agreement">Согласен с <a href="#">пользовательским соглашением</a></label>
                </div>
            </div>
        </div>
        <hr>
        <div class="row-submit">
            <button type="submit">ЗАРЕГИСТРИРОВАТЬСЯ</button>
        </div>
    </form>
</div>