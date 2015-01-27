<?php /* Smarty version 2.6.26, created on 2015-01-28 00:14:34
         compiled from container/export.tpl */ ?>
<div id="main" data-role="main">
    <h2>Настройка экспорта прайслиста</h2>
    <p>Снимите или поставьте галочку для отображения рубрики в прайсе. Перемщайте рубрики для наиболее удобного отображения</p>
        <table class="movableContainer">
            <tr>
                <td>
                    <form action="<?php echo $this->_tpl_vars['baseLink']; ?>
/?view=api&load=opt" class="form form-export">
                        <input type="hidden" name="fnc" value="priceExport">
                        <input type="hidden" name="typeKey" value="2">
                        <input class="filter-sqlscopename" type="hidden" value="BT" name="filter[sqlscopename]">
                            <h2>Диски</h2>
                            <div class="movableContainer">
                                <div class="movableHeading">
                                    <div class="item">
                                        ПРОИЗВОДИТЕЛЬ <select name="export[manufacturer]">
                                            <option value="">Все</option>
                                            <?php $_from = $this->_tpl_vars['viewData']->container['formData']->manufacturer['wheel']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                                <option value="<?php echo $this->_tpl_vars['row']->manufacturer_id; ?>
"><?php echo $this->_tpl_vars['row']->manufacturer_name; ?>
</option>
                                            <?php endforeach; endif; unset($_from); ?>
                                        </select>
                                    </div>
                                    <div class="item"></div>
                                </div>
                                <div class="movableHeading">
                                    <div class="item">
                                        ТОВАРЫ К-ВОМ НЕ МЕНЕЕ <input type="text" name="export[amount]">
                                    </div>
                                    <div class="item">
                                        КОДИРОВКА
                                        <ul class="opt-group select-export-type">
                                            <li>
                                                <input id="xlsx_2" type="radio" name="type_file_2" value="xlsx" checked>
                                                <label for="xlsx_2">XLS</label>
                                            </li>
                                            <li>
                                                <input id="csv_2" type="radio" name="type_file_2" value="csv">
                                                <label for="csv_2">CSV</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="movable">
                                    <ul>
                                        <li class="ui-state-default">
                                            <input type="checkbox" name="export[2][manufacturer]" value="1">
                                            Бренд
                                        </li>
                                        <li class="ui-state-default">
                                            <input type="checkbox" name="export[2][model]" value="1">
                                            Модель
                                        </li>
                                        <li class="ui-state-default">
                                            <input type="checkbox" name="export[2][scopename]" value="1">
                                            Наименование
                                        </li>
                                        <li class="ui-state-default">
                                            <input type="checkbox" name="export[2][size_w]" value="1">
                                            Ширина
                                        </li>
                                        <li class="ui-state-default">
                                            <input type="checkbox" name="export[2][size_r]" value="1">
                                            Диаметр
                                        </li>
                                        <li class="ui-state-default">
                                            <input type="checkbox" name="export[2][pcd_1]" value="1">
                                            PCD1
                                        </li>
                                        <li class="ui-state-default">
                                            <input type="checkbox" name="export[2][pcd_2]" value="1">
                                            PCD2
                                        </li>
                                        <li class="ui-state-default">
                                            <input type="checkbox" name="export[2][et]" value="1">
                                            Вылет (ET)
                                        </li>
                                        <li class="ui-state-default">
                                            <input type="checkbox" name="export[2][dia]" value="1">
                                            Диаметр ступицы (DIA)
                                        </li>
                                        <li class="ui-state-default">
                                            <input type="checkbox" name="export[2][color]" value="1">
                                            Цвет
                                        </li>
                                        <li class="ui-state-default">
                                            <input type="checkbox" name="export[2][manufacturer_wheel_type]" value="1">
                                            Тип диска
                                        </li>
                                        <li class="ui-state-default">
                                            <input type="checkbox" name="export[2][bolt]" value="1">
                                            Крепеж
                                        </li>
                                        <li class="ui-state-default">
                                            <input type="checkbox" name="export[2][date]" value="1">
                                            Дата обновления склада
                                        </li>
                                        <li class="ui-state-default">
                                            <input type="checkbox" name="export[2][stock_1]" value="1">
                                            Остаток
                                        </li>
                                        <li class="ui-state-default">
                                            <input type="checkbox" name="export[2][price_1]" value="1">
                                            Оптовая цена
                                        </li>
                                        <li class="ui-state-default">
                                            <input type="checkbox" name="export[2][price_compiled]" value="1">
                                            Розничная цена
                                        </li>
                                        <li class="ui-state-default">
                                            <input type="checkbox" name="export[2][company]" value="1">
                                            Поставщик
                                        </li>
                                        <li class="ui-state-default">
                                            <input type="checkbox" name="export[2][city]" value="1">
                                            Город
                                        </li>
                                        <li class="ui-state-default">
                                            <input type="checkbox" name="export[2][id]" value="1">
                                            ID
                                        </li>
                                        <li class="ui-state-default">
                                            <input type="checkbox" name="export[2][src]" value="1">
                                            Изображение
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <button type="submit" class="createExportList" data-type="2">Экспорт</button>
                    </form>
                </td>
                <td>
                    <form action="<?php echo $this->_tpl_vars['baseLink']; ?>
/?view=api&load=opt" class="form form-export">
                        <input type="hidden" name="fnc" value="priceExport">
                        <input type="hidden" name="typeKey" value="1">
                        <input class="filter-sqlscopename" type="hidden" value="BT" name="filter[sqlscopename]">
                        <h2>Шины</h2>
                        <div class="movableContainer">
                            <div class="movableHeading">
                                <div class="item">
                                    ПРОИЗВОДИТЕЛЬ <select name="export[manufacturer]">
                                        <option value="">Все</option>
                                        <?php $_from = $this->_tpl_vars['viewData']->container['formData']->manufacturer['tyre']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                            <option value="<?php echo $this->_tpl_vars['row']->manufacturer_id; ?>
"><?php echo $this->_tpl_vars['row']->manufacturer_name; ?>
</option>
                                        <?php endforeach; endif; unset($_from); ?>
                                    </select>
                                </div>
                                <div class="item"></div>
                            </div>
                            <div class="movableHeading">
                                <div class="item">
                                    ТОВАРЫ К-ВОМ НЕ МЕНЕЕ <input type="text" name="export[amount]">
                                </div>
                                <div class="item">
                                    КОДИРОВКА
                                    <ul class="opt-group select-export-type">
                                        <li>
                                            <input id="xlsx_1" type="radio" name="type_file_1" value="xlsx" checked>
                                            <label for="xlsx_1">XLS</label>
                                        </li>
                                        <li>
                                            <input id="csv_1" type="radio" name="type_file_1" value="csv">
                                            <label for="csv_1">CSV</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="movable">
                                <ul>
                                    <li class="ui-state-default">
                                        <input type="checkbox" name="export[1][manufacturer]" value="1">
                                        Бренд
                                    </li>
                                    <li class="ui-state-default">
                                        <input type="checkbox" name="export[1][model]" value="1">
                                        Модель
                                    </li>
                                    <li class="ui-state-default">
                                        <input type="checkbox" name="export[1][scopename]" value="1">
                                        Наименование
                                    </li>
                                    <li class="ui-state-default">
                                        <input type="checkbox" name="export[1][season]" value="1">
                                        Сезон
                                    </li>
                                    <li class="ui-state-default">
                                        <input type="checkbox" name="export[1][type_transport]" value="1">
                                        Тип транспортного средства
                                    </li>
                                    <li class="ui-state-default">
                                        <input type="checkbox" name="export[1][size_w]" value="1">
                                        Ширина
                                    </li>
                                    <li class="ui-state-default">
                                        <input type="checkbox" name="export[1][size_h]" value="1">
                                        Высота
                                    </li>
                                    <li class="ui-state-default">
                                        <input type="checkbox" name="export[1][size_r]" value="1">
                                        Диаметр
                                    </li>
                                    <li class="ui-state-default">
                                        <input type="checkbox" name="export[1][si_f]" value="1">
                                        Индекс скорости
                                    </li>
                                    <li class="ui-state-default">
                                        <input type="checkbox" name="export[1][sw_f]" value="1">
                                        Индекс нагрузки
                                    </li>
                                    <li class="ui-state-default">
                                        <input type="checkbox" name="export[1][technology]" value="1">
                                        Усиленная шина
                                    </li>
                                    <li class="ui-state-default">
                                        <input type="checkbox" name="export[1][spike]" value="1">
                                        шип/нешип
                                    </li>
                                    <li class="ui-state-default">
                                        <input type="checkbox" name="export[1][stock_1]" value="1">
                                        Остаток
                                    </li>
                                    <li class="ui-state-default">
                                        <input type="checkbox" name="export[1][price_1]" value="1">
                                        Оптовая цена
                                    </li>
                                    <li class="ui-state-default">
                                        <input type="checkbox" name="export[1][price_compiled]" value="1">
                                        Розничная цена
                                    </li>
                                    <li class="ui-state-default">
                                        <input type="checkbox" name="export[1][city]" value="1">
                                        Город
                                    </li>
                                    <li class="ui-state-default">
                                        <input type="checkbox" name="export[1][id]" value="1">
                                        ID
                                    </li>
                                    <li class="ui-state-default">
                                        <input type="checkbox" name="export[1][date]" value="1">
                                        Дата обновления склада
                                    </li>
                                    <li class="ui-state-default">
                                        <input type="checkbox" name="export[1][company]" value="1">
                                        Поставщик
                                    </li>
                                    <li class="ui-state-default">
                                        <input type="checkbox" name="export[1][src]" value="1">
                                        Изображение
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <button type="submit" class="createExportList" data-type="1">Экспорт</button>
                    </form>
                </td>
            </tr>
        </table>
    <iframe id="downloader" width="1" height="1" frameborder="0" src=""></iframe>
</div>