<?php /* Smarty version 2.6.26, created on 2015-02-28 15:46:14
         compiled from container/forms/tyreRadiusComercial.tpl */ ?>
<select id="<?php echo $this->_tpl_vars['id']; ?>
" name="tyre[size_r][]" style="width: 76px;">
    <?php if ($this->_tpl_vars['isAll']): ?>
        <option value="">Все</option>
    <?php endif; ?>
    <option value="13">13c</option>
    <option value="14">14c</option>
    <option value="15">15c</option>
    <option value="16"<?php if (! $this->_tpl_vars['isAll']): ?> selected="selected"<?php endif; ?>>16c</option>
</select>