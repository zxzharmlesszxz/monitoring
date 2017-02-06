<?php

/* Script security */
if(!defined("MONENGINE")) {
 header("Location: index.php");
 exit();
}

$title = (isset($page_title)) ? $page_title : $settings['site_name'];
$icon = (file_exists(IMAGES.'favicon.ico')) ? "<link rel='shortcut icon' href='".IMAGES."favicon.ico' type='image/x-icon' />" : '';

$games_menu = games_menu();
$modes_menu = modes_menu();

echo <<<EOT
<!DOCTYPE html>
<html>
 <head>
  <META NAME="Author" CONTENT="cook">
  <META NAME="Subject" CONTENT="Мониторинг игровых серверов CS 1.6 CS:S CS:GO :: WG">
  <META NAME="Description" CONTENT="Мониторинг поддерживает самые популярные игры CS 1.6 CS:S CS:GO. У нас вы можете раскрутить сервер, Добавить сервер, найти сервер для игры, Скачать мастер сервер">
  <META NAME="Keywords" CONTENT="Мониторинг серверов cs 1.6, css, csgo, сервера кс, counter-strike сервера, игровой мониторинг, сервера css, csgo сервера, классик сервера, зомби сервера, стим сервера, cs:cz сервера, скачать cs 1.6">
  <META NAME="Copyright" CONTENT="Мониторинг игровых серверов: WG">
  <META NAME="Language" CONTENT="Russian">
  <META NAME="Robots" CONTENT="All">
  <meta name="revisit-after" content="1 day">
  <meta name="distribution" content="Global">
  <meta name="rating" content="General">
  <meta name="copyright" content="Copyright © 2014">
  <meta name="cypr-verification" content="df9b877027745edce833e2dba8399189">
  <meta name="google-site-verification" content="Au5rwzYBo9sBRTDfWnc0JeMEc99hD-nQXasfWNTVA2w">
  <script type='text/javascript' src='/templates/js/jquery-1.7.2.min.js'></script>
  <script type='text/javascript' src='/templates/js/cookies.js'></script>
  <script type='text/javascript' src='/templates/js/jquery.cookies.js'></script>
  <script type='text/javascript' src='/templates/js/jquery.dataTables.min.js'></script>
  <link rel="stylesheet" type="text/css" href="/templates/css/jquery.dataTables.min.css">
  <link href='/templates/css/mainstyle.css' rel='stylesheet' type='text/css' media='all'>
  <link href='/templates/css/style.css' rel='stylesheet' type='text/css'>
  <script type="text/javascript">
   $(document).ready(function(){
    // DataTable jquery plugin
    //var table = $('#table').DataTable({"stateSave": true});
    var table = $('table.servers').DataTable({
     "bPaginate": true,
     "order": [],
     language: {
      search: "_INPUT_",
      searchPlaceholder: "{$locale['024']}",
      "emptyTable": "{$locale['017']}",
      "info": "{$locale['023']}",
      "infoFiltered": "{$locale['025']}",
      "lengthMenu": "{$locale['026']}",
     }
    });
    //$('table.servers thead tr th').each(function(){var title = $('table.servers thead tr th').eq($(this).index()).text();$(this).html('<input type="text" placeholder="'+title+'" />');});

    // Apply the search
    //if(table.columns().eq(0)){table.columns().each(function(colIdx){$('input', table.column(colIdx).footer()).on('keyup change', function(){table.column(colIdx).search(this.value).draw();});});}
  });
  </script>
  <!-- Put this script tag to the <head> of your page -->
  <script type="text/javascript" src="//vk.com/js/api/openapi.js?116"></script>
  <script type="text/javascript">
   VK.init({apiId: 4747746, onlyWidgets: true});
  </script>
  <base href='{$settings['site_url']}'>
  <title>{$title}</title>
  {$icon}
 </head>
 <body>
  <!-- Wrapper -->
  <div class="wrapper">
   <!-- Header -->
   <div id="header">
    <!-- Header_start -->
    <div id="header_stat">
     <a id="header_stat_logo" href="/"></a>
     <div id="header_stat_main">
      <div id="stats">
       Всего игровых серверов в мониторинге: <span class="servers_online">{$servers_total}</span> серверов, из них <span class="servers_online">{$servers_online}</span> серверов онлайн.<br />
       Самая популярная карта: <span class="servers_online">de_dust2_2x2</span>. Последние обновление было: <span class="servers_online">{time() - $settings['last_update']}</span> секунд(ы) назад.
      </div>
      <div id="header_stat_search">
       <form action="/search/" method="POST">
        <input type="text" placeholder="Быстрый поиск" name="search">
       </form>
      </div>
     </div>
    </div>
    <!-- /Header_start -->
    <!-- Navigation -->
    <div id="horizontal_menu">
     <ul>
      <li><a title="Главная страница" href="/" rel="follow">Главная</a></li>
      <li><a title="Добавить свой игровой сервер" href="/add" rel="follow">Добавить сервер</a></li>
      <li><a title="Найти сервер для игры" href="/search" rel="follow">Найти сервер</a></li>
      <li><a title="Редактировать свой сервер" href="/edit" rel="follow">Редактирование</a></li>
      <li><a title="VIP/TOP/Выделение цветом для серверов" href="/pay" rel="follow">Бесплатные услуги</a></li>
      <li><noindex><a title="Наш форум сайта" href=" https://contra.net.ua" target="_blank" rel="nofollow">Наш сайт</a></noindex></li>
      <li><a title="Наши контактные данные" href="/feedback" rel="nofollow">Контакты</a></li>
      <li><a title="Каталог интернет сайтов" href="/links" rel="nofollow">Партнеры</a></li>
      <li><a title="Наш мастерсервер" href="/mserv" rel="follow">Мастерсервер</a></li>
      <li><a title="Скачать игру cs 1.6" href="/load/CS 1.6.exe" rel="follow">Скачать cs 1.6</a></li>
     </ul>
    </div>
    <!-- /Navigation -->
    <!-- Game navigation -->
    {$games_menu}
    <!-- /Game navigation -->
    <div class="clearfix"></div>
    <!-- Top -->
    <div id="top_servers">
<?php include(INCLUDES.'top_servers.php'); ?>
    </div>
    <!-- /Top -->
    <div class="clearfix"></div>
    <!-- Alert -->
    <div class="info1">
     — Внимание! Функция топ и вип доступна на бесплатной основе!
     — Чтобы приобрести VIP/TOP/Выделение или задать какой либо вопрос, пожалуйста, обратитесь в Skype: vengeanson
    </div>
    <!-- /Alert -->
    <!-- Mode navigation -->
    {$modes_menu}
    <!-- /Mode navigation -->
   </div>
   <!-- /Header -->
   <!-- CONTENT -->
   <div id="main">
EOT;