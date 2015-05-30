<?php /* Smarty version 2.6.26, created on 2015-05-29 22:13:13
         compiled from layout/header.tpl */ ?>
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
    <base href="<?php echo $this->_tpl_vars['baseLink']; ?>
/">

    <!-- Mobile Specific Metas
   ================================================== -->
    <!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->

    <!-- CSS
   ================================================== -->
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['src']; ?>
/stylesheets/base.css">
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['src']; ?>
/stylesheets/skeleton.css">
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['src']; ?>
/stylesheets/layout.css">
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['src']; ?>
/stylesheets/fancybox/jquery.fancybox-1.3.4.css">
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['src']; ?>
/stylesheets/form.css">
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['src']; ?>
/stylesheets/design.css">
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['src']; ?>
/stylesheets/ui-lightness/jquery-ui-1.10.4.custom.css">

    <!-- JS
   ================================================== -->
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['src']; ?>
/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['src']; ?>
/js/app/appregistry.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['src']; ?>
/js/jquery-ui.min.js"></script>
    <script>
        <?php echo '
        $(document).ready(function(){
            new App({
                dir:\''; ?>
<?php echo $this->_tpl_vars['src']; ?>
<?php echo '\',
                base:\''; ?>
<?php echo $this->_tpl_vars['baseLink']; ?>
/<?php echo '\'
            });
        });
        '; ?>

    </script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['src']; ?>
/js/app/app.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['src']; ?>
/js/jquery.fancybox-1.3.4.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['src']; ?>
/js/jcf.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['src']; ?>
/js/jcf.checkbox.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['src']; ?>
/js/jcf.radio.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['src']; ?>
/js/jcf.select.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['src']; ?>
/js/main.js"></script>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['src']; ?>
/js/html5.js"></script>
    <![endif]-->
    <?php echo '

    '; ?>


</head>
<body>
<div id="wrapper">
    <div id="wrapper-inner">
        <div id="head">
            <h1 class="logo">TYREMANAGER. Вам с нами по пути!</h1>
            <div class="head-banner">
                <img src="themes/wheels/src/images/banner.jpg" alt="banner">
            </div>
        </div>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "widget/profileBox.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>