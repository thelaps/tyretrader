<select id="{$id}" name="tyre[size_r][]" style="width: 76px;">
    {if $isAll}
        <option value="">Все</option>
    {/if}
    <option value="13">13c</option>
    <option value="14">14c</option>
    <option value="15">15c</option>
    <option value="16"{if !$isAll} selected="selected"{/if}>16c</option>
</select>