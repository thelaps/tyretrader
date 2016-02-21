<?php /* Smarty version 2.6.26, created on 2016-02-21 12:56:57
         compiled from widget/cleanValues_editor.tpl */ ?>
<div class="widget_editor values_table">
    <button class="close">Закрыть</button>
    <button class="parameter_add">Добавить значение</button>
    <button class="parameter_delete" data-action="delete">Удалить значение</button>
    <fieldset>
        <legend>Список чистых значений v0.22a</legend>
        <div class="gridpanel">
            <div class="row">
                <div class="panel">
                    Значения параметра: <select name="values[parameter]"></select>
                </div>
                <div class="panel" style="display: none;">
                    по производителю: <select name="values[manufacturer_id]" disabled></select>
                </div>
            </div>
        </div>
        <div class="scrollLayer">
            <table>
                <tr>
                    <td>Оригинал</td>
                    <td>Синоним</td>
                    <td>Тип</td>
                </tr>
            </table>
        </div>
    </fieldset>
</div>

<form action="?view=admin_panel&load=api_panel&fnc=add" class="widget_editor add_edit_param">
    <button class="close">Закрыть</button>
    <fieldset>
        <legend>Добавить параметр</legend>
        <input type="hidden" name="fnc" value="parameter">
        <input type="hidden" name="type" value="">
        <input type="hidden" name="dict[parameter_id]" value="">
        <input type="hidden" name="dict[manufacturer_id]" value="" disabled>
        <input type="text" name="dict[name]" placeholder="Значение параметра" />

        <fieldset id="manufacturerParameters" style="display: none;">
            <legend>Параметры производителя</legend>
            <label>Тип производителя</label>
            <select name="manufacturer[type]">
                <option selected disabled="true" value=""> - </option>
                <option value="1">Шина</option>
                <option value="2">Диск</option>
            </select>
            <div id="manufacturerParameters_wheel_type" style="display: none;">
                <label>Тип диска</label>
                <select name="manufacturer[wheel_type]">
                    <option selected disabled="true" value=""> - </option>
                    <option value="1">Стальной</option>
                    <option value="2">Литой</option>
                    <option value="3">Кованый</option>
                    <option value="4">Составной</option>
                </select>
            </div>
        </fieldset>

        <fieldset id="modelParameters" style="display: none;">
            <legend>Параметры модели</legend>
            <label>Тип модели</label>
            <input class="modelLabelType" type="text" value="" disabled="true">
            <input type="hidden" name="model[type]" value="" readonly>
            <!--<select name="model[type]">
                <option selected disabled="true"> - </option>
                <option value="1">Шина</option>
                <option value="2">Диск</option>
            </select>-->
            <div class="gridpanel checkChange" data-type="2" style="display: none;">
                <div class="row">
                    <div class="panel">
                        <input type="hidden" name="model[src]" value="" class="imageUpload" disabled="true">
                        <textarea name="model[description]" placeholder="Описание" disabled="true"></textarea>
                    </div>
                    <div class="panel">
                        <script>
                            <?php echo '
                            $(document).ready(function(){
                                $(\'.MUmodelTyre\').microUploader(App.baseLink()+\'?view=admin_panel&load=api_panel&fnc=upload\',function(e){
                                    var json = App.ajax(e.response);
                                    $(\'.imageUpload[name="model[src]"]\').val(json.data);
                                });
                            });
                            '; ?>

                        </script>
                        <article class="MUholder">
                            <div class="microUploader MUmodelTyre">
                            </div>
                            <p class="hidden upload"><label>Drag & drop not supported, but you can still upload via this input field:<br><input type="file"></label></p>
                            <p class="filereader">File API & FileReader API not supported</p>
                            <p class="formdata">XHR2's FormData is not supported</p>
                            <p class="progress">XHR2's upload progress isn't supported</p>
                            <p><progress class="uploadprogress" min="0" max="100" value="0">0</progress></p>
                        </article>
                    </div>
                </div>
            </div>
            <div class="gridpanel checkChange" data-type="1" style="display: none;">
                <div class="row">
                    <div class="panel">
                        <label>Сезонность</label>
                        <select name="model[season]" disabled="true">
                            <option value="0" selected> - </option>
                            <option value="1">Зима</option>
                            <option value="2">Лето</option>
                            <option value="3">Всесезонка</option>
                        </select>
                        <label>Применение</label>
                        <select name="model[use]" disabled="true">
                            <option value="0" selected> - </option>
                            <option value="1">Автобусы</option>
                            <option value="2">Сельхозтехника</option>
                            <option value="3">Индустриальное</option>
                            <option value="4">Магистральное</option>
                            <option value="5">Региональное</option>
                            <option value="6">Смешанное</option>
                            <option value="7">All Terrain</option>
                            <option value="8">Mud Terrain</option>
                        </select>
                        <label>Тип транспорта</label>
                        <select name="model[type_transport]" disabled="true">
                            <option value="0" selected> - </option>
                            <option value="1">Легковой/4x4</option>
                            <option value="2">Легкогрузовой</option>
                            <option value="3">Индустриальный</option>
                            <option value="4">Грузовой</option>
                            <option value="5">Мото</option>
                        </select>
                        <label>Ось на авто</label>
                        <select name="model[axle]" disabled="true">
                            <option value="0" selected> - </option>
                            <option value="1">Рулевая</option>
                            <option value="2">Ведущая</option>
                            <option value="3">Прицепная</option>
                            <option value="4">Универсальная</option>
                        </select>
                        <input type="hidden" name="model[src]" value="" class="imageUpload" disabled="true">
                        <textarea name="model[description]" placeholder="Описание" disabled="true"></textarea>
                    </div>
                    <div class="panel">
                        <script>
                            <?php echo '
                            $(document).ready(function(){
                                $(\'.MUmodel\').microUploader(App.baseLink()+\'?view=admin_panel&load=api_panel&fnc=upload\',function(e){
                                    var json = App.ajax(e.response);
                                    $(\'.imageUpload[name="model[src]"]\').val(json.data);
                                });
                            });
                            '; ?>

                        </script>
                        <article class="MUholder">
                            <div class="microUploader MUmodel">
                            </div>
                            <p class="hidden upload"><label>Drag & drop not supported, but you can still upload via this input field:<br><input type="file"></label></p>
                            <p class="filereader">File API & FileReader API not supported</p>
                            <p class="formdata">XHR2's FormData is not supported</p>
                            <p class="progress">XHR2's upload progress isn't supported</p>
                            <p><progress class="uploadprogress" min="0" max="100" value="0">0</progress></p>
                        </article>
                    </div>
                </div>
            </div>
        </fieldset>
        <button class="save">Сохранить</button>
    </fieldset>
</form>