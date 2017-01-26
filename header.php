<?php
/*
 * Site header template
 * Made by starky
*/

/* Script security */
if(!defined("MONENGINE")) {
	header("Location: index.php");
	exit();
}
?>

<!DOCTYPE HTML>
<html>
<head>
<title>monitoring.contra.net.ua :: Мониторинг игровых серверов CS 1.6 Украина</title>
<META charset="utf-8">
<META NAME="Author" CONTENT="cook">
<META NAME="Subject" CONTENT="Мониторинг игровых серверов counter-strike 1.6 Украина">
<META NAME="Description" CONTENT="Мониторинг игровых серверов cs 1.6, добавить сервер cs 1.6, раскрутка сервера cs 1.6, купить vip статус, найти сервер cs 1.6, скачать мастер-сервер, скачать counter-strike 1.6">
<META NAME="Keywords" CONTENT="Мониторинг серверов cs 1.6 Украина, мониторинг игровых серверов, кс 1.6 мониторинг, cs сервера, кс серверы, раскрутить сервер бесплатно, бесплатный мониторинг, мониторинг steam серверов, скачать кс, найти сервер для игры, купить рекламу на сайте, counter-strike 1.6, купить vip в мониторинге">
<META NAME="Copyright" CONTENT="Мониторинг CS серверов: WG">
<META NAME="Language" CONTENT="Russian">
<META NAME="Robots" CONTENT="All">
<meta name="revisit-after" content="1 day" />
<meta name="distribution" content="Global" />
<meta name="rating" content="General" />
<meta name="copyright" content="Copyright © 2014" />
<meta name="cypr-verification" content="df9b877027745edce833e2dba8399189"/>
<link rel="stylesheet" type="text/css" href="/css/reset.css" />
<link rel="stylesheet" type="text/css" href="/css/style.css" />
<link rel="shortcut icon" href="/favicon.ico" />
<script type="text/javascript" src="/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="/js/vote.js"></script>
<script type="text/javascript" src="//vk.com/js/api/openapi.js?63"></script>
<script type="text/javascript" src="//vk.com/js/api/openapi.js?72"></script>



<script type="text/javascript">
  VK.init({apiId: 3173183, onlyWidgets: true});
</script>


<script type="text/javascript">
  VK.init({apiId: 3173183, onlyWidgets: true});
</script>
<!-- RedHelper -->
<script id="rhlpscrtg" type="text/javascript" charset="utf-8" async="async"
	src="https://web.redhelper.ru/service/main.js?c=monservers"></script>
<!--/Redhelper -->

</style> 
	

	<?php
	echo "
			<base href='".SITE_URL."'>
			<script type='text/javascript' src='".JS."jquery-1.7.2.min.js'></script>\n
			<script type='text/javascript' src='".JS."cookies.js'></script>\n
			<script type='text/javascript' src='".JS."jquery.cookies.js'></script>\n
			<link href='".THEME."css/styles.css' rel='stylesheet' type='text/css' media='all'>\n
			".((file_exists(IMAGES.'favicon.ico')) ? "<link rel='shortcut icon' href='".IMAGES."favicon.ico' type='image/x-icon' />\n" : '')."
			
		";
	?>
</head>

<body>
<!-- WRAP -->
<div class="wrapper">
	<!-- HEADER -->
	<div id="header">
		<!-- Header['top'] -->
		<div id="header_stat">
		
			<a id="header_stat_logo" href="/"></a>
			
			<div id="header_stat_main">
			
				<div id="stats">
					Всего игровых серверов в мониторинге: <span class="servers_online"><?php echo $servers_total;?></span> серверов, из них <span class="servers_online"><?php echo $servers_online;?></span> серверов онлайн.</span><br>
					Последние обновление было: <span class="servers_online"><?php echo time() - $settings['last_update']; ?> секунд(ы) назад</span>. А тут вы можете скачать <a href="/cs.php" title="Скачать игру cs 1.6" target="_blank">Counter-Strike</a>

					

					
					
					
				</div>



				<div id="header_stat_search">
					<form action="/search/" method="POST">
						<input type="text" placeholder="Быстрый поиск" name="search">
					</form>
				</div>
				<?php
				if($page == 'adv_search_results' or $page == 'quick_search') {
	echo "<table class='servers' cellpadding='0' cellspacing='0' border='0'>";
	?>
			</div>
		</div>
		<!-- /Header['top'] -->
		
		
		<!-- Header['menu'] -->
		<div id="horizontal_menu">
		
			<ul>
				<li><a href="/">Главная страница</a></li>
				<li><a href="/add">Добавить сервер</a></li>
				<li><a href="/search">Поиск серверов</a></li>
				<li><a href="/pay"><font color="yellow">Платные услуги</a></font></li>
				<li><a href="#">Редактирование</a></li>
				<li><a href="/mserv">Мастер-сервер</a></li>
				<li><a href="/">Зайти на форум</a></li>
				<li><a href="/script">Купить скрипт</a></li>
				
				
			</ul></ul>
		
		</div>
		<!-- /Header['menu'] -->
		<div class="clearfix"></div>
		<!-- Header['top_servers'] -->
		<div id="top_servers">
			<?php include(INCLUDES.'top_servers.php');?>

			</div>
		</div>


		
		<!-- /Header['top_servers'] -->

	<!-- /HEADER -->
	
			<div style="border-left:1px solid #4F4F4F;border-right:1px solid #4F4F4F;background:#242424;">

	<div style="float:left;padding-left:9px;margin-top:10px;margin-bottom:10px;opacity:0.6;width:468px;heigt:60px;"><script language="JavaScript" src="http://linkcase.ru/show/bcases/5293"></script></div>
	<div style="float:right;padding-right:9px;margin-top:10px;margin-bottom:10px;opacity:0.6;width:468px;heigt:60px;"> <script language="JavaScript" src="http://linkcase.ru/show/bcases/5294"></script></div>
	<div class="clearfix"></div>


		
	
	<!-- CONTENT -->
	<div id="main">
