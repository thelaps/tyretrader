<?php /* Smarty version 2.6.26, created on 2016-01-26 23:41:24
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
/?view=admin_panel&load=content_panel" method="POST" class="editableForm sixteen columns">
        <input type="hidden" name="fnc" value="<?php if ($this->_tpl_vars['viewData']['content']->id != null): ?>update<?php else: ?>add<?php endif; ?>">
        <input type="hidden" name="type" value="<?php echo $this->_tpl_vars['viewData']['_type']; ?>
">
        <?php if ($this->_tpl_vars['viewData']['content']->id != null): ?>
            <input name="content[id]" type="hidden" value="<?php echo $this->_tpl_vars['viewData']['content']->id; ?>
">
        <?php endif; ?>
        <label>Активно?</label>
        <input name="content[status]" type="checkbox" <?php if ($this->_tpl_vars['viewData']['content']->status == 1): ?>checked <?php endif; ?>value="1">

    <?php if ($this->_tpl_vars['viewData']['_type'] == 'content'): ?>
        <?php if ($this->_tpl_vars['viewData']['content']->type == 1 || $this->_tpl_vars['viewData']['content']->type == 2): ?>
            <label>Заголовок</label>
            <input name="content[title]" type="text" value="<?php echo $this->_tpl_vars['viewData']['content']->title; ?>
">
            <label>Описание (метка для удобства)</label>
            <input name="content[description]" type="text" value="<?php echo $this->_tpl_vars['viewData']['content']->description; ?>
">
            <label>Основной текст</label>
            <textarea name="content[content]"><?php echo $this->_tpl_vars['viewData']['content']->content; ?>
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
    <?php endif; ?>
        <button type="submit">OK</button>
    </form>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'layout/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>