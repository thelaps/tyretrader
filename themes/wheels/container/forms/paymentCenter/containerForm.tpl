<div id="main" data-role="main">
    <h2>Пакет: {$viewData->container.package->title}</h2>
    <div class="widget">
        <form action="{$baseLink}/?view=api&load=paymentcenter" class="form">
            <input type="hidden" name="fnc" value="buyPackage">
            <input type="hidden" name="sku" value="{$viewData->container.package->sku}">
            <h5>
            {$viewData->container.package->description}
            </h5>
            <h5>Стоимость: {$viewData->container.package->cost|number_format:2}грн./мес.</h5>
            <hr>
            <div class="row-submit">
                <button type="submit">Оплатить в счет балланса</button>
            </div>
        </form>
    </div>
</div>