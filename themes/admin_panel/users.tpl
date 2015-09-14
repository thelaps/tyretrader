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
                    <table>
                        {foreach item=user from=$viewData.users}
                        <tr>
                            <td>{$user->name}</td>
                            <td>{$user->firstname}</td>
                            <td>{$user->lastname}</td>
                            <td>{$user->balance}</td>
                        </tr>
                        {/foreach}
                    </table>
                </div>
            </div>
        </div>

	</div><!-- container -->

{include file='layout/footer.tpl'}