<div id="main" data-role="main">
    <h2>Пакет: {$viewData->container.package->title}</h2>
    <div class="widget">
        <form method="post" action="{$baseLink}/?view=api&load=paymentcenter" class="form">
            <input type="hidden" name="fnc" value="buyPackage">
            <input type="hidden" name="sku" value="{$viewData->container.package->sku}">
            <input type="hidden" name="id" value="{$viewData->container.package->id}">
            <h5>
            {$viewData->container.package->description}
            </h5>
            <h5>Стоимость: {$viewData->container.package->cost|number_format:2}грн. / {if $viewData->container.package->amount > 0}{$viewData->container.package->amount}{else}1{/if}мес.</h5>
            <hr>
            <div class="row-submit">
                <button type="submit">Оплатить в счет балланса</button>
            </div>
        </form>
    </div>
</div>