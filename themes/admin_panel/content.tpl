{include file='layout/header.tpl'}
{include file='layout/menu.tpl'}



	<!-- Primary Page Layout
	================================================== -->

	<!-- Delete everything in this .container and get started on your own site! -->

    <div id="ajaxStatus">
        <span></span>
    </div>
	<div class="container">
        <div class="gridpanel">
            <div class="row widget_editor">
                <div class="panel scrollLayer">
                    <ul>
                {foreach item=data from=$viewData.content}
                        <li>
                            <p>{$data->title}</p>
                            <small>{if $data->type == 1}Системная страница{elseif $data->type == 2}Страница{elseif $data->type == 3}Баннер{/if}</small>
                        </li>
                {/foreach}
                    </ul>
                </div>
            </div>
        </div>

	</div><!-- container -->

{include file='layout/footer.tpl'}