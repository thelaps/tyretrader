<div id="main">
<h2>Визуальный шинный калькулятор</h2>
<div class="text-block">
    <p><em>Предназначен для математического расчета размеров автошины а также для расчета погрешностей в показаниях спидомеметра и километража при установке шин не рекомендованных производителем.</em></p>
</div>
<div class="tab-widget tyre-calc" data-role="tabs">
<ul>
    <li class="active">
        Выбор размера
    </li>
    <li>
        По марке машины
    </li>
</ul>
<div class="tabs-holder form">
<div class="tab" data-role="tab">
    <div class="col-options">
        <h3 class="tab-title">Прежний размер</h3>
        <div class="two-columns">
            <div>
                <div class="check-item">
                    <input type="checkbox" id="show-tyre-1">
                    <label for="show-tyre-1">Показать шину</label>
                </div>
                <div class="size-field">
                    <div>
                        <label>Ширина</label>
                        <input class="size-xs" type="text">
                    </div>
                    <span>/</span>
                    <div>
                        <label>Высота</label>
                        <input class="size-xs" type="text">
                    </div>
                    <span>-</span>
                    <div>
                        <label>Диаметр</label>
                        <input class="size-xs" type="text">
                    </div>
                </div>
            </div>
            <div>
                <div class="check-item">
                    <input type="checkbox" id="show-disc-1">
                    <label for="show-disc-1">Показать диск</label>
                </div>
                <div class="size-field">
                    <div>
                        <label>Ширина</label>
                        <input class="size-xs" type="text">
                    </div>
                    <span>X</span>
                    <div>
                        <label>Высота</label>
                        <input class="size-xs" type="text">
                    </div>
                    <span>-</span>
                    <div>
                        <label>Вылет</label>
                        <input class="size-xs" type="text">
                    </div>
                </div>
            </div>
        </div>
        <div class="visual">
            <img src="themes/wheels/src/images/visual-calc.jpg" alt="alt">
        </div>
    </div>
    <div class="col-options">
        <h3 class="tab-title">Новый размер</h3>
        <div class="two-columns">
            <div>
                <div class="check-item">
                    <input type="checkbox" id="show-tyre-2">
                    <label for="show-tyre-2">Показать шину</label>
                </div>
                <div class="size-field">
                    <div>
                        <label>Ширина</label>
                        <input class="size-xs" type="text">
                    </div>
                    <span>/</span>
                    <div>
                        <label>Высота</label>
                        <input class="size-xs" type="text">
                    </div>
                    <span>-</span>
                    <div>
                        <label>Диаметр</label>
                        <input class="size-xs" type="text">
                    </div>
                </div>
            </div>
            <div>
                <div class="check-item">
                    <input type="checkbox" id="show-disc-2">
                    <label for="show-disc-2">Показать диск</label>
                </div>
                <div class="size-field">
                    <div>
                        <label>Ширина</label>
                        <input class="size-xs" type="text">
                    </div>
                    <span>X</span>
                    <div>
                        <label>Высота</label>
                        <input class="size-xs" type="text">
                    </div>
                    <span>-</span>
                    <div>
                        <label>Вылет</label>
                        <input class="size-xs" type="text">
                    </div>
                </div>
            </div>
        </div>
        <div class="visual">
            <img src="themes/wheels/src/images/visual-calc.jpg" alt="alt">
        </div>
    </div>
</div>
<div class="tab" data-role="tab">
    <div class="col-options">
        <h3 class="tab-title">Прежний размер</h3>
        <div class="two-columns">
            <div>
                <div class="field">
                    <label>Марка:</label>
                    <select>
                        <option>BMW</option>
                        <option>Lada</option>
                        <option>Mercedes</option>
                    </select>
                </div>
            </div>
            <div>
                <div class="field">
                    <label>Модель:</label>
                    <select>
                        <option>Model 1</option>
                        <option>Model 2</option>
                        <option>Model 3s</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="visual">
            <img src="themes/wheels/src/images/visual-calc.jpg" alt="alt">
        </div>
    </div>
    <div class="col-options">
        <h3 class="tab-title">Новый размер</h3>
        <div class="two-columns">
            <div>
                <div class="field">
                    <label>Год випуска:</label>
                    <select>
                        <option>1990</option>
                        <option>2000</option>
                        <option>2013</option>
                    </select>
                </div>
            </div>
            <div>
                <div class="field">
                    <label>Двигатель:</label>
                    <select>
                        <option>Model 1</option>
                        <option>Model 2</option>
                        <option>Model 3s</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="visual">
            <img src="themes/wheels/src/images/visual-calc.jpg" alt="alt">
        </div>
    </div>
</div>
<div class="summary">
    <table class="table-summary">
        <thead>
        <tr>
            <th>Шины:</th>
            <th>Прежний размер:</th>
            <th>Новый размер:</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th>Размеры шин</th>
            <td>175/70-13</td>
            <td>185/40-17</td>
        </tr>
        <tr>
            <th>Ширина протектора:</th>
            <td>175 мм (6.9'')</td>
            <td>  185 мм (7.3'')</td>
        </tr>
        <tr>
            <th>Диаметр шины:</th>
            <td>576 мм (22.7'')</td>
            <td>580 мм (22.8'')
                на 4 мм (0.7%) выше</td>
        </tr>
        <tr>
            <th>Рекомендуемые размеры дисков:</th>
            <td>от 5x13 до 6x13</td>
            <td> от 5x17 до 6.5x17</td>
        </tr>
        <tr>
            <th>Длина окружности:</th>
            <td>1809 мм (71.3'')</td>
            <td>1822 мм (71.8'')</td>
        </tr>
        <tr>
            <td colspan="3"></td>
        </tr>
        <tr class="speed">
            <th>Изменение показаний спидометра:</th>
            <td colspan="2">Когда скорость достигает 100 км/ч, реальная скорость будет равна 100.9 км/ч: на 0.8% больше</td>
        </tr>
        <tr class="clearance">
            <th>Изменение клиренса:</th>
            <td colspan="2">2мм</td>
        </tr>
        </tbody>
    </table>
</div>

</div>
</div>

</div>