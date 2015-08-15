<div id="packages_grid">
    {foreach item=package from=$viewData->container.packages}
    <div class="package_item">
        <form action="{$baseLink}/?view=api&load=paymentcenter" class="form form-filter" enctype="multipart/form-data">
            <input type="hidden" name="fnc" value="buyPackage">
            <input type="hidden" name="sku" value="{$package->sku}">
        <h4>{$package->title}</h4>
        <p>{$package->description}</p>
        <button type="submit">Купить за {$package->cost|number_format:2}грн./мес.</button>
    </div>
    <hr/>
    {/foreach}
</div>