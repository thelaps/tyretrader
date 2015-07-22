<div class="tab" data-role="tab">
    <form action="{$baseLink}/?view=api&load=opt" class="form form-order">
        <input type="hidden" name="fnc" value="opt">
        <input type="hidden" name="filter[manufacturer]" value="BT" class="filter-manufacturer">
        <input type="hidden" name="filter[model]" value="BT" class="filter-model">
        <input type="hidden" name="filter[stock_1]" value="TB" class="filter-stock_1">
        <input type="hidden" name="filter[date]" value="TB" class="filter-date">
        <input type="hidden" name="filter[price_1]" value="BT" class="filter-price_1">
        <input type="hidden" name="filter[sqlscopename]" value="BT" class="filter-sqlscopename">
        <input type="hidden" name="tyre[type_transport]" value="1">
        <div class="order-options">
            <div class="h-separator"></div>
            <div class="row car-options" data-name="product-type">
                <div class="area-brand" style="border:0;">
                    <div class="row">
                        <div class="field align-left">
                            <label>Производитель</label>
                            <select class="jcf-ignore">
                                <option value="">Все</option>
                                <option value="">Alfa Romeo</option>
                                <option value="">BMW</option>
                                <option value="">Ford</option>
                                <option value="">Mercedes</option>
                            </select>
                        </div>
                        <div class="field align-right">
                            <label>Модель</label>
                            <select class="jcf-ignore">
                                <option>Все</option>
                                <option>model 1</option>
                                <option>model 2</option>
                                <option>model 3</option>
                                <option>model 4</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="order-submit">
            <button type="submit">Подобрать</button>
        </div>
    </form>
</div>