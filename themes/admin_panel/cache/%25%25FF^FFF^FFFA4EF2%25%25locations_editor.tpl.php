<?php /* Smarty version 2.6.26, created on 2013-09-14 03:06:54
         compiled from widget/locations_editor.tpl */ ?>
<div class="widget_editor locations_table">
    <button class="close">Закрыть</button>
    <button class="locations_add" data-action="add">Добавить нас. пункт</button>
    <button class="locations_delete" data-action="delete">Удалить нас. пункт</button>
    <fieldset>
        <legend>Список населенных пунктов v0.12a</legend>
        <div class="scrollLayer">
            <table>
                        </table>
        </div>
    </fieldset>
</div>

<form action="?view=admin_panel&load=api_panel&fnc=add" class="widget_editor add_edit_locations">
    <button class="close">Закрыть</button>
    <fieldset>
        <legend class="locationsLegend">Добавить населенный пункт</legend>
        <input type="hidden" name="fnc" value="locations">
        <input type="hidden" name="locations[id]" value="">
        <input type="text" name="locations[name]" value="" placeholder="Город">
        <label>Регион</label>
        <select name="locations[region_id]">
        <?php $_from = $this->_tpl_vars['viewData']['city']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['locations']):
?>
            <option value="<?php echo $this->_tpl_vars['locations']['0']->region_id; ?>
"><?php echo $this->_tpl_vars['key']; ?>
</option>
        <?php endforeach; endif; unset($_from); ?>
        </select>
        <button class="save">Сохранить</button>
    </fieldset>
</form>