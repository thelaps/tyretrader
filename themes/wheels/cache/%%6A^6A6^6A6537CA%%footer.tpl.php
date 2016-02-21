<<<<<<< HEAD
<?php /* Smarty version 2.6.26, created on 2016-02-21 12:33:07
=======
<?php /* Smarty version 2.6.26, created on 2016-01-18 19:01:57
>>>>>>> 0065ad3cc2f23cd4dcb380c900a80bb1ac56d3d7
         compiled from layout/footer.tpl */ ?>

                <footer id="footer">
                    <a id="to-top" class="link-to-top" href="#head">ВВЕРХ</a>
                    <ul class="link-group">
                        <li><a href="<?php echo $this->_tpl_vars['baseLink']; ?>
/">Главная</a></li>
                        <li><a href="<?php echo $this->_tpl_vars['baseLink']; ?>
?load=opt">Опт</a></li>
                        <li><a href="<?php echo $this->_tpl_vars['baseLink']; ?>
">Покупка</a></li>
                        <li><a href="<?php echo $this->_tpl_vars['baseLink']; ?>
/?load=sold">Продажа</a></li>
                        <li><a href="<?php echo $this->_tpl_vars['baseLink']; ?>
">Реклама</a></li>
                        <li><a href="<?php echo $this->_tpl_vars['baseLink']; ?>
">Политика конфиденциальности</a></li>
                    </ul>
                    <ul class="social">
                        <li><a class="ico ico-facebook" target="_blank" href="https://www.facebook.com/automanagerua/">facebook</a></li>
                        <li><a class="ico ico-vk" target="_blank" href="http://vk.com/automanagerua">vk</a></li>
                    </ul>
                </footer>
            </div>
        </div>
        <div id="dialog-error">
            <span class="errorTitle"></span>
            <ul class="errorList"></ul>
        </div>
        <div id="dialog-ajax">
            <span class="ajaxTitle"></span>
            <div class="ajaxContent"></div>
            <div id="progressbar"></div>
        </div>
        <?php if ($this->_tpl_vars['viewData']->resetHandler != 0): ?>
        <div id="dialog-auto"><?php if ($this->_tpl_vars['viewData']->resetHandler == 1): ?>Сброс пароля успешно завершен. Проверьте почту.<?php else: ?>Сброс пароля прерван.<?php endif; ?></div>
        <?php endif; ?>
    </body>
</html>