<div class="widget">
    <form action="{$baseLink}/?view=api&load=opt" class="form form-filter">
        <input type="hidden" name="fnc" value="analitycs">
        <!--<input type="hidden" name="tyre[notcompany_id]" value="{$viewData->profile->user->companyid}">
        <input type="hidden" name="wheel[notcompany_id]" value="{$viewData->profile->user->companyid}">-->
        <div class="area-brand">
            <div class="field">
                <label>Вид</label>
                <ul class="opt-group" data-role="switcher" data-name="product-type">
                    <li>
                        <input id="tyre" data-target=".tyre-options" type="radio" name="product-type" value="tyre" checked>
                        <label for="tyre">Шины</label>
                    </li>
                    <li>
                        <input id="disc" data-target=".disc-options" type="radio" name="product-type" value="wheel">
                        <label for="disc">Диски</label>
                    </li>
                </ul>
            </div>
            <div class="row tyre-options" data-name="product-type">
                <div class="field align-left">
                    <label>Бренд</label>
                    <select name="tyre[manufacturer]" class="dataFilter" data-filter="#modelTab_1">
                        <!--Легковой 1, легкогрузовой 2, индустр 3, грузовой 4, мото 5-->
                        <option value="">Не выбран</option>
                        {foreach from=$viewData->container.formData->manufacturer.1 item=row}
                            {if $row->manufacturer_type=='tyre'}
                                <option value="{$row->manufacturer_id}">{$row->manufacturer_name}</option>
                            {/if}
                        {/foreach}
                    </select>
                </div>
                <div class="field align-right">
                    <label>Модель</label>
                    <select id="modelTab_1" name="tyre[model]">
                        <option value="">Не выбрана</option>
                        {foreach from=$viewData->container.formData->model.1 item=row}
                            {if $row->manufacturer_type=='tyre'}
                                <option style="display: none;" data-manufacturer="{$row->manufacturer_id}" value="{$row->model_id}">{$row->model_name}</option>
                            {/if}
                        {/foreach}
                    </select>
                </div>
            </div>
            <!-- Select brand -->
            <div class="row disc-options" data-name="product-type">
                <div class="field align-left">
                    <label>Бренд</label>
                    <select name="wheel[manufacturer]" class="dataFilter" data-filter="#modelTab_0">
                        <option value="">Не выбран</option>
                    {foreach from=$viewData->container.formData->manufacturer.0 item=row}
                        {if $row->manufacturer_type=='wheel'}
                            <option value="{$row->manufacturer_id}">{$row->manufacturer_name}</option>
                        {/if}
                    {/foreach}
                    </select>
                </div>
                <div class="field align-right">
                    <label>Модель</label>
                    <select id="modelTab_0" name="wheel[model]">
                        <option value="">Не выбрана</option>
                    {foreach from=$viewData->container.formData->model.0 item=row}
                        {if $row->manufacturer_type=='wheel'}
                            <option style="display: none;" data-manufacturer="{$row->manufacturer_id}" value="{$row->model_id}">{$row->model_name}</option>
                        {/if}
                    {/foreach}
                    </select>
                </div>
            </div>
        </div>
        <div class="area-type">
            <!-- Tyre options -->
            <div class="tyre-options" data-name="product-type">
                <div class="field">
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
                </div>
                <div class="size-field">
                    <div>
                        <label for="s_t-width">Ширина шины</label>
                        <!--<input id="s_t-width" class="size-s" type="text" name="tyre[size_w][]">-->
                    {include file="container/forms/tyreWidth.tpl" id="s_t-width"}
                    </div>
                    <span>/</span>
                    <div>
                        <label for="s_t-height">Высота шины</label>
                        <!--<input id="s_t-height" class="size-s" type="text" name="tyre[size_h][]">-->
                    {include file="container/forms/tyreHeight.tpl" id="s_t-height"}
                    </div>
                    <span>R</span>
                    <div>
                        <label for="s_radial">Диаметр</label>
                        <!--<input id="s_radial" class="size-s" type="text" name="tyre[size_r][]">-->
                    {include file="container/forms/tyreRadius.tpl" id="s_radial"}
                    </div>
                </div>
            </div>

            <div class="disc-options" data-name="product-type">
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
        <div class="buttons-set">
            <button type="reset">ОЧИСТИТЬ</button>
            <button type="submit">ПОКАЗАТЬ</button>
        </div>
    </form>
</div>