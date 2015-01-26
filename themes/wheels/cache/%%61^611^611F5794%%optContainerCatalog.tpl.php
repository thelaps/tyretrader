<?php /* Smarty version 2.6.26, created on 2015-01-25 00:50:34
         compiled from container/forms/optContainerCatalog.tpl */ ?>
<div id="optHolder" style="display: none;">
    <div class="serviceHolder">
        <div class="clientSwitcher">
            <div class="member"></div>
            <div class="team active"></div>
        </div>
        <div class="commercialSystem">
            <label>Коммерческое предложение с</label>
            <input type="text" value="20" id="catalogAmounts">
            <label>позициями</label>
            <button class="system createPriceList">Создать</button>
        </div>
    </div>

    <div class="ajaxContent">
        <div class="resultHolder">
            <div class="amount">
                Найдено <b><?php echo $this->_tpl_vars['viewData']->container['opt']->total; ?>
</b> записей
            </div>
            <div class="note">
                Уточняйте наличие шипов в шинах у поставщиков, если это не указано в характеристиках
            </div>
        </div>
        <table class="mainTable"></table>
    </div>
</div>
<div id="pageContent">
    <h5>Тестовые данные</h5>
    <p>Тестовый текст</p>
</div>