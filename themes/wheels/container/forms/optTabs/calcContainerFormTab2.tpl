<div class="tab" data-role="tab">
    <form action="{$baseLink}/?view=api&load=calculator" class="form form-filter">
        <input type="hidden" name="fnc" value="addMargin">
        <input type="hidden" name="calculator[id]" value="">
        <input type="hidden" name="calculator[type]" value="retail">
        <div class="row">
            <div class="area-brand">
                <div class="row">
                    <div class="field align-left">
                        <label>Бренд</label>
                        <select name="calculator[manufacturer_id]" class="dataFilter" data-filter="#modelTab_{$dataIndex}">
                            <!--Легковой 1, легкогрузовой 2, индустр 3, грузовой 4, мото 5-->
                            <option value="">Не выбран</option>
                        {foreach from=$viewData->container.formData->manufacturer item=row}
                            {if $row->manufacturer_type=='tyre'}
                                <option value="{$row->manufacturer_id}">{$row->manufacturer_name}</option>
                            {/if}
                        {/foreach}
                        </select>
                    </div>
                    <div class="field align-right">
                        <label>Модель</label>
                        <select id="modelTab_{$dataIndex}" name="calculator[model_id]">
                            <option value="">Не выбрана</option>
                        {foreach from=$viewData->container.formData->model item=row}
                            {if $row->manufacturer_type=='tyre'}
                                <option style="display: none;" data-manufacturer="{$row->manufacturer_id}" value="{$row->model_id}">{$row->model_name}</option>
                            {/if}
                        {/foreach}
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-left">
                        <label>Город</label>
                        <select name="calculator[city_id]" class="cityFilter" data-filter="#companyTab_{$dataIndex}">
                            <!--Легковой 1, легкогрузовой 2, индустр 3, грузовой 4, мото 5-->
                            <option value="">Все</option>
                        {foreach from=$viewData->container.formData->cities item=row}
                            <option value="{$row->region_id}">{$row->name}</option>
                        {/foreach}
                        </select>
                    </div>
                    <div class="field align-right">
                        <label>Поставщик</label>
                        <select id="companyTab_{$dataIndex}" name="calculator[company_id]">
                            <option value="">Все</option>
                        {foreach from=$viewData->container.formData->companies item=row}
                            <option data-city="{$row->regionid}" value="{$row->id}">{$row->name} ({$row->city})</option>
                        {/foreach}
                        </select>
                    </div>
                </div>
            </div>
            <div class="area-type">
                <div class="field">
                    <label>Сезон</label>
                    <ul class="opt-group justify" data-role="seasons">
                        <li>
                            <input type="checkbox" name="calculator[season]" value="2" id="s_season-1"{if $viewData->container.class->whatSeason(2)} checked="checked"{/if}>
                            <label for="s_season-1">Летняя</label>
                        </li>
                        <li>
                            <input type="checkbox" name="calculator[season]" value="1" id="s_season-2"{if $viewData->container.class->whatSeason(1)} checked="checked"{/if}>
                            <label for="s_season-2">Зимняя</label>
                        </li>
                        <li>
                            <input type="checkbox" name="calculator[season]" value="3" id="s_season-3"{if $viewData->container.class->whatSeason(3)} checked="checked"{/if}>
                            <label for="s_season-3">Всесезонная</label>
                        </li>
                    </ul>
                </div>
                <div class="size-field">
                    <div>
                        <label for="s_t-width">Ширина шины</label>
                        <!--<input id="s_t-width" class="size-s" type="text" name="tyre[size_w][]">-->
                        {include file="container/forms/tyreWidth.tpl" id="s_t-width" isAll=true}
                    </div>
                    <span>/</span>
                    <div>
                        <label for="s_t-height">Высота шины</label>
                        <!--<input id="s_t-height" class="size-s" type="text" name="tyre[size_h][]">-->
                        {include file="container/forms/tyreHeight.tpl" id="s_t-height" isAll=true}
                    </div>
                    <span>R</span>
                    <div>
                        <label for="s_radial">Диаметр</label>
                        <!--<input id="s_radial" class="size-s" type="text" name="tyre[size_r][]">-->
                        {include file="container/forms/tyreRadius.tpl" id="s_radial" isAll=true}
                    </div>
                </div>
            </div>
            <div class="buttons-set">
                <button type="reset">ОЧИСТИТЬ</button>
                <button type="submit">СОХРАНИТЬ</button>
            </div>
        </div>
        <hr>
        <div class="price-calc size-field">
            <div>
                <label>Процент</label>
                <input name="calculator[percentage]" class="size-s" type="text">
            </div>
            <div>
                <label>Разброс цен</label>
                <input name="calculator[min_cost]" class="size-m" type="text">
                <span>до</span>
                <input name="calculator[max_cost]" class="size-m" type="text">
            </div>
            <div>
                <label>Фикс. значение</label>
                <input name="calculator[fixed_cost]" class="size-m" type="text">
            </div>
            <div class="group">
                <div>
                    <label>Не менее</label>
                    <input name="calculator[not_less]" class="size-m" type="text">
                </div>
                <div>
                    <label>Не более</label>
                    <input name="calculator[not_more]" class="size-m" type="text">
                </div>
            </div>
            <div>
                <label>Доставка</label>
                <input name="calculator[shipping]" class="size-s" type="text">
            </div>
            <div>
                <label>Перевод</label>
                <input name="calculator[transfer]" class="size-s" type="text">
            </div>
            <div>
                <label>Банк. расходы</label>
                <input name="calculator[bank]" class="size-m" type="text">
            </div>
        </div>
    </form>
</div>
<!--<div class="tab" data-role="tab">
    <form action="#" class="form form-filter">
        <div class="row">
            <div class="area-brand">
                <div class="row">
                    <div class="field align-left">
                        <label>Поставщик</label>
                        <select>
                            <option value="">Все</option>
                            <option value="">Поставщик 1</option>
                            <option value="">Поставщик 2</option>
                            <option value="">Поставщик 3</option>
                        </select>
                    </div>
                    <div class="field align-right">
                        <label>Модель</label>
                        <select>
                            <option>Все</option>
                            <option>model 1</option>
                            <option>model 2</option>
                            <option>model 3</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-left">
                        <label>Модель</label>
                        <select>
                            <option>Все</option>
                            <option>model 1</option>
                            <option>model 2</option>
                            <option>model 3</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="area-type">
                <div class="field">
                    <label>Сезон</label>
                    <ul class="opt-group justify">
                        <li>
                            <input type="checkbox" name="disc-type" id="s_season-1">
                            <label for="s_season-1">Летняя</label>
                        </li>
                        <li>
                            <input type="checkbox" name="disc-type" id="s_season-2">
                            <label for="s_season-2">Зимняя</label>
                        </li>
                        <li>
                            <input type="checkbox" name="disc-type" id="s_season-3">
                            <label for="s_season-3">Всесезонная</label>
                        </li>
                    </ul>
                </div>
                <div class="size-field">
                    <div>
                        <label for="t-width-2">Ширина шины</label>
                        <input id="t-width-2" class="size-s" type="text">
                    </div>
                    <span>/</span>
                    <div>
                        <label for="t-height-2">Высота шины</label>
                        <input id="t-height-2" class="size-s" type="text">
                    </div>
                    <span>R</span>
                    <div>
                        <label for="radial-2">Диаметр</label>
                        <input id="radial-2" class="size-s" type="text">
                    </div>
                </div>
            </div>
            <div class="buttons-set">
                <button type="reset">ОЧИСТИТЬ</button>
                <button type="submit">ПОКАЗАТЬ</button>
            </div>
        </div>
        <hr>
        <div class="price-calc size-field">
            <div>
                <label>Процент</label>
                <input class="size-s" type="text">
            </div>
            <div>
                <label>Разброс цен</label>
                <input class="size-m" type="text">
                <span>до</span>
                <input class="size-m" type="text">
            </div>
            <div>
                <label>Фикс. значение</label>
                <input class="size-m" type="text">
            </div>
            <div class="group">
                <div>
                    <label>Не менее</label>
                    <input class="size-m" type="text">
                </div>
                <div>
                    <label>Не более</label>
                    <input class="size-m" type="text">
                </div>
            </div>
            <div>
                <label>Доставка</label>
                <input class="size-s" type="text">
            </div>
            <div>
                <label>Перевод</label>
                <input class="size-s" type="text">
            </div>
            <div>
                <label>Банк. расходы</label>
                <input class="size-m" type="text">
            </div>
        </div>
    </form>
</div>-->