<div class="widget_editor currencyRate_table">
    <button class="close">Закрыть</button>
    <button class="currencyRate_add" data-action="add">Добавить курс</button>
    <button class="currencyRate_delete" data-action="delete">Удалить курс</button>
    <fieldset>
        <legend>Список курса валют v0.13a</legend>
        <div class="scrollLayer">
            <table>
            {*foreach item=locations from=$viewData.city key=key}
                <tr class="exclude">
                    <td colspan="3">{$key}</td>
                </tr>
                {foreach item=city from=$locations key=key}
                <tr data-id="{$city->id}" data-name="{$city->name}">
                    <td><input type="checkbox" value="{$city->id}"></td>
                    <td>{$city->name}</td>
                    <td>{$city->phone_code}</td>
                </tr>
                {/foreach}
            {/foreach*}
            </table>
        </div>
    </fieldset>
</div>

<form action="?view=admin_panel&load=api_panel&fnc=add" class="widget_editor add_edit_currencyRate">
    <button class="close">Закрыть</button>
    <fieldset>
        <legend class="currencyRateLegend">Добавить курс валют</legend>
        <input type="hidden" name="fnc" value="currencyRate">
        <input type="text" name="currencyRate[rate]" value="" placeholder="Курс">
        <label>Валюта</label>
        <select name="currencyRate[iso]">
            <option selected disabled="true" value=""> - </option>
        {foreach item=currencyRate from=$viewData.currencyRate.iso key=key}
            <option value="{$currencyRate}">{$currencyRate}</option>
        {/foreach}
        </select>
        <button class="save">Сохранить</button>
    </fieldset>
</form>