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
                Найдено <b>{$viewData->container.opt->total}</b> записей
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