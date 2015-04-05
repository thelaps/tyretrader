<div class="tab" data-role="tab">
    <form action="{$baseLink}/?view=api&load=paymentcenter" class="form form-filter" enctype="multipart/form-data">
        <input type="hidden" name="fnc" value="payBallance">
        <div class="row row-table">
            <div class="area-cell">
                <h4>Платежные реквизиты</h4>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Номер карты</label>
                        </div>
                        <div class="cell">
                            <input type="text" name="payment[card_num]" value="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>Срок действия</label>
                        </div>
                        <div class="cell">
                            <select name="payment[card_exp_month]">
                            {foreach item=month from=$viewData->container.expiration->months}
                                <option value="{$month}">{$month}</option>
                            {/foreach}
                            </select>
                            /
                            <select name="payment[card_exp_year]">
                                {foreach item=year from=$viewData->container.expiration->years}
                                <option value="{$year}">{$year}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field align-right two-cell">
                        <div class="cell">
                            <label>CVV<sup>трех значное число с обратной стороны</sup></label>
                        </div>
                        <div class="cell">
                            <input type="password" name="payment[card_cvv]" value="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-table">
            <div class="area-cell area-one-cell">
                <div class="row">
                    <div class="field two-cell align-right">
                        <div class="cell">
                            <label>Моб. телефон<sup>для смс авторизации</sup></label>
                        </div>
                        <div class="cell">
                            <input type="text" name="payment[phone]" value="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="field two-cell align-right">
                        <div class="cell">
                            <label>Сумма пополнения</label>
                        </div>
                        <div class="cell">
                            <input type="text" name="payment[amount]" value="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit">Оплатить</button>
    </form>
</div>