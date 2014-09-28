<?php /* Smarty version 2.6.26, created on 2014-09-28 22:50:12
         compiled from container/forms/homeContainerForm.tpl */ ?>

<div class="sidebar-widget">
    <ul class="mainList">
        <li>
            <a href="" class="active">Информация</a>
            <ul class="childrenList">
                <li>
                    <a href="" class="active" data-tab="#sidebar-linked">Личные данные</a>
                </li>
                <li>
                    <a href="" data-tab="#sidebar-linked">Статистика</a>
                </li>
                <li>
                    <a href="" data-tab="#sidebar-linked">Акции</a>
                </li>
                <li>
                    <a href="" data-tab="#sidebar-linked">Фото</a>
                </li>
                <li>
                    <a href="" data-tab="#sidebar-linked">Обзоры</a>
                </li>
                <li>
                    <a href="" data-tab="#sidebar-linked">Балланс</a>
                </li>
                <li>
                    <a href="" data-tab="#sidebar-linked">Услуги</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="">Покупка</a>
            <ul class="childrenList">
                <li>
                    <a href="">Еще в разработке</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="<?php echo $this->_tpl_vars['baseLink']; ?>
/?load=sold">Продажа</a>
        </li>
        <li>
            <a href="<?php echo $this->_tpl_vars['baseLink']; ?>
/?load=opt">Опт</a>
        </li>
        <li>
            <a href="">Заявки</a>
            <ul class="childrenList">
                <li>
                    <a href="">Еще в разработке</a>
                </li>
            </ul>
        </li>
    </ul>
</div>
<div id="sidebar-linked" class="tab-widget" data-role="tabs">
    <ul>
        <li class="active">Личные данные</li>
        <li>Статистика</li>
        <li>Акции</li>
        <li>Фото</li>
        <li>Обзоры</li>
        <li>Балланс</li>
        <li>Услуги</li>
    </ul>
    <div class="tabs-holder">
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "container/forms/homeTabs/homeContainerFormTab1.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <div class="tab" data-role="tab">
            <img src="<?php echo $this->_tpl_vars['src']; ?>
/images/under-construction.png">
            Раздел в разработке...
        </div>
        <div class="tab" data-role="tab">
            <img src="<?php echo $this->_tpl_vars['src']; ?>
/images/under-construction.png">
            Раздел в разработке...
        </div>
        <div class="tab" data-role="tab">
            <img src="<?php echo $this->_tpl_vars['src']; ?>
/images/under-construction.png">
            Раздел в разработке...
        </div>
        <div class="tab" data-role="tab">
            <img src="<?php echo $this->_tpl_vars['src']; ?>
/images/under-construction.png">
            Раздел в разработке...
        </div>
        <div class="tab" data-role="tab">
            <img src="<?php echo $this->_tpl_vars['src']; ?>
/images/under-construction.png">
            Раздел в разработке...
        </div>
        <div class="tab" data-role="tab">
            <img src="<?php echo $this->_tpl_vars['src']; ?>
/images/under-construction.png">
            Раздел в разработке...
        </div>
    </div>
</div>