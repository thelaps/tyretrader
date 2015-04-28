<?php /* Smarty version 2.6.26, created on 2015-04-28 23:52:29
         compiled from container/api/company.tpl */ ?>
<article>
    <h1><?php echo $this->_tpl_vars['viewData']->container->items->name; ?>
</h1>
    <div class="details">
        <div class="contact-info">
            <p>Тел.: <strong><?php echo $this->_tpl_vars['viewData']->container->items->phone; ?>
</strong></p>
            <p>Имя: <strong><?php echo $this->_tpl_vars['viewData']->container->items->firstname; ?>
</strong></p>
            <p>Город: <strong><?php echo $this->_tpl_vars['viewData']->container->items->city; ?>
</strong></p>
            <p>E-mail: <strong><a href="mailto:<?php echo $this->_tpl_vars['viewData']->container->items->email; ?>
"><?php echo $this->_tpl_vars['viewData']->container->items->email; ?>
</a></strong></p>
            <p>Платежные реквизиты: <strong><?php echo $this->_tpl_vars['viewData']->container->billing->payment_details; ?>
</strong></p>
            <a class="link-email" href="mailto:<?php echo $this->_tpl_vars['viewData']->container->items->email; ?>
">Связаться по Email</a>
        </div>
    </div>
</article>