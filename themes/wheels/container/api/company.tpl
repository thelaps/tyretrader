<article>
    <h1>{$viewData->container->items->name}</h1>
    <div class="details">
        <div class="contact-info">
            <p>Тел.: <strong>{$viewData->container->items->phone}</strong></p>
            <p>Имя: <strong>{$viewData->container->items->firstname}</strong></p>
            <p>Гор.: <strong>{$viewData->container->items->city}</strong></p>
            <a class="link-email" href="mailto:{$viewData->container->items->email}">Связаться по Email</a>
        </div>
    </div>
</article>