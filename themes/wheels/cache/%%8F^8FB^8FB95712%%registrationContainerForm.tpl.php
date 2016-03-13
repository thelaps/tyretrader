<?php /* Smarty version 2.6.26, created on 2016-03-12 20:19:36
         compiled from container/forms/registrationContainerForm.tpl */ ?>
<h2>Регистрация</h2>
<div class="widget registration">
    <form action="<?php echo $this->_tpl_vars['baseLink']; ?>
/?view=api&load=account" class="form">
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
                                <?php $_from = $this->_tpl_vars['viewData']->container['city']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['region']):
?>
                                    <option value="<?php echo $this->_tpl_vars['region']['region']->id; ?>
"><?php echo $this->_tpl_vars['region']['region']->name; ?>
</option>
                                <?php endforeach; endif; unset($_from); ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Город</label></td>
                        <td>
                            <select name="cityId" class="cityFilter" id="homeCity">
                                <option value="">Все</option>
                                <?php $_from = $this->_tpl_vars['viewData']->container['city']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['region']):
?>
                                    <?php $_from = $this->_tpl_vars['region']['cities']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cityofregion']):
?>
                                        <option<?php if ($this->_tpl_vars['viewData']->profile->user->cityid == $this->_tpl_vars['cityofregion']->id): ?> selected<?php endif; ?> value="<?php echo $this->_tpl_vars['cityofregion']->id; ?>
" data-city="<?php echo $this->_tpl_vars['cityofregion']->region_id; ?>
"><?php echo $this->_tpl_vars['cityofregion']->name; ?>
</option>
                                    <?php endforeach; endif; unset($_from); ?>
                                <?php endforeach; endif; unset($_from); ?>
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