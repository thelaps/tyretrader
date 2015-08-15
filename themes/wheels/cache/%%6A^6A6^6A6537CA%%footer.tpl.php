<?php /* Smarty version 2.6.26, created on 2015-08-15 08:34:27
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
                        <li><a class="ico ico-facebook" href="#">facebook</a></li>
                        <li><a class="ico ico-twitter" href="#">twitter</a></li>
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