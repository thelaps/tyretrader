{include file='layout/header.tpl'}
{include file='layout/menu.tpl'}



	<!-- Primary Page Layout
	================================================== -->

	<!-- Delete everything in this .container and get started on your own site! -->

<!-- Including the HTML5 Uploader plugin -->
<script src="{$src}/js/jquery.filedrop.js"></script>
<!-- The main script file -->
<script src="{$src}/js/md5.js"></script>
<script src="{$src}/js/parser.js"></script>
<script src="{$src}/js/script.js"></script>

<script>
    {literal}
    $.extraTab.parameters{/literal}={$viewData.parameters}{literal};
    $.extraTab.manufacturers{/literal}={$viewData.manufacturers}{literal};
    $.extraTab.semantic_manufacturers{/literal}={$viewData.semantic.manufacturers}{literal};
    $.extraTab.semantic_models{/literal}={$viewData.semantic.models}{literal};
    $.extraTab.extras{/literal}={$viewData.extras}{literal};
    $.parser.collection.search_templates{/literal}={$viewData.oSearchTemplates}{literal}
    {/literal}
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
                            <link rel="stylesheet" href="{$src}/stylesheets/styles.css" />
                            <ul id="errorList">

                            </ul>
                            <fieldset id="nextStep" style="display: none;">
                                <legend>Последний шаг*<sup>(будут использованы только распознанные значения)</sup></legend>
                                <button type="button" class="add_toDb">Добавить в базу данных</button>
                                <button type="button" class="excl_all">Очистить список несовпадений</button>
                            </fieldset>
                            <textarea id="finalLabel" style="width: 100%; height: 140px; display: none;" readonly="true"></textarea>
                            <div id="dropbox" data-action="{$baseLink}/?view=admin_panel&load=price_panel&fnc=upload" data-process="{$baseLink}/?view=admin_panel&load=price_panel&fnc=prepare">
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
                                    {foreach item=option from=$viewData.raw_companies}
                                    <option value="{$option->id}">{$option->name}</option>
                                    {/foreach}
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
    {include file='widget/manufacturer_editor.tpl'}
    {include file='widget/cleanValues_editor.tpl'}
    {include file='widget/company_editor.tpl'}
    {include file='widget/locations_editor.tpl'}
    {include file='widget/currencyRate_editor.tpl'}

{include file='layout/footer.tpl'}