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
                <li> - <a href="?view=admin_panel&load=content_panel&fnc=edit&type=content&id={$data->id}">{$data->description}</a></li>
                {/if}
            {/foreach}
            </ul>
        </div>
        <!--<div class="one-third column">
            <h4>Баннеры</h4>
            <ul>
            {foreach item=data from=$viewData.content}
                {if $data->type == 3}
                <li> - <a href="?view=admin_panel&load=content_panel&fnc=edit&type=content&id={$data->id}">{$data->description}</a></li>
                {/if}
            {/foreach}
            </ul>
        </div>-->
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

{include file='layout/footer.tpl'}