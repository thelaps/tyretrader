<article>
    <h1>{$viewData->container->makeName()}</h1>
    <div class="details">
        <div class="contact-info">
            <p>Строка: <strong>Нет данных{*if $viewData->container->raw}{$viewData->container->raw}{/if*}</strong></p>
        </div>
        <fieldset>
            <legend>Исправить:</legend>
            <textarea style="height: 142px; width: 100%;"></textarea>
        </fieldset>
    </div>
</article>