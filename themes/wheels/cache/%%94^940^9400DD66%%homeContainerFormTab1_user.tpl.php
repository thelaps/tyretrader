<?php /* Smarty version 2.6.26, created on 2016-01-20 05:57:32
         compiled from container/forms/homeTabs/homeContainerFormTab1_user.tpl */ ?>
<div class="tab" data-role="tab">
    <form action="<?php echo $this->_tpl_vars['baseLink']; ?>
/?view=api&load=account" class="form form-filter" enctype="multipart/form-data">
        <input type="hidden" name="fnc" value="changeAccount">
        <div class="row row-table">
            <div class="area-cell">
                <h4>Мои данные</h4>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Имя</label>
                        </div>
                        <div class="cell">
                            <input type="text" name="user[firstName]" value="<?php echo $this->_tpl_vars['viewData']->profile->user->firstname; ?>
">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Фамилия</label>
                        </div>
                        <div class="cell">
                            <input type="text" name="user[lastName]" value="<?php echo $this->_tpl_vars['viewData']->profile->user->lastname; ?>
">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Email</label>
                        </div>
                        <div class="cell">
                            <input type="text" name="user[email]" value="<?php echo $this->_tpl_vars['viewData']->profile->user->email; ?>
">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Телефон</label>
                        </div>
                        <div class="cell">
                            <input type="text" name="user[phone]" value="<?php echo $this->_tpl_vars['viewData']->profile->user->phone; ?>
">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Телефон опт.</label>
                        </div>
                        <div class="cell">
                            <input type="text" name="company[phone_1]" value="" disabled="true" class="accountChanger">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Телефон розн.</label>
                        </div>
                        <div class="cell">
                            <input type="text" name="company[phone_2]" value="" disabled="true" class="accountChanger">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Область</label>
                        </div>
                        <div class="cell">
                            <select name="user[regionId]" class="cityFilter" data-filter="#homeCity">
                                <option value="">Все</option>
                            <?php $_from = $this->_tpl_vars['viewData']->container['city']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['region']):
?>
                                <option value="<?php echo $this->_tpl_vars['region']['region']->id; ?>
"><?php echo $this->_tpl_vars['region']['region']->name; ?>
</option>
                            <?php endforeach; endif; unset($_from); ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Город</label>
                        </div>
                        <div class="cell">
                            <select name="user[cityId]" class="cityFilter" id="homeCity">
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
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Текущий пароль</label>
                        </div>
                        <div class="cell">
                            <input type="password" name="user[pass]" value="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Новый пароль</label>
                        </div>
                        <div class="cell">
                            <input type="password" name="user[new_pass]" value="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Подтвердить пароль</label>
                        </div>
                        <div class="cell">
                            <input type="password" name="user[confirm]" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="area-cell">
                <h4>Дополнительная информация</h4>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label style="font-weight: bold; color: #678C59;">Юридическое название</label>
                        </div>
                        <div class="cell">
                            <input title="«Название фирмы, которое будет отображено на сайте»" type="text" name="company[name]" value="" disabled="true" class="accountChanger tooltip">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Физическое название</label>
                        </div>
                        <div class="cell">
                            <input type="text" name="company[shop_name]" value="" disabled="true" class="accountChanger">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Свидетельство о регистрации</label>
                        </div>
                        <div class="cell">
                            <input type="text" name="company[certificate]" value="" disabled="true" class="accountChanger">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>URL (сайта)</label>
                        </div>
                        <div class="cell">
                            <input type="text" name="company[site]" value="" disabled="true" class="accountChanger">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Получать рассылку</label>
                        </div>
                        <div class="cell">
                            <input type="checkbox" name="user[subscribe]" value="1"<?php if ($this->_tpl_vars['viewData']->profile->user->subscribe == 1): ?> checked<?php endif; ?>>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Я являюсь поставщиком</label>
                        </div>
                        <div class="cell">
                            <input type="checkbox" name="user[userType]" onchange="prepareUserToChangeType(this)" value="3"<?php if ($this->_tpl_vars['viewData']->profile->user->usertype == 3): ?> checked<?php endif; ?>>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-table">
            <div class="area-cell area-one-cell">
                <div class="row">
                    <div class="field two-cell align-right">
                        <div class="cell">
                            <label>Платежные реквизиты</label>
                        </div>
                        <div class="cell">
                            <textarea name="company[payment_details]" style="width: 572px;" disabled="true" class="accountChanger"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field two-cell align-right">
                        <div class="cell">
                            <label>Филиалы / Дистрибьюторы</label>
                        </div>
                        <div class="cell">
                            <textarea name="company[affiliates]" style="width: 572px;" disabled="true" class="accountChanger"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field two-cell align-right">
                        <div class="cell">
                            <label>Условия поставки / работы</label>
                        </div>
                        <div class="cell">
                            <textarea name="company[conditions]" style="width: 572px;" disabled="true" class="accountChanger"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field two-cell align-right">
                        <div class="cell">
                            <label>Условия б / н рассчета</label>
                        </div>
                        <div class="cell">
                            <textarea name="company[noncache_conditions]" style="width: 572px;" disabled="true" class="accountChanger"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-table">
            <div class="area-cell area-one-cell">
                <h4>Графическая информация</h4>
                <div class="row">
                    <div class="field two-cell align-right">
                        <div class="cell">
                            <label>Текущий логотип</label>
                            <input type="hidden" name="company[logo]" value="" disabled="true" class="accountChanger">
                            <input type="file" name="logo_raw" disabled="true" class="accountChanger">
                        </div>
                        <div class="cell">
                            <img style="height: 48px;" src="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit">Сохранить</button>
    </form>
</div>