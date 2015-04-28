<div class="tab" data-role="tab">
    <form action="{$baseLink}/?view=api&load=account" class="form form-filter" enctype="multipart/form-data">
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
                            <input type="text" name="user[firstName]" value="{$viewData->profile->user->firstname}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Фамилия</label>
                        </div>
                        <div class="cell">
                            <input type="text" name="user[lastName]" value="{$viewData->profile->user->lastname}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Email</label>
                        </div>
                        <div class="cell">
                            <input type="text" name="user[email]" value="{$viewData->profile->user->email}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Телефон</label>
                        </div>
                        <div class="cell">
                            <input type="text" name="user[phone]" value="{$viewData->profile->user->phone}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Телефон опт.</label>
                        </div>
                        <div class="cell">
                            <input type="text" name="company[phone_1]" value="{$viewData->profile->company->items->phone_1}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Телефон розн.</label>
                        </div>
                        <div class="cell">
                            <input type="text" name="company[phone_2]" value="{$viewData->profile->company->items->phone_2}">
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
                            {foreach from=$viewData->container.city item=region}
                                <option value="{$region.region->id}">{$region.region->name}</option>
                            {/foreach}
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
                            {foreach from=$viewData->container.city item=region}
                                {foreach from=$region.cities item=cityofregion}
                                    <option{if $viewData->profile->user->cityid == $cityofregion->id} selected{/if} value="{$cityofregion->id}" data-city="{$cityofregion->region_id}">{$cityofregion->name}</option>
                                {/foreach}
                            {/foreach}
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
                            <label>Юридическое название</label>
                        </div>
                        <div class="cell">
                            <input type="text" name="company[name]" value='{$viewData->profile->company->items->name}'>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Физическое название</label>
                        </div>
                        <div class="cell">
                            <input type="text" name="company[shop_name]" value='{$viewData->profile->company->items->shop_name}'>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Свидетельство о регистрации</label>
                        </div>
                        <div class="cell">
                            <input type="text" name="company[certificate]" value="{$viewData->profile->company->items->certificate}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>URL (сайта)</label>
                        </div>
                        <div class="cell">
                            <input type="text" name="company[site]" value="{$viewData->profile->company->items->site}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Получать рассылку</label>
                        </div>
                        <div class="cell">
                            <input type="checkbox" name="user[subscribe]" value="1"{if $viewData->profile->user->subscribe == 1} checked{/if}>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Я являюсь поставщиком</label>
                        </div>
                        <div class="cell">
                            <input type="checkbox" name="user[userType]" value="3"{if $viewData->profile->user->usertype == 3} checked{/if}>
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
                            <textarea name="company[payment_details]" style="width: 572px;">{$viewData->profile->company->items->payment_details}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field two-cell align-right">
                        <div class="cell">
                            <label>Филиалы / Дистрибьюторы</label>
                        </div>
                        <div class="cell">
                            <textarea name="company[affiliates]" style="width: 572px;">{$viewData->profile->company->items->affiliates}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field two-cell align-right">
                        <div class="cell">
                            <label>Условия поставки / работы</label>
                        </div>
                        <div class="cell">
                            <textarea name="company[conditions]" style="width: 572px;">{$viewData->profile->company->items->conditions}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field two-cell align-right">
                        <div class="cell">
                            <label>Условия б / н рассчета</label>
                        </div>
                        <div class="cell">
                            <textarea name="company[noncache_conditions]" style="width: 572px;">{$viewData->profile->company->items->noncache_conditions}</textarea>
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
                            <input type="hidden" name="company[logo]" value="{$viewData->profile->company->items->logo}">
                            <input type="file" name="logo_raw">
                        </div>
                        <div class="cell">
                            <img style="height: 48px;" src="{$viewData->profile->company->items->getLogoUrl()}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit">Сохранить</button>
    </form>
</div>