<?php /* Smarty version 2.6.26, created on 2016-01-19 07:07:46
         compiled from container/api/product.tpl */ ?>
<article>
    <h1><?php echo $this->_tpl_vars['viewData']->container->makeName(); ?>
</h1>
    <div class="image-set">
        <div class="image">
            <img src="<?php echo $this->_tpl_vars['baseLink']; ?>
/images/<?php echo $this->_tpl_vars['viewData']->container->src; ?>
" alt="tyre"/>
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
            <div class="qty">Ко-во: <b><?php echo $this->_tpl_vars['viewData']->container->stock_1; ?>
шт</b>.</div>
            <div class="price-value"><?php echo $this->_tpl_vars['viewData']->container->price_1; ?>
 грн</div>
        </div>-->
        <!--<div class="contact-info">
            <p>Тел.: <strong><?php echo $this->_tpl_vars['viewData']->container->phone; ?>
</strong>  (<?php echo $this->_tpl_vars['viewData']->container->user; ?>
)</p>
            <a class="link-email" href="mailto:<?php echo $this->_tpl_vars['viewData']->container->email; ?>
">Связаться по Email</a>
        </div>-->
        <table>
            <tr>
                <th>Сезон:</th>
                <td><?php echo $this->_tpl_vars['viewData']->container->season_dict; ?>
</td>
            </tr>
            <tr>
                <th>Тип машины:</th>
                <td><?php echo $this->_tpl_vars['viewData']->container->type_transport_dict; ?>
</td>
            </tr>
            <tr>
                <th>Ширина профиля, мм:</th>
                <td><?php echo $this->_tpl_vars['viewData']->container->size_w; ?>
</td>
            </tr>
            <tr>
                <th>Высота профиля, %:</th>
                <td><?php echo $this->_tpl_vars['viewData']->container->size_h; ?>
</td>
            </tr>
            <tr>
                <th>Диаметр диска, дюймы:</th>
                <td><?php echo $this->_tpl_vars['viewData']->container->size_r; ?>
</td>
            </tr>
            <tr>
                <th>Индекс нагрузки:</th>
                <td><?php echo $this->_tpl_vars['viewData']->container->sw_f; ?>
<?php if ($this->_tpl_vars['viewData']->container->sw_b): ?>/<?php echo $this->_tpl_vars['viewData']->container->sw_b; ?>
<?php endif; ?></td>
            </tr>
            <tr>
                <th>Индекс скорости:</th>
                <td><?php echo $this->_tpl_vars['viewData']->container->si_f; ?>
<?php if ($this->_tpl_vars['viewData']->container->si_b): ?>/<?php echo $this->_tpl_vars['viewData']->container->si_b; ?>
<?php endif; ?></td>
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