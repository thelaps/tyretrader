<h2>Восстановление доступа</h2>
<div class="widget forgot">
    <form action="{$baseLink}/?view=api&load=account" class="form">
        <input type="hidden" name="fnc" value="forgot">
        <p>Укажите email или логин для восстановления. На почту быдет выслан запрос с ссылкой на подтверждение</p>
        <hr>
        <div class="two-columns">
            <div>
                <table>
                    <tr>
                        <td><label for="email">Email</label></td>
                        <td><input type="text" id="email" name="email"/></td>
                    </tr>
                </table>
            </div>
            <div>
                <table>
                    <tr>
                        <td><label for="login">Логин</label></td>
                        <td><input type="text" id="login" name="login"/></td>
                    </tr>
                </table>
            </div>
        </div>
        <hr>
        <div class="row-submit">
            <button type="submit">Отправить запрос на восстановление</button>
        </div>
    </form>
</div>