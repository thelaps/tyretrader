<?php /* Smarty version 2.6.26, created on 2016-01-17 23:18:21
         compiled from container/forms/tyreRadiusComercial.tpl */ ?>
<select class="jcf-ignore" id="<?php echo $this->_tpl_vars['id']; ?>
" name="tyre[size_r][]" style="width: 76px;">
    <?php if ($this->_tpl_vars['isAll']): ?>
        <option value="">Все</option>
    <?php endif; ?>
    <option value="17.5">17,5</option>
    <option value="19.5">19.5</option>
    <option value="22.5"<?php if (! $this->_tpl_vars['isAll']): ?> selected="selected"<?php endif; ?>>22.5</option>
</select>