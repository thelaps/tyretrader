{include file='layout/header.tpl'}
{include file='layout/menu.tpl'}



	<!-- Primary Page Layout
	================================================== -->

	<!-- Delete everything in this .container and get started on your own site! -->

    <div id="ajaxStatus">
        <span></span>
    </div>
	<div class="container">
        <div class="one-third column">
            <h4>Страницы системные</h4>
            <ul>
            {foreach item=data from=$viewData.content}
                {if $data->type == 1}
                <li> - <a href="?view=admin_panel&load=content_panel&fnc=edit&type=content&id={$data->id}">{$data->description}</a></li>
                {/if}
            {/foreach}
            </ul>
        </div>
        <div class="one-third column">
            <h4>Страницы</h4>
            <ul>
            {foreach item=data from=$viewData.content}
                {if $data->type == 2}
                <li> - <a href="?view=admin_panel&load=content_panel&fnc=edit&type=content&id={$data->id}">{$data->description}</a> <a class="confirmRemove" style="color: #ac1c36;" href="?view=admin_panel&load=content_panel&fnc=delete&type=content&id={$data->id}">[Удалить]</a></li>
                {/if}
            {/foreach}
            </ul>
            <a class="button" href="?view=admin_panel&load=content_panel&fnc=edit&type=content">Добавить</a>
        </div>
        <div class="one-third column">
            <h4>Баннеры</h4>
            <ul>
            {foreach item=data from=$viewData.content}
                {if $data->type == 3}
                <li> - <a href="?view=admin_panel&load=content_panel&fnc=edit&type=banner&id={$data->id}">{$data->description}</a></li>
                {/if}
            {/foreach}
            </ul>
        </div>
        <div class="one-third column">
            <h4>Текст</h4>
            <ul>
            {foreach item=data from=$viewData.content}
                {if $data->type == 4}
                <li> - <a href="?view=admin_panel&load=content_panel&fnc=edit&type=content&id={$data->id}">{$data->description}</a></li>
                {/if}
            {/foreach}
            </ul>
        </div>
        <div class="one-third column">
            <h4>Тарифные планы</h4>
            <ul>
            {foreach item=data from=$viewData.packages}
                    <li> - <a href="?view=admin_panel&load=content_panel&fnc=edit&type=package&id={$data->id}">{$data->title} {$data->cost}</a></li>
            {/foreach}
            </ul>
        </div>

	</div><!-- container -->
{literal}
<script>
    $(document).ready(function(){
        $('.confirmRemove').each(function(){
            $(this).bind({
                click: function(e){
                    return (confirm('Удалить запись?'));
                }
            });
        });
    });
</script>
{/literal}
{include file='layout/footer.tpl'}