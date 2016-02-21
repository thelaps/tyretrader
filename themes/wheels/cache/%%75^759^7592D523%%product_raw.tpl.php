<?php /* Smarty version 2.6.26, created on 2016-01-19 10:46:27
         compiled from container/api/product_raw.tpl */ ?>
<article>
    <h1><?php echo $this->_tpl_vars['viewData']->container->makeName(); ?>
</h1>
    <div class="details">
        <div class="contact-info">
            <p>Строка: <strong><?php if ($this->_tpl_vars['viewData']->container->price_line): ?><?php echo $this->_tpl_vars['viewData']->container->price_line; ?>
<?php else: ?>Нет данных<?php endif; ?></strong></p>
        </div>
        <fieldset>
            <legend>Исправить:</legend>
            <textarea style="height: 142px; width: 100%;"></textarea>
        </fieldset>
    </div>
</article>