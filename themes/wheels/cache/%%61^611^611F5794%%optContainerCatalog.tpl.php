<?php /* Smarty version 2.6.26, created on 2016-01-19 02:07:05
         compiled from container/forms/optContainerCatalog.tpl */ ?>
<script>
    <?php echo '
    $(document).ready(function(){
        $(\'.clientSwitcher\').bind({
            click: function(){
                var member = $(this).find(\'.member\');
                var team = $(this).find(\'.team\');
                var table = $(\'.ajaxContent\');
                member.toggleClass(\'active\');
                team.toggleClass(\'active\');
                if (team.hasClass(\'active\')) {
                    table.removeClass(\'hideFields\');
                } else {
                    table.addClass(\'hideFields\');
                }
            }
        });
    });
    '; ?>

</script>
<div id="optHolder" style="display: none;">
    <div class="serviceHolder">
        <div class="clientSwitcher">
            <div class="member"></div>
            <div class="team active"></div>
        </div>
        <div class="commercialSystem">
            <label>Коммерческое предложение с</label>
            <input type="text" value="20" id="catalogAmounts">
            <label>позициями</label>
            <button class="system createPriceList">Создать</button>
        </div>
    </div>

    <div class="ajaxContent">
        <div class="resultHolder">
            <div class="amount">
                Найдено <b><?php echo $this->_tpl_vars['viewData']->container['opt']->total; ?>
</b> записей
            </div>
            <div class="note">
                Уточняйте наличие шипов в шинах у поставщиков, если это не указано в характеристиках
            </div>
        </div>
        <table class="mainTable"></table>
    </div>
</div>
<div id="pageContent">
    <h5><?php echo $this->_tpl_vars['viewData']->_content->title; ?>
</h5>
    <p><?php echo $this->_tpl_vars['viewData']->_content->content; ?>
</p>
</div>