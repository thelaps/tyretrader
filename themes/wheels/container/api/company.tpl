<article>
    <h1>{$viewData->container->items->name}</h1>
    <div class="details">
        <div class="contact-info">
            <p>Тел. опт.: <strong>{$viewData->container->billing->phone_1}</strong></p>
            <p>Тел. розн.: <strong>{$viewData->container->billing->phone_2}</strong></p>
            <p>Имя: <strong>{$viewData->container->items->firstname}</strong></p>
            <p>Город: <strong>{$viewData->container->items->city}</strong></p>
            <p>E-mail: <strong><a href="mailto:{$viewData->container->items->email}">{$viewData->container->items->email}</a></strong></p>
            <p>Платежные реквизиты: <strong>{$viewData->container->billing->payment_details}</strong></p>
            <a class="link-email" href="mailto:{$viewData->container->items->email}">Связаться по Email</a>
        </div>
    </div>
</article>