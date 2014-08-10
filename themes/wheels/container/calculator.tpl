<div id="main" data-role="main">
<h2>Калькулятор цен</h2>
<div class="tab-widget" data-role="tabs">
<ul>
    <li class="active">
        Оптовые цены
    </li>
    <li>
        Розничные цены
    </li>
</ul>
<div class="tabs-holder">
{include file="container/forms/optTabs/calcContainerFormTab1.tpl" dataIndex=1}
{include file="container/forms/optTabs/calcContainerFormTab2.tpl" dataIndex=2}
</div>
</div>
<div class="block wide">
    <table class="table price-grid">
        <thead>
        <tr>
            <th class="col-id">ID</th>
            <th class="col-provider"><!--<div class="sortable desc">-->ПОСТАВЩИК<!--</div>--></th>
            <th class="col-brand"><!--<div class="sortable asc">-->БРЕНД<!--</div>--></th>
            <th>РАЗБРОС ЦЕН</th>
            <th>ПРОЦЕНТ</th>
            <th>Ф. ЗНАЧ.</th>
            <th>НЕ МЕНЕЕ</th>
            <th>НЕ БОЛЕЕ</th>
            <th>ДОСТАВКА</th>
            <th>ПЕРВОД</th>
            <th>БАНК</th>
            <th>ИЗМЕНИТЬ</th>
            <th>УДАЛИТЬ</th>
        </tr>
        </thead>
        <tbody>
        {foreach from=$viewData->container.listItems->items item=row}
        <tr>
            <td class="col-id">{$row->id}</td>
            <td class="col-provider"><a href="#">{$row->company}</a></td>
            <td class="col-brand">{$row->manufacturer}</td>
            <td>{$row->min_cost}-{$row->max_cost}</td>
            <td>{$row->percentage}%</td>
            <td>{$row->fixed_cost}</td>
            <td>{$row->not_less}</td>
            <td>{$row->not_more}</td>
            <td>{$row->shipping}</td>
            <td>{$row->transfer}</td>
            <td>{$row->bank}</td>
            <td><button type="button" class="edit margin-edit" data-id="{$row->id}">edit</button></td>
            <td><button type="button" class="delete margin-delete" data-id="{$row->id}">delete</button></td>
        </tr>
        {/foreach}
        </tbody>
    </table>
</div>

</div>