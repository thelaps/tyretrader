<div class="widget_editor locations_table">
    <button class="close">Закрыть</button>
    <button class="locations_add" data-action="add">Добавить нас. пункт</button>
    <button class="locations_delete" data-action="delete">Удалить нас. пункт</button>
    <fieldset>
        <legend>Список населенных пунктов v0.12a</legend>
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

<form action="?view=admin_panel&load=api_panel&fnc=add" class="widget_editor add_edit_locations">
    <button class="close">Закрыть</button>
    <fieldset>
        <legend class="locationsLegend">Добавить населенный пункт</legend>
        <input type="hidden" name="fnc" value="locations">
        <input type="hidden" name="locations[id]" value="">
        <input type="text" name="locations[name]" value="" placeholder="Город">
        <label>Регион</label>
        <select name="locations[region_id]">
        {foreach item=locations from=$viewData.city key=key}
            <option value="{$locations.0->region_id}">{$key}</option>
        {/foreach}
        </select>
        <button class="save">Сохранить</button>
    </fieldset>
</form>