<div class="tab" data-role="tab">
    <form action="{$baseLink}/?view=api&load=opt" class="form form-order">
        <input type="hidden" name="fnc" value="opt">
        <input type="hidden" name="filter[manufacturer]" value="BT" class="filter-manufacturer">
        <input type="hidden" name="filter[model]" value="BT" class="filter-model">
        <input type="hidden" name="filter[stock_1]" value="TB" class="filter-stock_1">
        <input type="hidden" name="filter[date]" value="TB" class="filter-date">
        <input type="hidden" name="filter[price_1]" value="BT" class="filter-price_1">
        <input type="hidden" name="filter[sqlscopename]" value="BT" class="filter-sqlscopename">
        <input type="hidden" name="tyre[type_transport][]" value="3">
        <input type="hidden" name="tyre[type_transport][]" value="4">
        <input type="hidden" name="tyre[duo]" value="0">
        <div class="order-options">
            <div class="h-separator"></div>
            <div class="row tyre-options" data-name="product-type">
                <!-- Select brand -->
                <div class="area-brand">
                    <div class="row">
                        <div class="field align-left">
                            <label>Бренд</label>
                            <select name="tyre[manufacturer]" class="dataFilter jcf-ignore" data-filter="#modelTab_{$dataIndex}">
                                <!--Легковой 1, легкогрузовой 2, индустр 3, грузовой 4, мото 5-->
                                <option value="">Не выбран</option>
                            {foreach from=$viewData->container.formData->manufacturer.$dataIndex item=row}
                                {if $row->manufacturer_type=='tyre'}
                                    <option value="{$row->manufacturer_id}">{$row->manufacturer_name}</option>
                                {/if}
                            {/foreach}
                            </select>
                        </div>
                        <div class="field align-right">
                            <label>Модель</label>
                            <select class="jcf-ignore" id="modelTab_{$dataIndex}" name="tyre[model]">
                                <option value="">Не выбрана</option>
                            {foreach from=$viewData->container.formData->model.$dataIndex item=row}
                                {if $row->manufacturer_type=='tyre'}
                                    <option style="display: none;" data-manufacturer="{$row->manufacturer_id}" value="{$row->model_id}">{$row->model_name}</option>
                                {/if}
                            {/foreach}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="area-brand">
                    <div class="row">
                        <div class="field align-left">
                            <label>Город</label>
                            <select name="tyre[city]" class="cityFilter jcf-ignore" data-filter="#companyTab_{$dataIndex}">
                                <!--Легковой 1, легкогрузовой 2, индустр 3, грузовой 4, мото 5-->
                                <option value="">Все</option>
                            {foreach from=$viewData->container.formData->cities item=row}
                                <option value="{$row->id}">{$row->name}</option>
                            {/foreach}
                            </select>
                        </div>
                        <div class="field align-right">
                            <label>Поставщик</label>
                            <select class="jcf-ignore" id="companyTab_{$dataIndex}" name="tyre[company_id]">
                                <option value="">Все</option>
                            {foreach from=$viewData->container.formData->companies item=row}
                                <option data-city="{$row->capitalid}" value="{$row->id}">{$row->name} ({$row->city})</option>
                            {/foreach}
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Select type and size -->
                <div class="area-type">
                    <!-- Tyre options -->
                    <!--<div class="field">
                        <label>Сезон</label>
                        <ul class="opt-group justify" data-role="seasons">
                            <li>
                                <input type="checkbox" name="tyre[season][]" value="2" id="s_season-1"{if $viewData->container.class->whatSeason(2)} checked="checked"{/if}>
                                <label for="s_season-1">Летняя</label>
                            </li>
                            <li>
                                <input type="checkbox" name="tyre[season][]" value="1" id="s_season-2"{if $viewData->container.class->whatSeason(1)} checked="checked"{/if}>
                                <label for="s_season-2">Зимняя</label>
                            </li>
                            <li>
                                <input type="checkbox" name="tyre[season][]" value="3" id="s_season-3"{if $viewData->container.class->whatSeason(3)} checked="checked"{/if}>
                                <label for="s_season-3">Всесезонная</label>
                            </li>
                        </ul>
                    </div>-->
                    <div class="size-field">
                        <div>
                            <label for="s_t-axle">Тип оси</label>
                            <select id="s_t-axle" class="size-s jcf-ignore" name="tyre[axle]" style="width: 153px;">
                                <option value=""> - </option>
                                <option value="1">Рулевая</option>
                                <option value="2">Ведущая</option>
                                <option value="3">Прицепная</option>
                                <option value="4">Универсальная</option>
                            </select>
                        </div>
                        <div>
                            <label for="s_t-use">Назначение шины</label>
                            <select id="s_t-use" class="size-s jcf-ignore" name="tyre[use]" style="width: 153px;">
                                <option value=""> - </option>
                                <option value="1">Автобусы</option>
                                <option value="2">Сельхозтехника</option>
                                <option value="3">Индустриальное</option>
                                <option value="4">Магистральное</option>
                                <option value="5">Региональное</option>
                                <option value="6">Смешанное</option>
                                <option value="7">All Terrain</option>
                                <option value="8">Mud Terrain</option>
                            </select>
                        </div>
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
                        {include file="container/forms/tyreRadiusComercial.tpl" id="s_radial" isAll=true}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="order-submit">
            <button type="submit">Подобрать</button>
        </div>
    </form>
</div>