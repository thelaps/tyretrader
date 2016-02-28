<div id="main">
{*include file="container/forms/mainContainerForm.tpl"}
{include file="container/forms/mainContainerCatalog.tpl"*}
</div>
<div class="container">

    <div class="one-third column">
        {$viewData->_contentmodel->getBanner('BANNER_1')}
    </div>
    <div class="one-third column">
        {$viewData->_contentmodel->getBanner('BANNER_2')}
    </div>
    <div class="one-third column">
        {$viewData->_contentmodel->getBanner('BANNER_3')}
    </div>

    <div class="sixteen columns head">
        <h1 class="remove-bottom" style="margin-top: 40px"><span class="errorMessage">{$viewData->_content->title}</span></h1>
        <h5>Beta-версия</h5>
        <hr />
    </div>
    <div class="one-third column">
        <h3>Информация</h3>
        <p>В режиме бета тестирования все функции сайта доступны зарегистрированным пользователям</p>
        <p>
            По мере реализации будут доступны так же и для незарегистрированных
        </p>
    </div>
    <div class="one-third column">
        <h3>Отдел обработки</h3>
        <ul class="square">
            <li>{$viewData->_contentmodel->getText('MANAGER_PHONE_1')}</li>
            <li>{$viewData->_contentmodel->getText('MANAGER_EMAIL_1')}</li>
        </ul>
    </div>
    <div class="one-third column">
        <h3>Тех. поддержка</h3>
        <!--<p>Тех. поддержка:</p>-->
        <ul class="square">
            <li>{$viewData->_contentmodel->getText('SUPPORT_PHONE_1')}</li>
            <li>{$viewData->_contentmodel->getText('SUPPORT_EMAIL_1')}</li>
        </ul>
    </div>

</div>