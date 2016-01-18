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
                        <thead>
                            <tr>
                                <td>Роль пользов.</td>
                                <td>Тип пользов.</td>
                                <td>Имя</td>
                                <td>Фамилия</td>
                                <td>Балланс</td>
                                <td>Компания</td>
                                <td>Активирована до</td>
                                <td>Состояние</td>
                                <td>Действия</td>
                            </tr>
                        </thead>
                        {foreach item=user from=$viewData.users}
                        <tr>
                            <td class="drop_editable" data-id="{$user->id}" data-field="user.roleid">{if $user->roleid == 1}Пользователь{elseif $user->roleid == 2}Админ{else}Неизвестен{/if}</td>
                            <td>{if $user->usertype == 1}Пользователь{elseif $user->usertype == 2}Компания{elseif $user->usertype == 3}Поставщик{else}Неизвестен{/if}</td>
                            <td class="editable" data-id="{$user->id}" data-field="user.firstname">{$user->firstname}</td>
                            <td class="editable" data-id="{$user->id}" data-field="user.lastname">{$user->lastname}</td>
                            <td class="editable" data-id="{$user->id}" data-field="user.balance">{$user->balance}</td>
                            <td>{if $user->company_name != NULL}{$user->company_name} - ({$user->city_name}){else} - {/if}</td>
                            <td>{if $user->company_expire != NULL}{$user->company_expire}{else} - {/if}</td>
                            <td>{if $user->company_status != NULL}{if $user->company_status == 1}Включена{else}Отключена{/if}{else} - {/if}</td>
                            <td>
                                <a href="#" class="enterAsClient" data-id="{$user->id}"></a>
                                <a href="#" class="deleteClient" data-id="{$user->id}"></a>
                            </td>
                        </tr>
                        {/foreach}
                    </table>
                </div>
                <div class="panel">
                    Сейчас в сети: <b>{$viewData.statistics->online}</b><br/>
                    За сутки в сети: <b>{$viewData.statistics->last_day_online}</b>
                </div>
            </div>
        </div>

	</div><!-- container -->

{include file='layout/footer.tpl'}