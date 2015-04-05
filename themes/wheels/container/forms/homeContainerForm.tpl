
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
            <a href="{$baseLink}/?load=sold">Продажа</a>
        </li>
        <li>
            <a href="{$baseLink}/?load=opt">Опт</a>
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
        {include file="container/forms/homeTabs/homeContainerFormTab1.tpl"}
        <div class="tab" data-role="tab">
            <img src="{$src}/images/under-construction.png">
            Раздел в разработке...
        </div>
        <div class="tab" data-role="tab">
            <img src="{$src}/images/under-construction.png">
            Раздел в разработке...
        </div>
        <div class="tab" data-role="tab">
            <img src="{$src}/images/under-construction.png">
            Раздел в разработке...
        </div>
        <div class="tab" data-role="tab">
            <img src="{$src}/images/under-construction.png">
            Раздел в разработке...
        </div>
        {include file="container/forms/homeTabs/homeContainerFormTabAccountBalance.tpl"}
        <div class="tab" data-role="tab">
            {include file="container/forms/homeTabs/homeContainerFormTabPackages.tpl"}
        </div>
    </div>
</div>