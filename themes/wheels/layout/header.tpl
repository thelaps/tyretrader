<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>

    <!-- Basic Page Needs
   ================================================== -->
    <meta charset="utf-8">
    <title>{$viewData->_content->meta_title}</title>
    <meta name="description" content="{$viewData->_content->meta_description}">
    <meta name="keywords" content="{$viewData->_content->meta_keywords}">
    <base href="{$baseLink}/">

    <!-- Mobile Specific Metas
   ================================================== -->
    <!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->

    <!-- CSS
   ================================================== -->
    <link rel="stylesheet" href="{$src}/stylesheets/base.css">
    <link rel="stylesheet" href="{$src}/stylesheets/skeleton.css">
    <link rel="stylesheet" href="{$src}/stylesheets/layout.css">
    <link rel="stylesheet" href="{$src}/stylesheets/fancybox/jquery.fancybox-1.3.4.css">
    <link rel="stylesheet" href="{$src}/stylesheets/form.css">
    <link rel="stylesheet" href="{$src}/stylesheets/design.css">
    <link rel="stylesheet" href="{$src}/stylesheets/ui-lightness/jquery-ui-1.10.4.custom.css">
    <link rel="stylesheet" href="{$src}/js/select2/css/select2.css">
    <link rel="shortcut icon" href="{$src}/images/favicon.png">

    <!-- JS
   ================================================== -->
    <script type="text/javascript" src="{$src}/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="{$src}/js/app/appregistry.js"></script>
    <script type="text/javascript" src="{$src}/js/jquery-ui.min.js"></script>
    <script>
        {literal}
        $(document).ready(function(){
            new App({
                dir:'{/literal}{$src}{literal}',
                base:'{/literal}{$baseLink}/{literal}'
            });
        });
        {/literal}
    </script>
    <script type="text/javascript" src="{$src}/js/app/app.js"></script>
    <script type="text/javascript" src="{$src}/js/jquery.fancybox-1.3.4.js"></script>
    <script type="text/javascript" src="{$src}/js/jcf.js"></script>
    <script type="text/javascript" src="{$src}/js/jcf.checkbox.js"></script>
    <script type="text/javascript" src="{$src}/js/jcf.radio.js"></script>
    <!--<script type="text/javascript" src="{$src}/js/jcf.select.js"></script>-->
    <script type="text/javascript" src="{$src}/js/select2/js/select2.min.js"></script>
    <script type="text/javascript" src="{$src}/js/main.js"></script>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="{$src}/js/html5.js"></script>
    <![endif]-->
    {literal}
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-68484404-1', 'auto');
            ga('send', 'pageview');

        </script>
    {/literal}

</head>
<body>
<div id="wrapper">
    <div id="wrapper-inner">
        <div id="head">
            <a class="logo" href="{$baseLink}">TYREMANAGER. Вам с нами по пути!</a>
            <div class="head-banner">
                <img src="{$viewData->_banner->content}" alt="banner" title="{$viewData->_banner->title}">
            </div>
        </div>
        {include file="widget/profileBox.tpl"}