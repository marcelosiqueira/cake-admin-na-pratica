<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="pt-br" class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title><?php echo $title_for_layout?> - Before</title>
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <meta name="robots" content="noindex">
  
  <meta name="viewport" content="width=device-width">

  <?php 
  echo $this->Html->meta(
    'favicon.ico',
    '/favicon.ico',
    array('type' => 'icon')
  );
  echo $this->fetch('meta');
  echo $this->Html->css(array(
    'bootstrap.min.css', 
    'font-awesome.min.css',
    'login.css'
  ));
  echo $this->fetch('css');
  ?>
  <!--[if IE 7]>
    <?php echo $this->Html->css('font-awesome-ie7.min'); ?>
  <![endif]-->
</head>
<body>
  <div class="container">
    <?php echo $this->fetch('content'); ?>
  </div>

  <?php
  echo $this->Html->script(array(
    'http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'
  ));
  ?>
  <script>!window.jQuery && document.write('<script src="/vaitershow/js/jquery-1.8.3.min.js"><\/script>');</script>
  <?php
  echo $this->Html->script(array(
    'bootstrap.min.js',
    'jquery.placeholder.min.js'
  ));
  ?>  
  <?php echo $this->fetch('script'); ?>
  <script>$('input[placeholder], textarea[placeholder]').placeholder();</script>
</body>
</html>

