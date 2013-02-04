<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="pt-br" class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title><?php echo $title_for_layout?> - Teste de admin</title>
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
    'datepicker.css',
    'admin.css'
  ));
  echo $this->fetch('css');
  ?>
  <!--[if IE 7]>
    <?php echo $this->Html->css('font-awesome-ie7.min'); ?>
  <![endif]-->
</head>
<body>
  <!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
  <!-- header -->
  <header>
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand logo" href="/">Teste de admin</a>
          <div class="nav-collapse">
            <ul class="nav pull-right">
              <li>
                <?php echo $this->Html->link('<i class="icon-desktop"></i> Produtos', '/admin/products', array('escape'=>false, 'title'=>'Eventos'))?>
              </li>
              <li>
                <?php echo $this->Html->link('<i class="icon-sitemap"></i> Categorias', '/admin/categories', array('escape'=>false, 'title'=>'Artistas'))?>
              </li>
              <li class="divider-vertical"></li>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
              	  <i class="icon-user"></i> <?php echo $this->Session->read('Auth.User.name'); ?>
              	  <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li><?php echo $this->Html->link('<i class="icon-cog"></i> Usuários', '/admin/users', array('escape'=>false, 'title'=>'Usuários'))?></li>
                  <li class="divider"></li>
                  <li><?php echo $this->Html->link('<i class="icon-off"></i> Sair', '/admin/users/logout', array('escape'=>false, 'title'=>'Sair'))?></li>
                </ul>
		          </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
  </header>
  
  <!-- content -->
  <div id="wrap">
    <div id="push"></div>
    <div class="container">
      <?php echo $this->fetch('content'); ?>
    </div>
    <div id="push"></div>
  </div>

  <!-- footer -->
  <footer>
    <div class="container">
      <div class="row">
       Teste de admin - <?php echo $this->Html->link('Marcelo Siqueira', 'http://marcelosiqueira.com.br', array('target'=>'_blank', 'title'=>'Marcelo Siqueira'))?> 
      </div>
    </div>
  </footer>

  <?php
  echo $this->Html->script(array(
    'http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'
  ));
  ?>
  <script>!window.jQuery && document.write('<script src="/vaitershow/js/jquery-1.8.3.min.js"><\/script>');</script>
  <?php
  echo $this->Html->script(array(
    'bootstrap.min.js',
    'bootstrap-datepicker.js',
    'jquery.placeholder.min.js',
    'admin.js'
  ));
  ?>  
  <?php echo $this->fetch('script'); ?>
  <?php echo $this->element('sql_dump'); ?>
  <script>$('input[placeholder], textarea[placeholder]').placeholder();</script>
</body>
</html>
