<?php /* Smarty version 2.6.26, created on 2013-03-25 20:57:41
         compiled from widget/random_posts.tpl */ ?>
<div class="one-third column">
    <h4>Интересное</h4>
    <ul class="relatedPosts">
    <?php $_from = $this->_tpl_vars['viewData']['posts_widget']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['post']):
?>
        <li><a href="?view=posts&id=<?php echo $this->_tpl_vars['post']->id; ?>
"><img src="<?php echo $this->_tpl_vars['post']->src; ?>
" title="<?php echo $this->_tpl_vars['post']->title; ?>
"><?php echo $this->_tpl_vars['post']->title; ?>
</a></li>
    <?php endforeach; endif; unset($_from); ?>
    </ul>
</div>