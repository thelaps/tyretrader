<?php /* Smarty version 2.6.26, created on 2015-02-19 20:50:59
         compiled from price.tpl */ ?>
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



	<!-- Primary Page Layout
	================================================== -->

	<!-- Delete everything in this .container and get started on your own site! -->

<!-- Including the HTML5 Uploader plugin -->
<script src="<?php echo $this->_tpl_vars['src']; ?>
/js/jquery.filedrop.js"></script>
<!-- The main script file -->
<script src="<?php echo $this->_tpl_vars['src']; ?>
/js/md5.js"></script>
<script src="<?php echo $this->_tpl_vars['src']; ?>
/js/parser.js"></script>
<script src="<?php echo $this->_tpl_vars['src']; ?>
/js/script.js"></script>

<script>
    <?php echo '
    $.extraTab.parameters'; ?>
=<?php echo $this->_tpl_vars['viewData']['parameters']; ?>
<?php echo ';
    $.extraTab.manufacturers'; ?>
=<?php echo $this->_tpl_vars['viewData']['manufacturers']; ?>
<?php echo ';
    $.extraTab.semantic_manufacturers'; ?>
=<?php echo $this->_tpl_vars['viewData']['semantic']['manufacturers']; ?>
<?php echo ';
    $.extraTab.semantic_models'; ?>
=<?php echo $this->_tpl_vars['viewData']['semantic']['models']; ?>
<?php echo ';
    $.extraTab.extras'; ?>
=<?php echo $this->_tpl_vars['viewData']['extras']; ?>
<?php echo ';
    $.parser.collection.search_templates'; ?>
=<?php echo $this->_tpl_vars['viewData']['oSearchTemplates']; ?>
<?php echo '
    '; ?>

</script>
    <div id="ajaxStatus">
        <span></span>
    </div>
	<div class="container">
		<div class="sixteen columns head">
			<h4>Обработка прайсов</h4>

            <form name="priceProcessing" action="?view=admin_panel&load=price_panel&fnc=process">
                <div class="gridpanel">
                    <div class="row">
                        <div class="panel">
                            <link rel="stylesheet" href="<?php echo $this->_tpl_vars['src']; ?>
/stylesheets/styles.css" />
                            <ul id="errorList">

                            </ul>
                            <fieldset id="nextStep" style="display: none;">
                                <legend>Последний шаг*<sup>(будут использованы только распознанные значения)</sup></legend>
                                <button type="button" class="add_toDb">Добавить в базу данных</button>
                                <button type="button" class="excl_all">Очистить список несовпадений</button>
                            </fieldset>
                            <textarea id="finalLabel" style="width: 100%; height: 140px; display: none;" readonly="true"></textarea>
                            <div id="dropbox" data-action="<?php echo $this->_tpl_vars['baseLink']; ?>
/?view=admin_panel&load=price_panel&fnc=upload" data-process="<?php echo $this->_tpl_vars['baseLink']; ?>
/?view=admin_panel&load=price_panel&fnc=prepare">
                                <span class="message">Перетащите файл прайса сюда..<br /><i>(Открытие произойдет автоматически в 2 этапа)</i></span>
                            </div>
                        </div>
                        <div class="panel four">
                            <fieldset>
                                <legend>Настройка импорта</legend>
                                <button style="width: 100%; display: none;" class="saveExtraSettings">Сохранить шаблон</button>
                                <label for="company_id">Компания</label>
                                <select id="company_id" class="extraCompany" name="company_id">
                                    <option disabled selected value=""> - </option>
                                    <?php $_from = $this->_tpl_vars['viewData']['raw_companies']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['option']):
?>
                                    <option value="<?php echo $this->_tpl_vars['option']->id; ?>
"><?php echo $this->_tpl_vars['option']->name; ?>
</option>
                                    <?php endforeach; endif; unset($_from); ?>
                                </select>
                                <ul class="extraSettings">
                                </ul>
                                <button style="width: 100%; display: none;" class="saveExtraSettings">Сохранить шаблон</button>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <fieldset>
                    <legend id="eventLabel">Операции с прайсами</legend>
                    <button type="button" class="process">Обработать</button>
                    <button type="button" class="synonym_list">Синонимы (0.21a)</button>
                    <button type="button" class="values_list">Чистые значения (0.22a)</button>
                    <button type="button" class="company_editor">Поставщики (0.15a)</button>
                    <button type="button" class="locations_editor">Населенные пункты  (0.12a)</button>
                    <button type="button" class="currencyRate_editor">Курс валют  (0.13a)</button>
                    <button type="button" class="syncProcessor">Синхронизация каталогов)</button>
                </fieldset>
            </form>
		</div>
		<!--<div class="one-third column">
			<h3>Three Core Principles</h3>
			<p>JE is built on three core principles:</p>
			<ul class="square">
				<li><strong>A Responsive Grid Down To Mobile</strong>: Elegant scaling from a browser to tablets to mobile.</li>
				<li><strong>Fast to Start</strong>: It's a tool for rapid development with best practices</li>
				<li><strong>Style Agnostic</strong>: It provides the most basic, beautiful styles, but is meant to be overwritten.</li>
			</ul>
		</div>-->

	</div><!-- container -->
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'widget/manufacturer_editor.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'widget/cleanValues_editor.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'widget/company_editor.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'widget/locations_editor.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'widget/currencyRate_editor.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'layout/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>