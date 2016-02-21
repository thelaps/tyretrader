
                <footer id="footer">
                    <a id="to-top" class="link-to-top" href="#head">ВВЕРХ</a>
                    <ul class="link-group">
                        <li><a href="{$baseLink}/">Главная</a></li>
                        <li><a href="{$baseLink}?load=opt">Опт</a></li>
                        <li><a href="{$baseLink}">Покупка</a></li>
                        <li><a href="{$baseLink}/?load=sold">Продажа</a></li>
                        <li><a href="{$baseLink}">Реклама</a></li>
                        <li><a href="{$baseLink}">Политика конфиденциальности</a></li>
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
        {if $viewData->resetHandler != 0}
        <div id="dialog-auto">{if $viewData->resetHandler == 1}Сброс пароля успешно завершен. Проверьте почту.{else}Сброс пароля прерван.{/if}</div>
        {/if}
    </body>
</html>