<article>
    <h1>{$viewData->container->makeName()}</h1>
    <div class="details">
        <div class="contact-info">
            <p>Строка: <strong>{if $viewData->container->price_line}{$viewData->container->price_line}{else}Нет данных{/if}</strong></p>
        </div>
        <fieldset>
            <legend>Исправить:</legend>
            <textarea style="height: 142px; width: 100%;"></textarea>
        </fieldset>
    </div>
</article>