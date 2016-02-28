<?php /* Smarty version 2.6.26, created on 2016-02-23 21:35:47
         compiled from primitiveForms/content_edit.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'layout/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'layout/menu.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['viewData']['content']->type == 1 || $this->_tpl_vars['viewData']['content']->type == 2): ?>
<script src="<?php echo $this->_tpl_vars['src']; ?>
/js/ckeditor/ckeditor.js"></script>
<?php echo '
<script>
    $(document).ready(function(){
        CKEDITOR.replace(\'content_editor\');
    });
</script>
'; ?>

<?php endif; ?>
<div id="ajaxStatus">
    <span></span>
</div>
<div class="container">
    <div class="sixteen columns head">
        <h5>Редактирование <?php if ($this->_tpl_vars['viewData']['_type'] == 'content'): ?><?php echo $this->_tpl_vars['viewData']['content']->description; ?>
<?php elseif ($this->_tpl_vars['viewData']['_type'] == 'package'): ?><?php echo $this->_tpl_vars['viewData']['content']->title; ?>
 <?php echo $this->_tpl_vars['viewData']['content']->cost; ?>
<?php endif; ?></h5>
        <hr />
    </div>
    <form action="<?php echo $this->_tpl_vars['baseLink']; ?>
/?view=admin_panel&load=content_panel" method="POST" enctype="multipart/form-data" class="editableForm sixteen columns">
        <input type="hidden" name="fnc" value="<?php if ($this->_tpl_vars['viewData']['content']->id != null): ?>update<?php else: ?>add<?php endif; ?>">
        <input type="hidden" name="type" value="<?php echo $this->_tpl_vars['viewData']['_type']; ?>
">
        <?php if ($this->_tpl_vars['viewData']['content']->id != null): ?>
            <input name="content[id]" type="hidden" value="<?php echo $this->_tpl_vars['viewData']['content']->id; ?>
">
        <?php endif; ?>
        <ul>
            <li>
                <label>
                    <input name="content[status]" type="hidden" value="0">
                    <input name="content[status]" type="checkbox" <?php if ($this->_tpl_vars['viewData']['content']->status == 1): ?>checked <?php endif; ?>value="1">
                    Активно?
                </label>
            </li>
        </ul>

    <?php if ($this->_tpl_vars['viewData']['_type'] == 'content'): ?>
        <?php if ($this->_tpl_vars['viewData']['content']->type == 1 || $this->_tpl_vars['viewData']['content']->type == 2): ?>
            <label>Заголовок</label>
            <input name="content[title]" type="text" value="<?php echo $this->_tpl_vars['viewData']['content']->title; ?>
">
            <label>Описание (метка для удобства)</label>
            <input name="content[description]" type="text" value="<?php echo $this->_tpl_vars['viewData']['content']->description; ?>
">
            <label>Основной текст</label>
            <textarea name="content[content]" id="content_editor"><?php echo $this->_tpl_vars['viewData']['content']->content; ?>
</textarea>
            <label>META Title</label>
            <input name="content[meta_title]" type="text" value="<?php echo $this->_tpl_vars['viewData']['content']->meta_title; ?>
">
            <label>META Keywords</label>
            <input name="content[meta_keywords]" type="text" value="<?php echo $this->_tpl_vars['viewData']['content']->meta_keywords; ?>
">
            <label>META Description</label>
            <input name="content[meta_description]" type="text" value="<?php echo $this->_tpl_vars['viewData']['content']->meta_description; ?>
">
        <?php endif; ?>
        <?php if ($this->_tpl_vars['viewData']['content']->type == 4): ?>
            <label>Описание (метка для удобства)</label>
            <input name="content[description]" type="text" value="<?php echo $this->_tpl_vars['viewData']['content']->description; ?>
">
            <label>Данные блока</label>
            <textarea name="content[content]"><?php echo $this->_tpl_vars['viewData']['content']->content; ?>
</textarea>
        <?php endif; ?>
    <?php elseif ($this->_tpl_vars['viewData']['_type'] == 'package'): ?>
        <label>Стоимость</label>
        <input name="content[cost]" type="text" value="<?php echo $this->_tpl_vars['viewData']['content']->cost; ?>
">
        <label>Срок мес.</label>
        <input name="content[amount]" type="text" value="<?php echo $this->_tpl_vars['viewData']['content']->amount; ?>
">
        <label>Название</label>
        <input name="content[title]" type="text" value="<?php echo $this->_tpl_vars['viewData']['content']->title; ?>
">
        <label>Описание</label>
        <textarea name="content[description]"><?php echo $this->_tpl_vars['viewData']['content']->description; ?>
</textarea>
    <?php elseif ($this->_tpl_vars['viewData']['_type'] == 'banner'): ?>
        <label>Описание</label>
        <input name="content[description]" type="text" value="<?php echo $this->_tpl_vars['viewData']['content']->description; ?>
">
        <input type="hidden" name="content[type]" value="3">
        <ul>
            <li><label><input type="radio" value="image" name="content[subtype]" <?php if ($this->_tpl_vars['viewData']['content']->subtype == 'image'): ?> checked<?php endif; ?>> Изображение</label></li>
            <li><label><input type="radio" value="code" name="content[subtype]" <?php if ($this->_tpl_vars['viewData']['content']->subtype == 'code'): ?> checked<?php endif; ?>> Код (flash/javascript)*</label></li>
        </ul>
        <input type="hidden" name="content[content]" value="<?php echo $this->_tpl_vars['viewData']['content']->content; ?>
">
        <textarea data-subtype="code" name="content[content]" <?php if ($this->_tpl_vars['viewData']['content']->subtype != 'code'): ?> style="display: none;" disabled <?php endif; ?>><?php echo $this->_tpl_vars['viewData']['content']->content; ?>
</textarea>
        <label data-subtype="image"<?php if ($this->_tpl_vars['viewData']['content']->subtype != 'image'): ?> style="display: none;" disabled <?php endif; ?>>Загрузить</label>
        <input data-subtype="image" name="banner_content" type="file"<?php if ($this->_tpl_vars['viewData']['content']->subtype != 'image'): ?> style="display: none;" disabled <?php endif; ?>>
        <div class="clear"></div>
    <hr/>
    <?php endif; ?>
        <button type="submit">Сохранить</button>
    </form>
</div>
<?php if ($this->_tpl_vars['viewData']['_type'] == 'banner'): ?>
<?php echo '
<script>
    function _handleBannerType(){
        var _subtype = $(\'[name="content[subtype]"]:checked\').val();
        switch (_subtype){
            case \'image\':
                $(\'[data-subtype="code"]\').attr(\'disabled\', true).hide();
                $(\'[data-subtype="image"]\').removeAttr(\'disabled\');
                $(\'[data-subtype="image"]\').show();
                break;
            case \'code\':
                $(\'[data-subtype="image"]\').attr(\'disabled\', true).hide();
                $(\'[data-subtype="code"]\').removeAttr(\'disabled\');
                $(\'[data-subtype="code"]\').show();
                break;
        }
    }
    $(document).ready(function(){
        _handleBannerType();

        $(\'[name="content[subtype]"]\').bind({
            change: function(){
                _handleBannerType();
            }
        });
    });
</script>
'; ?>

<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'layout/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>