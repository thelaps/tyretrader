<div class="widget_editor company_table">
    <button class="close">Закрыть</button>
    <button class="company_add" data-action="add">Добавить поставщика</button>
    <button class="company_delete" data-action="delete">Удалить поставщика</button>
    <fieldset>
        <legend>Список поставщиков v0.15a</legend>
        <div class="suggest">
            <i class="clearSuggest"></i>
            <input type="text" class="citySuggest" placeholder="Фильтр по городам">
            <div class="suggestList">
                <ul>
                    <li><a>test a</a></li>
                    <li><a>test a</a></li>
                    <li><a>test a</a></li>
                    <li><a>test a</a></li>
                    <li><a>test a</a></li>
                    <li><a>test a</a></li>
                </ul>
            </div>
        </div>
        <div class="scrollLayer">
            <table id="cityFilter">
            {foreach item=company from=$viewData.raw_companies key=key}
                <tr data-id="{$company->id}" data-name="{$company->name}" data-city="{$company->cityId}">
                    <td><input type="checkbox" value="{$company->id}"></td>
                    <td>{$company->id}</td>
                    <td>{$company->name}</td>
                    <td>{$company->city}</td>
                </tr>
            {/foreach}
            </table>
        </div>
    </fieldset>
</div>
<script>
    var haystack = {literal}{{/literal}
    {assign var="counter" value=0}
    {foreach item=region from=$viewData.city key=key}
        {foreach item=city from=$region}
                {if $counter!=0}, {/if}{$city->id}{literal}:{/literal}"{$city->name}"
            {assign var="counter" value=$counter+1}
        {/foreach}
    {/foreach}
    {literal}}{/literal};

    {literal}
    $(function(){
        $('.citySuggest').suggest(haystack,{
            onmatch:function(e){
                $('#cityFilter').find('tr:not([data-city="'+ e.id+'"])').hide();
            },onmismatch:function(){
                $('#cityFilter').find('tr').show();
            }
        });
    });
    {/literal}
</script>


<form action="?view=admin_panel&load=api_panel&fnc=add" class="widget_editor add_edit_company">
    <button class="close">Закрыть</button>
    <fieldset>
        <legend class="companyLegend">Добавить поставщика</legend>
        <input type="hidden" name="fnc" value="company">
        <input type="hidden" name="company[id]" value="">
        <input type="text" name="company[name]" value="" placeholder="Название компании">
                    <fieldset>
                        <legend>Регион</legend>
                        <select name="company[city_id]">
                        {foreach item=region from=$viewData.city key=key}
                            <optgroup label="{$key}">
                                {foreach item=city from=$region}
                                    <option value="{$city->id}">{$city->name}</option>
                                {/foreach}
                            </optgroup>
                        {/foreach}
                        </select>
                    </fieldset>
                    <fieldset>
                        <legend>Индивидуальный курс</legend>
                        <label>Валюта</label>
                        <select name="company[iso]">
                            <option selected disabled="true" value=""> - </option>
                            {foreach item=currencyRate from=$viewData.currencyRate.iso key=key}
                            <option value="{$currencyRate}">{$currencyRate}</option>
                            {/foreach}
                        </select>
                        <label>Значение курса</label>
                        <input type="text" name="company[rate]" placeholder="Пример: '1.0000'">
                    </fieldset>
        <button class="save">Сохранить</button>
    </fieldset>
</form>