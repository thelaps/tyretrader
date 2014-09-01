<?php /* Smarty version 2.6.26, created on 2014-09-01 22:04:16
         compiled from container/forms/mainContainerForm.tpl */ ?>
<div class="tab-widget" data-role="tabs">
<ul>
    <li class="active">
        <span class="ico ico-buy"></span>
        Купить
    </li>
    <li>
        <span class="ico ico-sell"></span>
        Продать
    </li>
    <li class="search-tab">
        <span class="ico ico-search"></span>
        Подобрать
    </li>
</ul>
<div class="tabs-holder">
<!-- First tab: buy -->
<div class="tab" data-role="tab">
    <form action="#" class="form form-order">
        <div class="order-options">
            <!-- Select disc or tyre -->
            <div class="row product-type">
                <ul class="opt-group" data-role="switcher" data-name="product-type">
                    <li>
                        <input id="b_tyre" data-target=".tyre-options" type="radio" name="product-type" checked>
                        <label for="b_tyre">Шины</label>
                    </li>
                    <li>
                        <input id="b_disc" data-target=".disc-options" type="radio" name="product-type">
                        <label for="b_disc">Диски</label>
                    </li>
                </ul>
                <ul class="opt-group">
                    <li>
                        <input id="b_new" type="radio" name="originality" checked >
                        <label for="b_new">Новые</label>
                    </li>
                    <li>
                        <input id="b_used" type="radio" name="originality">
                        <label for="b_used">Б/У</label>
                    </li>
                </ul>
                <div class="quantity">
                    <label for="b_qty">Количество</label>
                    <input id="b_qty" class="size-s" type="text" name="quantity">
                </div>
            </div>
            <div class="h-separator"></div>
            <div class="row">
                <!-- Select brand -->
                <div class="area-brand">
                    <div class="row tyre-options" data-name="product-type">
                        <div class="field align-left">
                            <label>Бренд</label>
                            <select>
                                <option value="">Все</option>
                                <option value="">America</option>
                                <option value="">Amtel</option>
                                <option value="">Arctic Claw</option>
                                <option value="">Autoguard</option>
                                <option value="">BCT</option>
                                <option value="">BFGoodrich</option>
                                <option value="">Blackstone</option>
                            </select>
                        </div>
                        <div class="field align-right">
                            <label>Модель</label>
                            <select>
                                <option>Все</option>
                                <option>model 1</option>
                                <option>model 2</option>
                                <option>model 3</option>
                            </select>
                        </div>
                    </div>
                    <div class="row disc-options" data-name="product-type">
                        <div class="field align-left">
                            <label>Бренд</label>
                            <select>
                                <option value="">Все</option>
                                <option value="">K&amp;K</option>
                                <option value="">Kosei</option>
                                <option value="">Lenso</option>
                                <option value="">MOMO</option>
                                <option value="">Racing Wheels</option>
                            </select>
                        </div>
                        <div class="field align-right">
                            <label>Модель</label>
                            <select>
                                <option>Все</option>
                                <option>model 1</option>
                                <option>model 2</option>
                                <option>model 3</option>
                                <option>model 4</option>
                            </select>
                        </div>
                    </div>
                    <div class="date-period justify">
                        <label>Период актуальности</label>
                        <input type="text" value="11.08.2013">
                        <span>-</span>
                        <input type="text" value="11.08.2013">
                    </div>
                </div>
                <!-- Select type and size -->
                <div class="area-type">
                    <!-- Disc options -->
                    <div class="disc-options" data-name="product-type">
                        <div class="field">
                            <label>Тип диска</label>
                            <ul class="opt-group justify">
                                <li>
                                    <input type="checkbox" name="disc-type" id="b_type-1">
                                    <label for="b_type-1">Стальной</label>
                                </li>
                                <li>
                                    <input type="checkbox" name="disc-type" id="b_type-2">
                                    <label for="b_type-2">Литой</label>
                                </li>
                                <li>
                                    <input type="checkbox" name="disc-type" id="b_type-3">
                                    <label for="b_type-3">Кованный</label>
                                </li>
                            </ul>
                        </div>
                        <div class="size-field">
                            <div>
                                <label for="b_width">Ширина диска</label>
                                <input id="b_width" class="size-s" type="text">
                            </div>
                            <span>/</span>
                            <div>
                                <label for="b_fixture">Крепеж диска</label>
                                <input id="b_fixture" class="size-s" type="text">
                            </div>
                            <span>x</span>
                            <div>
                                <label for="b_pcd">PCD</label>
                                <input id="b_pcd" class="size-s" type="text">
                            </div>
                        </div>
                    </div>
                    <!-- Tyre options -->
                    <div class="tyre-options" data-name="product-type">
                        <div class="field">
                            <label>Сезон</label>
                            <ul class="opt-group justify">
                                <li>
                                    <input type="checkbox" name="disc-type" id="b_season-1">
                                    <label for="b_season-1">Летняя</label>
                                </li>
                                <li>
                                    <input type="checkbox" name="disc-type" id="b_season-2">
                                    <label for="b_season-2">Зимняя</label>
                                </li>
                                <li>
                                    <input type="checkbox" name="disc-type" id="b_season-3">
                                    <label for="b_season-3">Всесезонная</label>
                                </li>
                            </ul>
                        </div>
                        <div class="size-field">
                            <div>
                                <label for="b_t-width">Ширина шины</label>
                                <input id="b_t-width" class="size-s" type="text">
                            </div>
                            <span>/</span>
                            <div>
                                <label for="b_t-height">Высота шины</label>
                                <input id="b_t-height" class="size-s" type="text">
                            </div>
                            <span>R</span>
                            <div>
                                <label for="b_radial">Диаметр</label>
                                <input id="b_radial" class="size-s" type="text">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-separator"></div>
            <!-- User contact info -->
            <div class="address-fields">
                <div class="row justify">
                    <div class="field">
                        <label for="b_city">Город</label>
                        <select id="b_city">
                            <option>Киев</option>
                            <option>Харьков</option>
                        </select>
                    </div>
                    <div class="field">
                        <label for="b_name">Ф.И.О.</label>
                        <input id="b_name" type="text">
                    </div>
                    <div class="field">
                        <label for="b_phone">Телефон</label>
                        <input id="b_phone" class="phone" type="text">
                    </div>
                    <div class="field">
                        <label for="b_email">Email</label>
                        <input id="b_email" type="text">
                    </div>
                </div>
                <div class="field">
                    <label for="b_add-info">Дополнительная информация</label>
                    <input id="b_add-info" class="size-fw" type="text">
                </div>
            </div>
        </div>
        <div class="order-submit">
            <button type="submit">ДОБАВИТЬ ЗАЯВКУ</button>
        </div>
    </form>
</div>
<!-- Second tab: sell -->
<div class="tab" data-role="tab">
</div>
<!-- Third tab: search -->
<div class="tab" data-role="tab">
    <form action="#" class="form form-order">
        <div class="order-options">
            <!-- Select disc or tyre -->
            <div class="row product-type">
                <ul class="opt-group" data-role="switcher" data-name="product-type">
                    <li>
                        <input id="s_tyre" data-target=".tyre-options" type="radio" name="product-type">
                        <label for="s_tyre">Шины</label>
                    </li>
                    <li>
                        <input id="s_disc" data-target=".disc-options" type="radio" name="product-type" checked>
                        <label for="s_disc">Диски</label>
                    </li>
                    <li>
                        <input id="s_car" data-target=".car-options" type="radio" name="product-type">
                        <label for="s_car">Машина</label>
                    </li>
                </ul>
                <ul class="opt-group">
                    <li>
                        <input type="radio" name="originality" id="s_new" checked >
                        <label for="s_new">Новые</label>
                    </li>
                    <li>
                        <input type="radio" name="originality" id="s_used">
                        <label for="s_used">Б/У</label>
                    </li>
                </ul>
                <div class="quantity">
                    <label for="s_qty">Количество</label>
                    <input id="s_qty" class="size-s" type="text" name="quantity">
                </div>
            </div>
            <div class="h-separator"></div>
            <!-- Tyres Options -->
            <div class="row tyre-options" data-name="product-type">
                <!-- Select brand -->
                <div class="area-brand">
                    <div class="row">
                        <div class="field align-left">
                            <label>Бренд</label>
                            <select>
                                <option value="">Все</option>
                                <option value="">America</option>
                                <option value="">Amtel</option>
                                <option value="">Arctic Claw</option>
                                <option value="">Autoguard</option>
                                <option value="">BCT</option>
                                <option value="">BFGoodrich</option>
                                <option value="">Blackstone</option>
                            </select>
                        </div>
                        <div class="field align-right">
                            <label>Модель</label>
                            <select>
                                <option>Все</option>
                                <option>model 1</option>
                                <option>model 2</option>
                                <option>model 3</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Select type and size -->
                <div class="area-type">
                    <!-- Tyre options -->
                    <div class="field">
                        <label>Сезон</label>
                        <ul class="opt-group justify">
                            <li>
                                <input type="checkbox" name="disc-type" id="s_season-1">
                                <label for="s_season-1">Летняя</label>
                            </li>
                            <li>
                                <input type="checkbox" name="disc-type" id="s_season-2">
                                <label for="s_season-2">Зимняя</label>
                            </li>
                            <li>
                                <input type="checkbox" name="disc-type" id="s_season-3">
                                <label for="s_season-3">Всесезонная</label>
                            </li>
                        </ul>
                    </div>
                    <div class="size-field">
                        <div>
                            <label for="s_t-width">Ширина шины</label>
                            <input id="s_t-width" class="size-s" type="text">
                        </div>
                        <span>/</span>
                        <div>
                            <label for="s_t-height">Высота шины</label>
                            <input id="s_t-height" class="size-s" type="text">
                        </div>
                        <span>R</span>
                        <div>
                            <label for="s_radial">Диаметр</label>
                            <input id="s_radial" class="size-s" type="text">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Disc Options -->
            <div class="row disc-options" data-name="product-type">
                <!-- Select brand -->
                <div class="area-brand">
                    <div class="row">
                        <div class="field align-left">
                            <label>Бренд</label>
                            <select>
                                <option value="">Все</option>
                                <option value="">K&amp;K</option>
                                <option value="">Kosei</option>
                                <option value="">Lenso</option>
                                <option value="">MOMO</option>
                                <option value="">Racing Wheels</option>
                            </select>
                        </div>
                        <div class="field align-right">
                            <label>Модель</label>
                            <select>
                                <option>Все</option>
                                <option>model 1</option>
                                <option>model 2</option>
                                <option>model 3</option>
                                <option>model 4</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Select type and size -->
                <div class="area-type">
                    <!-- Disc options -->
                    <div class="field">
                        <label>Тип диска</label>
                        <ul class="opt-group justify">
                            <li>
                                <input type="checkbox" name="disc-type" id="s_type-1">
                                <label for="s_type-1">Стальной</label>
                            </li>
                            <li>
                                <input type="checkbox" name="disc-type" id="s_type-2">
                                <label for="s_type-2">Литой</label>
                            </li>
                            <li>
                                <input type="checkbox" name="disc-type" id="s_type-3">
                                <label for="s_type-3">Кованный</label>
                            </li>
                        </ul>
                    </div>
                    <div class="size-field">
                        <div>
                            <label for="s_width">Ширина диска</label>
                            <input id="s_width" class="size-s" type="text">
                        </div>
                        <span>/</span>
                        <div>
                            <label for="s_fixture">Крепеж диска</label>
                            <input id="s_fixture" class="size-s" type="text">
                        </div>
                        <span>x</span>
                        <div>
                            <label for="s_pcd">PCD</label>
                            <input id="s_pcd" class="size-s" type="text">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row car-options" data-name="product-type">
                <div class="area-brand" style="border:0;">
                    <div class="row">
                        <div class="field align-left">
                            <label>Производитель</label>
                            <select>
                                <option value="">Все</option>
                                <option value="">Alfa Romeo</option>
                                <option value="">BMW</option>
                                <option value="">Ford</option>
                                <option value="">Mercedes</option>
                            </select>
                        </div>
                        <div class="field align-right">
                            <label>Модель</label>
                            <select>
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
</div>

</div>