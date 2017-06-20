<?php

/* Script security */
if (!defined("MONENGINE")) {
    header("Location: index.php");
    exit();
}

$title = (isset($page_title)) ? $page_title : $settings['site_name'];

?>
<!DOCTYPE html>
<html>
<head>
    <meta NAME="Author" CONTENT="cook">
    <meta NAME="Subject" CONTENT="Мониторинг игровых серверов CS 1.6 CS:S CS:GO :: WG">
    <meta NAME="Description"
          CONTENT="Мониторинг поддерживает самые популярные игры CS 1.6 CS:S CS:GO. У нас вы можете раскрутить сервер, Добавить сервер, найти сервер для игры, Скачать мастер сервер">
    <meta NAME="Keywords"
          CONTENT="Мониторинг серверов cs 1.6, css, csgo, сервера кс, counter-strike сервера, игровой мониторинг, сервера css, csgo сервера, классик сервера, зомби сервера, стим сервера, cs:cz сервера, скачать cs 1.6">
    <meta NAME="Copyright" CONTENT="Мониторинг игровых серверов: WG">
    <meta NAME="Language" CONTENT="Russian">
    <meta NAME="Robots" CONTENT="All">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <link href="/images/icons/favicon.ico" rel="icon">
    <script type="text/javascript">
        $(document).ready(function () {
            var list = document.querySelectorAll("span[data-icon]");
            for (var i = 0; i < list.length; i++) {
                var url = list[i].getAttribute('data-icon');
                list[i].style.backgroundImage = "url('" + url + "')";
            }
            // DataTable jquery plugin
            //var table = $('#table').DataTable({"stateSave": true});
            var table = $('table.servers').DataTable({
                "bPaginate": true,
                "order": [],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "<?php echo $locale['024']; ?>",
                    "emptyTable": "<?php echo $locale['017']; ?>",
                    "info": "<?php echo $locale['023']; ?>",
                    "infoFiltered": "<?php echo $locale['025']; ?>",
                    "lengthMenu": "<?php echo $locale['026']; ?>",
                    "sInfoEmpty": "<?php echo $locale['027']; ?>",
                    "oPaginate": {
                        "sFirst": "<?php echo $locale['028']; ?>",
                        "sPrevious": "<?php echo $locale['029']; ?>",
                        "sNext": "<?php echo $locale['032']; ?>",
                        "sLast": "<?php echo $locale['033']; ?>",
                    }
                }
            });

            $('ul').on( 'click', 'a', function () {
                table
                    .columns( 3 )
                    .search(  $(this).text() )
                    .draw();
            });
        });
    </script>
    <!-- Put this script tag to the <head> of your page -->
    <!-- <script type="text/javascript" src="//vk.com/js/api/openapi.js?116"></script> -->
    <script type="text/javascript">
        //VK.init({apiId: 4747746, onlyWidgets: true});
    </script>
    <base href='<?php echo $settings['site_url']; ?>'>
    <title><?php echo $title; ?></title>
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
                    Всего игровых серверов в мониторинге: <span
                            class="servers_online"><?php echo $servers_total; ?></span> серверов, из них <span
                            class="servers_online"><?php echo $servers_online; ?></span> серверов онлайн.<br/>
                    Самая популярная карта: <span class="servers_online"><?php echo $top_map; ?></span>. Последние
                    обновление было: <span
                            class="servers_online"><?php echo time() - $settings['last_update']; ?></span> секунд(ы)
                    назад.
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
                <li>
                    <noindex>
                        <a title="Наш форум сайта" href=" https://contra.net.ua" target="_blank" rel="nofollow">Наш сайт</a>
                    </noindex>
                </li>
                <li><a title="Наши контактные данные" href="/feedback" rel="nofollow">Контакты</a></li>
                <li><a title="Каталог интернет сайтов" href="/links" rel="nofollow">Партнеры</a></li>
                <li><a title="Наш мастерсервер" href="/mserv" rel="follow">Мастерсервер</a></li>
                <li><a title="Скачать игру cs 1.6" href="/load/CS 1.6.exe" rel="follow">Скачать cs 1.6</a></li>
            </ul>
        </div>
        <!-- /Navigation -->
        <!-- Game navigation -->
        <?php echo games_menu(); ?>
        <!-- /Game navigation -->
        <div class="clearfix"></div>
        <!-- Top -->
        <div id="top_servers">
            <?php include('top_servers.php'); ?>
        </div>
        <!-- /Top -->
        <div class="clearfix"></div>
        <!-- Alert -->
        <div class="info1">
            — Внимание! Функция топ и вип доступна на бесплатной основе!
            — Чтобы приобрести VIP/TOP/Выделение или задать какой либо вопрос, пожалуйста, обратитесь в Skype:
            vengeanson
        </div>
        <div class="info2">
            — Внимание! Все сервера у которых не указан сайт на котором размещена наша ссылка будут переведены в статус оффлайн, а через сутки - удалены из системы!!!
        </div>
        <!-- /Alert -->
    </div>
    <!-- /Header -->
    <!-- CONTENT -->
    <div id="main">
