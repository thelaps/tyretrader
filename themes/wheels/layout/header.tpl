<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>

    <!-- Basic Page Needs
   ================================================== -->
    <meta charset="utf-8">
    <title>Automanager</title>
    <meta name="description" content="">
    <meta name="author" content="">
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

    {/literal}

</head>
<body>
<div id="wrapper">
    <div id="wrapper-inner">
        <div id="head">
            <a class="logo" href="{$baseLink}">TYREMANAGER. Вам с нами по пути!</a>
            <div class="head-banner">
                <img src="themes/wheels/src/images/banner.jpg" alt="banner">
            </div>
        </div>
        {include file="widget/profileBox.tpl"}