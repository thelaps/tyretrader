<div id="packages_grid">
    {foreach item=package from=$viewData->container.packages}
    <div class="package_item">
        <h4>{$package->title}</h4>
        <p>{$package->description}</p>
        <a href="{$package->sku}">Купить за {$package->cost|number_format:2}грн.</a>
    </div>
    {/foreach}
</div>