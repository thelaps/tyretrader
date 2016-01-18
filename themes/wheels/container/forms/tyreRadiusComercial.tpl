<select class="jcf-ignore" id="{$id}" name="tyre[size_r][]" style="width: 76px;">
    {if $isAll}
        <option value="">Все</option>
    {/if}
    <option value="17.5">17,5</option>
    <option value="19.5">19.5</option>
    <option value="22.5"{if !$isAll} selected="selected"{/if}>22.5</option>
</select>