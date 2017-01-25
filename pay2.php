<?php
/*
 * Server search script
 * Made by BaMTTuP
*/

/* Script security */
if(!defined("MONENGINE")) {
	header("Location: index.php");
	exit();
}
/* Other code */

if($_GET['page'] == "pay" && !isset($_GET['serverpay']))
{
	echo '
<div class="mytitle"><div>Платные услуги для серверов CS 1.6</div></div>
	<div class="cont" style="padding:0;">
		<div style="padding:10px;background:#333333;line-height:200%;">
			<img src="/images/paid-services.png" style="float:left;width:237px;height:151px;padding-right:30px;padding-top:30px;" alt="Платные услуги" />
			<style>.para_vip td {padding-left: 10px; height: 30px;}</style>
			<table cellpadding="0" cellspacing="0" class="para_vip" >
				<tr>
					<td valign="middle"><img src="/images/para-vip.gif" width="9" height="13" /></td>
					<td valign="middle">Верхние "ВИП" места рейтинга серверов и "Премиум" сервера находящиеся в шапке мониторинга можно купить;</td>
				</tr>
				<tr>
					<td valign="middle"><img src="/images/para-vip.gif" width="9" height="13" /></td>
					<td valign="middle">ВИП сервера выделяются знаком VIP, и сортируются по дате покупки;</td>
				</tr>
				<tr>
					<td valign="middle"><img src="/images/para-vip.gif" width="9" height="13" /></td>
					<td valign="middle">Если вы не оплатили "ВИП" после его окончания, у Вас будет 5 дней чтобы оплатить его без потери места;</td>
				</tr>
				<tr>
					<td valign="middle"><img src="/images/para-vip.gif" width="9" height="13" /></td>
					<td valign="middle">Оплата осуществляется в автоматическом режиме через <a href="http://webmoney.ru/" target="_blank" rel="nofollow">WebMoney</a> (wmr, wmz, wmu),<br />или через сервис <a href="http://robokassa.ru/" target="_blank" rel="nofollow">RoboKassa</a> (<a href="http://money.yandex.ru/" target="_blank" rel="nofollow">Яndex.Денеги</a>, QIWI, Visa/Master Card, SMS, <a href="http://www.w1.ru/" target="_blank" rel="nofollow">Единый кошелек</a>, EasyPay и т.д.);</td>
				</tr>
				<tr>
					<td valign="middle"><img src="/images/para-vip.gif" width="9" height="16" /></td>
					<td valign="middle">При покупке любого ВИП или Премиум слота, ваш сервер автоматически подписывается на услугу - продвижение сервера через Masterservers (поиск серверов в самом клиенте игры Counter-Strike 1.6);
					</td>
				</tr>
				<tr>
					<td valign="middle"><img src="/images/para-vip.gif" width="9" height="16" /></td>
					<td valign="middle">Добавление серверов в списки Избранных серверов в <a target="_blank" href="/counter-strike/">наших сборках CS 1.6</a> работает на 100%;
					</td>
				</tr>
				<tr>
					<td valign="middle"><img src="/images/para-vip.gif" width="9" height="16" /></td>
					<td valign="middle">Наши сборки CS 1.6 имеют защиту от СПАМ плагинов, по этому у серверов у которых установлены такие плагины, эффект раскрутки будит в разы ниже;
					</td>
				</tr>
			</table>
			<div style="clear:both;"></div>
		</div>
		<div style="padding:10px;border-top:1px solid #4F4F4F;">
			<span style="color:red;font-size:20px;">Серверам использующим услуги<b>&nbsp;&laquo;Турбо Буст&raquo;</b>,<b>&nbsp;&laquo;ВИП&raquo;</b> и&nbsp;<b>&laquo;Премиум место&raquo;</b> ЗАПРЕЩЕНО:</span><br />
			<div style="padding-top:3px;padding-left:20px;color:#EEE;">&mdash;&nbsp;Устанавливать плагины для ридиректа игроков на&nbsp;другие <strong>НЕ ВИП</strong> Серверы CS&nbsp;1.6;<br />
			&mdash;&nbsp;изменять игрокам CS&nbsp;1.6 какие либо клиентские файлы игры;<br />
			&mdash;&nbsp;не рекомендуется ломать игрокам CS&nbsp;1.6 клиент игры, по возможности используйте бан IP или подсети;<br />
			&mdash;&nbsp;изменять игрокам CS&nbsp;1.6 конфиги игры;<br />
			&mdash;&nbsp;вписывать игрокам CS&nbsp;1.6&nbsp;в меню клиента игры или конфиг рекламу серверов или хостингов;<br />
			&mdash;&nbsp;автоматически, через Motd окна, устанавливать игрокам .exe приложения;</div>
			<div style="padding-top:10px;color:red;">Внимание! В случае нарушение данных правил, добавление в мастерсервер будит аннулировано!<br />
			Если вы обнаружили среди наших ВИП/ТОП/Буст серверов нарушителей, вы можете сообщить нам об этом через форму обратной связи.<br />
			После проверки, в знак благодарности, мы подарим вам Место нарушителя, ВИП слот на 7 дней или ТурбоБуст!</div>
		</div>
		<div style="padding:10px;border-top:1px solid #4F4F4F;">
			<div style="padding-bottom:10px;font-size:20px;">Для того, что бы заказать платную услугу, нужно найти сервер</div>
				<div style="display:inline-block;">
					<div class="box_1"><b class="ugolki r4"></b><b class="ugolki r3"></b><b class="ugolki r2"></b><b class="ugolki r1"></b><b class="ugolki r1"></b></div>
					<div style="padding:5px;background:#363636;">
						<table cellpadding="0" cellspacing="0">
							<tr>
								<td valign="top" style="padding:5px;padding-right:15px;">
									<div class="title">Найти сервер по IP:</div>
									<form method="POST" action="/search/" style="padding:0;margin:0;">
										<input type="hidden" name="allsearch" value="1" />
										<input name="allsearch" value="" class="advanced-search" style="min-height:12px;" />&nbsp;<input name="gosearch" value="OK" type="submit" />
									</form>
								</td>
								<td valign="top" style="border-left: 1px solid #4F4F4F;padding:5px;padding-left:15px;">
									<div class="title">Или ввести ID сервера:</div>
									<form method="POST" action="/search/" style="padding:0;margin:0;">
										<input name="pay_id" value="" style="width:100px;" style="min-height:12px;" />&nbsp;<input name="pay_id_go" value="OK" type="submit" />
									</form>
								</td>
							</tr>
						</table>
					</div>
					<div class="box_1"><b class="ugolki r1"></b><b class="ugolki r1"></b><b class="ugolki r2"></b><b class="ugolki r3"></b><b class="ugolki r4"></b></div>
				</div>
			<div style="padding-top:10px;font-size:10px;">VIP, а так же услуга выделения цветом устанавливается в течении 2 минут после оплаты</div>
		</div>
		<div style="padding:10px;border-top:1px solid #4F4F4F;line-height:19px;">
			<div style="font-size:20px;padding-bottom:10px;">Стоимость оплачиваемых услуг:</div>
				<style>div.price_list {padding-left: 15px;}</style>
				<style>.price_list td {padding-left: 10px;padding-bottom: 10px;}</style>
			<div class="price_list"><table cellpadding="0" cellspacing="0">
				<tr>
					<td valign="middle"><img src="/images/para-vip.gif" width="9" height="13" /></td>
					<td valign="middle">Покупка ВИП слота на 30 дней (всего 200 мест) &mdash; 20 WMZ (240 WMU, 640 WMR)</td>
				</tr>
				<tr>
					<td valign="middle"><img src="/images/para-vip.gif" width="9" height="13" /></td>
					<td valign="middle">Покупка ВИП слота на 7 дней &mdash; 4.9 WMZ (58.8 WMU, 156.8 WMR)</td>
				</tr>
				<tr>
					<td valign="middle"><img src="/images/para-vip.gif" width="9" height="13" /></td>
					<td valign="middle">Покупка ВИП слота на 1 день &mdash; 0.7 WMZ (8.4 WMU, 22.4 WMR)</td>
				</tr>
				<tr>
					<td valign="middle"><img src="/images/para-vip.gif" width="9" height="13" /></td>
					<td valign="middle">Выделение ВИП слота сервера цветом (30 дней)&nbsp;&mdash; 3 WMZ (36 WMU, 96 WMR)</td>
				</tr>
				<tr>
					<td valign="middle"><img src="/images/para-vip.gif" width="9" height="13" /></td>
					<td valign="middle">Установка сервера на Премиум место (в шапке сайта, всего 35 мест)&nbsp;&mdash; 35 WMZ (420 WMU, 1120 WMR)</td>
				</tr>
				<tr>
					<td valign="middle"><img src="/images/para-vip.gif" width="9" height="13" /></td>
					<td valign="middle">Выделение цветом адреса (IP:PORT) в слоте Премиум место&nbsp;&mdash; 3 WMZ (36 WMU, 96 WMR)</td>
				</tr>
				<tr>
					<td valign="middle" style="padding-bottom: 0px;"><img src="/images/para-vip.gif" width="9" height="13" /></td>
					<td valign="middle" style="padding-bottom: 0px;"><span style="color:#d3edd5;font-weight:bold;">Услуга Turbo boost</span> (самая эффективная раскрутка сервера CS 1.6)&nbsp;&mdash; 1.7 WMZ (20.4 WMU, 54.4 WMR)</td>
				</tr>
			</table></div>
			<div style="padding-top:5px;">Узнать больше о наших услугах и о <a href="#" target="_blang">раскрутке серверов cs 1.6</a></div>
		</div>
		<div style="padding:10px;border-top:1px solid #4F4F4F;">
			<div style="font-size:20px;">Сервера заказавшие услугу <img src="/images/turbo-boost.png" alt="Turbo boost" style="width:174px;height:43px;" /></div>
				<style>.turbo-boost span {color:#AAAAAA;}</style>
				<style>.turbo-boost li {padding-bottom:10px;}</style>
			
				<div style="line-height: 160%;margin-left:20px;margin-top:10px;width:850px;background:#111;padding:10px;padding-top:5px;padding-bottom:5px;border-radius: 5px;">
					Смысл услуги Turbo boost таков: <strong>список содержит в себе ровно 100 серверов</strong> и cервера добавляются только в Мастер сервер.<br />Каждый добавленный новый сервер выталкивает из списка сервер, который находится на последнем 100 месте.<br />То есть первый становится вторым и т.д., 100 сервер пропадает. Время Буста зависит на прямую от спроса на данную услугу.<br />Точную длительность последнего Буста вы можете посмотреть в Листинге Буст серверов, у сервера который находится на последнем месте.<br /><a href="http://shop.cs-get.ru/images/boost-mego.jpg" target="_blank">Внимание! Что бы усилить эффект Буста, вы можете купить услугу несколько раз подряд!</a></br><span style="color:gray;">(если купить Буст 2 раза подряд или более на 2 круга или более, то сервер будит добавлен в буст одновременно 2 раза или более на то количество кругов, которое было оплачено за каждую из покупок)</span>
				</div>
				
				';
								echo "
		<div style='padding:10px;'>
			<style>.topserv_list li, .viplist li {padding-bottom:10px;}</style>
			<style>.topserv_list span {color:#3ECBFA;}</style>
			<style>.viplist span {color:#AAAAAA;}</style>
			<div style='color:#1584C4;'>
				<div style='font-size:20px;'>Листинг серверов в шапке сайта <span style='color:#FFF'>(текущее время на сервере  ".date("d.m.Y H:i:s")."):</span></div>
				<div class='topserv_list'>
					<ol>
";
for($itop=1;$itop<5 * LINES_NUM+1;$itop++)
{
		$rtop = mysql_fetch_array(mysql_query("SELECT * FROM `mon_servers` WHERE server_top=$itop"));
		if($rtop['server_top']) 
		{
			echo "<li><font size='2px'>Место занято сервером <a href='/{$rtop['server_id']}/' style='color:#3dcbfa;'>{$rtop['server_name']}</a>. Освободится через ".time2string($rtop['server_top_time'] - time(),true,false,false,false)." (".formatDate("d.m.Y H:i:s",$rtop['server_top_time']).") <a href='/{$rtop['server_id']}/' style='color:#3dcbfa;'>продлить</a></li>";
		}
		else
		{
			echo "<li><font size='2px'>Место свободно!</li></font></font>";
		}
}

echo "</ol></div></div></div>
					
		<div style='font-size:20px;'>Листинг VIP серверов:</div>
			<div class='viplist'>
				<ol>
		";
$qvip = mysql_query("SELECT * FROM `mon_servers` WHERE server_vip=1");
if(mysql_num_rows($qvip) == 1) echo "<font size='2px'><li>Все места свободны</li></font>";
while($rvip = mysql_fetch_array($qvip))
{
echo "<font size='2px'><li>Место занято сервером <a href='/{$rvip['server_id']}/'>{$rvip['server_name']}</a>. Освободится через ".time2string($rvip['server_vip_time'] - time(),true,false,false,false)." (".formatDate("d.m.Y H:i:s",$rvip['server_vip_time']).")</li>";	
}
echo "</ol></div></div></div>";

				echo '
<div class="modal rndwindow" style="margin-top:50px;box-shadow: 0 0 0 rgba(0, 0, 0, 0);background:transparent;display:none;border:0;">
	<div class="alert alert-error">
		<button type="button" class="close" data-dismiss="alert" onClick="$(this).parent().parent().hide();">&times;</button>
		<h4>ВНИМАНИЕ!</h4>
		Если после заказа платных услуг, <strong>особенно после заказа Турбо-Буста</strong>, ваш сервер не раскручивается или раскручивается плохо, обязательно напишите нам в <a href="/feedback/" style="color:red;">Обратную связь</a>, мы поможем решить проблему!
	</div>
</div>
<div class="modal rndwindow" style="margin-top:50px;box-shadow: 0 0 0 rgba(0, 0, 0, 0);background:transparent;display:none;border:0;">
	<div class="alert alert-info">
		<button type="button" class="close" data-dismiss="alert" onClick="$(this).parent().parent().hide();">&times;</button>
		<h4>Что нужно для раскрутки сервера CS 1.6!</h4>
		<br>
		<strong>- Видимость сервера в Интернет поиске</strong> и в Избранных списках - правильно настроенный DPROTO v0.9.179 или выше, <strong>ServerInfoAnswerType = 2</strong>.<br>
		Добавьте свой сервер через интернет IP адрес в список Избранных серверов в КС, если после добавления он не отображается там, значит от Мастер серверов вам толку будит ровно 0.
		<br><br>
		<strong>- Быстрый Коннект на сервер</strong> и Быстрая загрузка дополнительных файлов <strong>sv_downloadurl</strong>.<br>
		Скачайте чистую КС и проверьте через интернет IP адрес сервера коннект на сервер, идеальный вариант до 30 сек. Коннект 2 минуты и более ведёт к резкому спаду коннектов.<br>
		Так же у игроков КС на Windows 7 замечено после обновлений системы и браузера IE, через который идёт sv_downloadurl по HTTP протоколу, проблемы с быстрой загрузкой, если на ПК не запускается IE.<br>
		Соответственно у некоторых игроков быстрая загрузка файлов в КС может не работать, даже если она установлена на вашем сервере.
		<br><br>
		<strong>- Мультипротокол</strong> - важно что бы ваш сервер пускал 47 и 48 протокол игры, а так же все билды КС, ставим и настраиваем DPROTO.<br>
		Наш Мастер сервер состоит в основном из 48 протокола, но есть и старые сборки на 47.
		<br><br>
		- <strong>Для набора игроков</strong> на пустых или мало заполненных серверах, рекомендуется запускать самые популярные карты, например dust2_2x2 :)
	</div>

<!--div class="modal rndwindow" style="margin-top:50px;box-shadow: 0 0 0 rgba(0, 0, 0, 0);background:transparent;display:none;border:0;">
	<div class="alert alert-error">
		<button type="button" class="close" data-dismiss="alert" onClick="$(this).parent().parent().hide();">&times;</button>
		<h4>Осторожно МОШЕННИКИ!</h4>
		Если вам предлагают купить наши платные услуги или обещают скидки на них в ICQ, Skype, на Email, сторонних сайтах, форумах или программах по раскрутки серверов - помните, что это ОБМАН!!! Купить наши платные услуги можно только на http://cs-get.ru/pay/ !!! Если хотите правильно пользоваться нашим мониторингом, <a href="/feedback/" style="color:red;">читайте наш FAQ!</a>
	</div>
</div-->
<script type="text/javascript">$($(".rndwindow")[parseInt(Math.random() * 10000000000000)%$(".rndwindow").length]).show();</script>
<!--script>alert("Осторожно МОШЕННИКИ! Если вам предлагают купить наши платные услуги или обещают скидки на них в ICQ, Skype, на Email, сторонних сайтах, форумах или программах по раскрутки серверов - помните, что это ОБМАН!!! Купить наши платные услуги можно только на http://cs-get.ru/pay/ !!! Если хотите правильно пользоваться нашим мониторингом, читайте наш FAQ!")</script-->
<!--script>alert("ВНИМАНИЕ! Если после заказа платных услуг, особенно после заказа Турбо-Буста, ваш сервер не раскручивается или раскручивается плохо, обязательно напишите нам в Обратную связь, мы поможем решить проблему!")</script-->
<!--script>alert("Всем обязательно проверить доступ на свой сервер CS 1.6 с нашей сборки игры (ссылка в шапке сайта). Скачайте игру и зайдите на свой сервер, если в течении 1-2 минут вас не выкинет, значит всё ОК, если выкинет, значит раскрутка на ваш сервер идёт не как надо :( Пишите в тех. поддержку мониторинга!")</script-->
<!--script>alert("Хочешь получить Турбо-Буст на 3 круга бесплатно? Найди среди ВИП/ТОП/Буст серверов нарушителей, которые используют автоконнект, запуск .exe/.bat/.cmd приложений через мотд окна - подмена МС или спам в конфиг игры и мы подарим тебе Буст на 3 круга бесплатно!")</script-->
<!--script>alert("Теперь оплата наших услуг возможна при помощи всех популярных платёжных систем, через сервис Робокасса - ЯндексДеньги, QIWI, Visa/Master Card, SMS, EasyPay и другие.")</script--></td></tr><tr><td valign="bottom">

				
				';

}
else if($_GET['page'] == "pay" && isset($_GET['serverpay']) && $_GET['serverpay'] > 0)
{
$test_sever = mysql_query("SELECT server_name FROM mon_servers WHERE server_id = '".$_GET['serverpay']."'");
$r = mysql_fetch_array($test_sever);
if(mysql_num_rows($test_sever) <= 0)
{
	echo "Сервер не найден";
	return 1;
}
$test_query = mysql_query("SELECT server_top FROM mon_servers WHERE server_id = '".$_GET['serverpay']."' AND `server_top` > 0");
$r_top = mysql_fetch_array($test_query);
$glb_count = mysql_num_rows($test_query);
if(isset($_POST['posit'])) $pos_tops = $_POST['posit'];
else $pos_tops = $r_top['server_top'];
/* Other code */
$статус_вебмани = '<span style="color:green;">УЖЕ РАБОТАЕТ!</span>';
echo "<div class='mytitle'><div>Заказ платной услуги для сервера</div></div>";
/* Search form */
	echo "
	<div class='cont'>";
	echo '
	<div style="padding:10px;padding-bottom:0;">
		<div class="selected_server">Выбранный сервер&nbsp;'.$r['server_name'].'</div>
		<div style="padding-top:2px;"><a href="javascript:document.location=document.location" style="text-decoration:none;font-size:10px;">(обновить)</a></div>
		<div style="padding-top:20px;padding-bottom:20px;" id="boost">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td valign="middle">Выберете услугу:&nbsp;</td>
					<td valign="middle">
					
<select id="wpay" name="wpay" style="width:300px;">
<option value="vip">Покупка VIP слота на 30 дней (всего 200 мест)</option>
<option value="vip-week">Покупка VIP слота на 7 дней</option>
<option value="vip-day">Покупка VIP слота на 1 день</option>
<option value="color">Выделение сервера цветом (30 дней)</option>
<option value="topserv" '.((isset($_GET['posit']))?"selected":"").'>Покупка Премиум места (30 дней)</option>
<option value="topserv_color" '.(($glb_count > 0)?"":"disabled").'="">Выделение цветом адреса (IP:PORT) в слоте Премиум место</option></select>
						
						<input type="hidden" id="topserv_position" value="-1" />
					</td>
				</tr>
			</table>
		</div>
		<div style="display:none;margin-bottom:10px;" id="topserv_pos"><div style="display:inline-block;"><div style="padding-bottom:3px;text-align:center;font-size:11px;">Позиция сервера</div><div class="pay_topslot_notempty">1<br />занят</div><div class="pay_topslot_notempty">2<br />занят</div><div class="pay_topslot_notempty">3<br />занят</div><div class="pay_topslot_notempty">4<br />занят</div><div class="pay_topslot_notempty">5<br />занят</div><div style="clear:both;"></div><div class="pay_topslot_notempty">6<br />занят</div><div class="pay_topslot_notempty">7<br />занят</div><div class="pay_topslot_notempty">8<br />занят</div><div class="pay_topslot_notempty">9<br />занят</div><div class="pay_topslot_notempty">10<br />занят</div><div style="clear:both;"></div><div class="pay_topslot_notempty">11<br />занят</div><div class="pay_topslot_notempty">12<br />занят</div><div class="pay_topslot_notempty">13<br />занят</div><div class="pay_topslot_notempty">14<br />занят</div><div class="pay_topslot_notempty">15<br />занят</div><div style="clear:both;"></div><div class="pay_topslot_notempty">16<br />занят</div><div class="pay_topslot_notempty">17<br />занят</div><div class="pay_topslot_notempty">18<br />занят</div><div class="pay_topslot_notempty">19<br />занят</div><div class="pay_topslot_notempty">20<br />занят</div><div style="clear:both;"></div><div class="pay_topslot_notempty">21<br />занят</div><div class="pay_topslot_notempty">22<br />занят</div><div class="pay_topslot_notempty">23<br />занят</div><div class="pay_topslot_notempty">24<br />занят</div><div class="pay_topslot_notempty">25<br />занят</div><div style="clear:both;"></div><div class="pay_topslot_notempty">26<br />занят</div><div class="pay_topslot_notempty">27<br />занят</div><div class="pay_topslot_notempty">28<br />занят</div><div class="pay_topslot_notempty">29<br />занят</div><div class="pay_topslot_notempty">30<br />занят</div><div style="clear:both;"></div><div class="pay_topslot_notempty">31<br />занят</div><div class="pay_topslot_notempty">32<br />занят</div><div class="pay_topslot_notempty">33<br />занят</div><div class="pay_topslot_notempty">34<br />занят</div><div class="pay_topslot_notempty">35<br />занят</div><div style="clear:both;"></div></div><div style="clear:both;"></div></div>

		<table cellpadding="0" cellspacing="0" style="display:none;" id="topcolors"></table>
		<div style="padding-bottom:20px;"><label><input type="checkbox" name="terms" value="" checked style="vertical-align:middle;" onChange="this.checked=true;"> При нажатии кнопки &laquo;Оплатить&raquo; вы&nbsp;соглашаетесь с&nbsp;<a href="/terms.html" target="_blank">нашими правилами и&nbsp;условиями</a></lable></div>
		<small style="color:#AAA">Внимание!<br />
		Возврат средств после заказа&nbsp;&mdash; <b>НЕ ПРЕДУСМОТРЕН</b>.</small>
		<div style="padding-top:20px;">
			<style>.paytype td {padding-left: 10px; height: 55px;}</style>
			<table cellpadding="0" cellspacing="0" class="paytype">
				<tr>
					<td valign="middle"><img src="/images/para-vip.gif" width="9" height="13" /></td>
					<td valign="middle">Через <b>WebMoney</b>&nbsp;
						<select id="wmtype">
							<option value="wmr">WMR&nbsp;&nbsp;</option>
						</select>
					</td>
					<td valign="middle"><input type="button" value="Оплатить" name="webmoney"/></td>
					<td valign="middle" align="center" style="padding-top:10px;"><div style="padding-left:10px;padding-right:10px;"><!-- begin WebMoney Transfer : attestation label --> <a href="https://passport.webmoney.ru/asp/certview.asp?wmid=LOL:D" target=_blank><IMG SRC="http://www.webmoney.ru/img/icons/88x31_wm_v_blue_on_white_ru.png" title="Здесь находится аттестат нашего WM идентификатора 845080856727" border="0"><br><font size=1>Проверить аттестат</font></a><!-- end WebMoney Transfer : attestation label --></div></td>
				</tr>
				<tr>
					<td valign="middle"><img src="/images/para-vip.gif" width="9" height="13" /></td>
					<td valign="middle">Через сервис <b>Robokassa (Яндекс.Деньги, QIWI)</b></td>
					<td valign="middle" colspan="1"><input type="button" value="Оплатить" name="robokassa"/></td>
					<td valign="middle" style="padding-top:0px;" align="center"><div style="padding-left:10px;padding-right:10px;">Дополнительная комиссия!</div></td>
					<td>'. $статус_вебмани .'</td>
				</tr>
				<tr>
					<td valign="middle"><img src="/images/para-vip.gif" width="9" height="13" /></td>
					<td valign="middle" colspan="3">Перед покупкой обязательно прочитайте <a href="/feedback/" target="_blank">Наш FAQ</a> и советы по <a href="http://cs-get.ru" target="_blank">раскрутке серверов CS 1.6</a>!</td>
				</tr>
			</table>
		</div>
	</div>
	<div style="padding:10px;border-top:1px solid #4F4F4F;background:#333333;line-height:19px;">
		<div style="font-size:17px;padding-bottom:10px;"><a href="https://check.webmoney.ru/" target="_blank" rel="nofollow" style="font-size:17px;text-decoration:none;padding:2px;border-bottom: 1px solid;">WebMoney.Check</a>&nbsp;&mdash; самый быстрый и дешовый способ оплаты при помощи <b>телефона!</b></div>
		<div style="padding-bottom:5px;"><strong>Как пополнить WebMoney.Check:</strong></div>
		<object width="560" height="340"><param name="movie" value="http://www.youtube.com/v/Dq-ZN4G0MQE?fs=1&amp;hl=ru_RU&amp;rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/Dq-ZN4G0MQE?fs=1&amp;hl=ru_RU&amp;rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="560" height="340"></embed></object>
		<div style="padding-bottom:5px;padding-top:10px;"><strong>Как оплачивать при помощи WebMoney.Check:</strong></div>
		<object width="560" height="340"><param name="movie" value="http://www.youtube.com/v/BxEzrrCBLd0?fs=1&amp;hl=ru_RU&amp;rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/BxEzrrCBLd0?fs=1&amp;hl=ru_RU&amp;rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="560" height="340"></embed></object>
	</div>
</div>';
}
?>