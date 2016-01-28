{include file='layout/header.tpl'}
{include file='layout/menu.tpl'}
<div id="ajaxStatus">
    <span></span>
</div>
<div class="container">
    <div class="sixteen columns head">
        <h5>Редактирование {if $viewData._type == 'content'}{$viewData.content->description}{elseif $viewData._type == 'package'}{$viewData.content->title} {$viewData.content->cost}{/if}</h5>
        <hr />
    </div>
    <form action="{$baseLink}/?view=admin_panel&load=content_panel" method="POST" class="editableForm sixteen columns">
        <input type="hidden" name="fnc" value="{if $viewData.content->id != null}update{else}add{/if}">
        <input type="hidden" name="type" value="{$viewData._type}">
        {if $viewData.content->id != null}
            <input name="content[id]" type="hidden" value="{$viewData.content->id}">
        {/if}
        <label>Активно?</label>
        <input name="content[status]" type="checkbox" {if $viewData.content->status == 1}checked {/if}value="1">

    {if $viewData._type == 'content'}
        {if $viewData.content->type == 1 || $viewData.content->type == 2}
            <label>Заголовок</label>
            <input name="content[title]" type="text" value="{$viewData.content->title}">
            <label>Описание (метка для удобства)</label>
            <input name="content[description]" type="text" value="{$viewData.content->description}">
            <label>Основной текст</label>
            <textarea name="content[content]">{$viewData.content->content}</textarea>
            <label>META Title</label>
            <input name="content[meta_title]" type="text" value="{$viewData.content->meta_title}">
            <label>META Keywords</label>
            <input name="content[meta_keywords]" type="text" value="{$viewData.content->meta_keywords}">
            <label>META Description</label>
            <input name="content[meta_description]" type="text" value="{$viewData.content->meta_description}">
        {/if}
        {if $viewData.content->type == 4}
            <label>Описание (метка для удобства)</label>
            <input name="content[description]" type="text" value="{$viewData.content->description}">
            <label>Данные блока</label>
            <textarea name="content[content]">{$viewData.content->content}</textarea>
        {/if}
    {elseif $viewData._type == 'package'}
        <label>Стоимость</label>
        <input name="content[cost]" type="text" value="{$viewData.content->cost}">
        <label>Срок мес.</label>
        <input name="content[amount]" type="text" value="{$viewData.content->amount}">
        <label>Название</label>
        <input name="content[title]" type="text" value="{$viewData.content->title}">
        <label>Описание</label>
        <textarea name="content[description]">{$viewData.content->description}</textarea>
    {/if}
        <button type="submit">OK</button>
    </form>
</div>

{include file='layout/footer.tpl'}