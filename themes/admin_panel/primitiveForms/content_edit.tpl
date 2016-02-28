{include file='layout/header.tpl'}
{include file='layout/menu.tpl'}
<script src="{$src}/js/ckeditor/ckeditor.js"></script>
{if $viewData.content->type == 1 || $viewData.content->type == 2 }
{literal}
<script>
    $(document).ready(function(){
        CKEDITOR.replace('content_editor');
    });
</script>
{/literal}
{/if}
<div id="ajaxStatus">
    <span></span>
</div>
<div class="container">
    <div class="sixteen columns head">
        <h5>Редактирование {if $viewData._type == 'content'}{$viewData.content->description}{elseif $viewData._type == 'package'}{$viewData.content->title} {$viewData.content->cost}{/if}</h5>
        <hr />
    </div>
    <form action="{$baseLink}/?view=admin_panel&load=content_panel" method="POST" enctype="multipart/form-data" class="editableForm sixteen columns">
        <input type="hidden" name="fnc" value="{if $viewData.content->id != null}update{else}add{/if}">
        <input type="hidden" name="type" value="{$viewData._type}">
        {if $viewData.content->id != null}
            <input name="content[id]" type="hidden" value="{$viewData.content->id}">
        {/if}
        <ul>
            <li>
                <label>
                    <input name="content[status]" type="hidden" value="0">
                    <input name="content[status]" type="checkbox" {if $viewData.content->status == 1}checked {/if}value="1">
                    Активно?
                </label>
            </li>
        </ul>

    {if $viewData._type == 'content'}
        {if $viewData.content->type == 1 || $viewData.content->type == 2}
            <label>Заголовок</label>
            <input name="content[title]" type="text" value="{$viewData.content->title}">
            <label>Описание (метка для удобства)</label>
            <input name="content[description]" type="text" value="{$viewData.content->description}">
            <label>Основной текст</label>
            <textarea name="content[content]" id="content_editor">{$viewData.content->content}</textarea>
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
    {elseif $viewData._type == 'banner'}
        <label>Описание</label>
        <input name="content[description]" type="text" value="{$viewData.content->description}">
        <input type="hidden" name="content[type]" value="3">
        <ul>
            <li><label><input type="radio" value="image" name="content[subtype]" {if $viewData.content->subtype == 'image'} checked{/if}> Изображение</label></li>
            <li><label><input type="radio" value="code" name="content[subtype]" {if $viewData.content->subtype == 'code'} checked{/if}> Код (flash/javascript)*</label></li>
        </ul>
        <textarea name="content[content]" style="display: none;">{$viewData.content->content}</textarea>
        <textarea data-subtype="code" name="content[content]" id="content_editor" {if $viewData.content->subtype != 'code'} style="display: none;" disabled {/if}>{$viewData.content->content}</textarea>
        <label data-subtype="image"{if $viewData.content->subtype != 'image'} style="display: none;" disabled {/if}>Загрузить</label>
        <input data-subtype="image" name="banner_content" type="file"{if $viewData.content->subtype != 'image'} style="display: none;" disabled {/if}>
        <div class="clear"></div>
    <hr/>
    {/if}
        <button type="submit">Сохранить</button>
    </form>
</div>
{if $viewData._type == 'banner'}
{literal}
<script>
    function _handleBannerType(){
        var _subtype = $('[name="content[subtype]"]:checked').val();
        switch (_subtype){
            case 'image':
                CKEDITOR.instances['content_editor'].destroy();
                $('[data-subtype="code"]').attr('disabled', true).hide();
                $('[data-subtype="image"]').removeAttr('disabled');
                $('[data-subtype="image"]').show();
                break;
            case 'code':
                $('[data-subtype="image"]').attr('disabled', true).hide();
                $('[data-subtype="code"]').removeAttr('disabled');
                CKEDITOR.replace('content_editor');
                $('[data-subtype="code"]').show();
                break;
        }
    }
    $(document).ready(function(){
        _handleBannerType();

        $('[name="content[subtype]"]').bind({
            change: function(){
                _handleBannerType();
            }
        });
    });
</script>
{/literal}
{/if}
{include file='layout/footer.tpl'}