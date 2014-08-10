<article>
    <h1>{$viewData->container->makeName()}</h1>
    <div class="image-set">
        <div class="image">
            <img src="{$baseLink}/images/{$viewData->container->src}" alt="tyre"/>
        </div>
        <div class="thumbnails">
            <!--<a class="thumb" href="themes/wheels/src/images/img-demo.jpg">
                <img src="themes/wheels/src/images/img-thumb.jpg" alt="tyre"/>
            </a>
            <a class="thumb" href="themes/wheels/src/images/img-demo2.jpg">
                <img src="themes/wheels/src/images/img-thumb.jpg" alt="tyre"/>
            </a>
            <a class="thumb" href="themes/wheels/src/images/img-demo.jpg">
                <img src="themes/wheels/src/images/img-thumb.jpg" alt="tyre"/>
            </a>-->
        </div>
    </div>
    <div class="details">
        <!--<div class="price">
            <div class="qty">Ко-во: <b>{$viewData->container->stock_1}шт</b>.</div>
            <div class="price-value">{$viewData->container->price_1} грн</div>
        </div>-->
        <!--<div class="contact-info">
            <p>Тел.: <strong>{$viewData->container->phone}</strong>  ({$viewData->container->user})</p>
            <a class="link-email" href="mailto:{$viewData->container->email}">Связаться по Email</a>
        </div>-->
        <table>
            <tr>
                <th>Сезон:</th>
                <td>{$viewData->container->season_dict}</td>
            </tr>
            <tr>
                <th>Тип машины:</th>
                <td>{$viewData->container->type_transport_dict}</td>
            </tr>
            <tr>
                <th>Ширина профиля, мм:</th>
                <td>{$viewData->container->size_w}</td>
            </tr>
            <tr>
                <th>Высота профиля, %:</th>
                <td>{$viewData->container->size_h}</td>
            </tr>
            <tr>
                <th>Диаметр диска, дюймы:</th>
                <td>{$viewData->container->size_r}</td>
            </tr>
            <tr>
                <th>Индекс нагрузки:</th>
                <td>{$viewData->container->sw_f}{if $viewData->container->sw_b}/{$viewData->container->sw_b}{/if}</td>
            </tr>
            <tr>
                <th>Индекс скорости:</th>
                <td>{$viewData->container->si_f}{if $viewData->container->si_b}/{$viewData->container->si_b}{/if}</td>
            </tr>
        </table>
        <!--<div class="recommend-it">
            <span>Рекомендовать</span>
            <div class="votes">
                <div class="like">
                    <span>58</span>
                    <button class="like-it" type="button">like</button>
                </div>
                <div class="dislike">
                    <span>55</span>
                    <button class="dislike-it" type="button">dislike</button>
                </div>
            </div>
        </div>-->
        <!--<div class="reviews">
            <a href="#">Посмотреть отзывы</a>
        </div>-->
    </div>
</article>