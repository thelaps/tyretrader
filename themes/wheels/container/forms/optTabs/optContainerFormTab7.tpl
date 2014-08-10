<div class="tab" data-role="tab">
    <form action="{$baseLink}/?view=api&load=opt" class="form form-order">
        <input type="hidden" name="fnc" value="opt">
        <input type="hidden" name="filter[manufacturer]" value="BT" class="filter-manufacturer">
        <input type="hidden" name="filter[model]" value="BT" class="filter-model">
        <input type="hidden" name="filter[stock_1]" value="TB" class="filter-stock_1">
        <input type="hidden" name="filter[date]" value="TB" class="filter-date">
        <input type="hidden" name="filter[price_1]" value="BT" class="filter-price_1">
        <input type="hidden" name="filter[sqlscopename]" value="BT" class="filter-sqlscopename">
        <input type="hidden" name="wheel[type_transport]" value="{$dataIndex}">
        <div class="order-options">
            <div class="h-separator"></div>
            <div class="row disc-options" data-name="product-type">
                <!-- Select brand -->
                <div class="area-brand">
                    <div class="row">
                        <div class="field align-left">
                            <label>Бренд</label>
                            <select name="wheel[manufacturer]" class="dataFilter" data-filter="#modelTab_{$dataIndex}">
                                <option value="">Не выбран</option>
                            {foreach from=$viewData->container.formData->manufacturer.$dataIndex item=row}
                                {if $row->manufacturer_type=='wheel'}
                                    <option value="{$row->manufacturer_id}">{$row->manufacturer_name}</option>
                                {/if}
                            {/foreach}
                            </select>
                        </div>
                        <div class="field align-right">
                            <label>Модель</label>
                            <select id="modelTab_{$dataIndex}" name="wheel[model]">
                                <option value="">Не выбрана</option>
                            {foreach from=$viewData->container.formData->model.$dataIndex item=row}
                                {if $row->manufacturer_type=='wheel'}
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
                            <select name="wheel[city]" class="cityFilter" data-filter="#companyTab_{$dataIndex}">
                                <!--Легковой 1, легкогрузовой 2, индустр 3, грузовой 4, мото 5-->
                                <option value="">Все</option>
                            {foreach from=$viewData->container.formData->cities item=row}
                                <option value="{$row->id}">{$row->name}</option>
                            {/foreach}
                            </select>
                        </div>
                        <div class="field align-right">
                            <label>Поставщик</label>
                            <select id="companyTab_{$dataIndex}" name="wheel[company_id]">
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
                    <!-- Disc options -->
                    <div class="field">
                        <label>Тип диска</label>
                        <ul class="opt-group justify">
                            <li>
                                <input type="checkbox" name="wheel[wheel_type]" value="1" id="s_type-1">
                                <label for="s_type-1">Стальной</label>
                            </li>
                            <li>
                                <input type="checkbox" name="wheel[wheel_type]" value="2" id="s_type-2">
                                <label for="s_type-2">Литой</label>
                            </li>
                            <li>
                                <input type="checkbox" name="wheel[wheel_type]" value="3" id="s_type-3">
                                <label for="s_type-3">Кованный</label>
                            </li>
                            <!--<li>
                                <input type="checkbox" name="wheel[wheel_type]" value="4" id="s_type-4">
                                <label for="s_type-4">Составной</label>
                            </li>-->
                        </ul>
                    </div>
                    <div class="size-field">
                        <div>
                            <label for="s_width">Ширина диска</label>
                            <!--<input id="s_width" class="size-s" type="text" name="wheel[size_w][]">-->
                            {include file="container/forms/wheelWidth.tpl" id="s_width"}
                        </div>
                        <span>/</span>
                        <div>
                            <label for="s_fixture">Крепеж диска</label>
                            <!--<input id="s_fixture" class="size-s" type="text" name="wheel[et][]">-->
                            {include file="container/forms/wheelEt.tpl" id="s_fixture"}
                        </div>
                        <span>x</span>
                        <div>
                            <label for="s_pcd">PCD</label>
                            <!--<input id="s_pcd" class="size-s" type="text" name="wheel[pcd][]">-->
                            {include file="container/forms/wheelPcd.tpl" id="s_pcd"}
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