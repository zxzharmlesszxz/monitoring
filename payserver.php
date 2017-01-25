<?php

/*
 * Server info display script
 * Made by web
*/

/* Script security */
if(!defined("MONENGINE")) {
	header("Location: index.php");
	exit();
}

/* Other code */

require_once LOCALE.LOCALESET."serv.php";


$server_id = $_GET['id'];
	
$take_server = dbquery("SELECT * FROM ".DB_SERVERS." WHERE server_id = ".mysql_real_escape_string($server_id)."");
$server_data = dbarray_fetch($take_server);
if(mysql_num_rows($take_server) == 0) {
	displayMessage('Выбранный сервер не существует, либо был удалён.', 'error');
}
else if($server_data['server_off'] == 1)
{
	include("banned.php");
}
 else {
	$site = "";	
	if($server_data['server_site'] !="") {
		$site = "<a href='http://".$server_data['server_site']."' target='_blank'>".$server_data['server_site']." </a>";
	}

		
	$icq = "";
	if($server_data['server_icq'] !="") {
		$icq = $server_data['server_icq']." <img src='http://status.icq.com/online.gif?icq=".$server_data['server_icq']."&img=26'>";
	}
	$status="<font color='#B53333'><b>Offline</b></font>";
	if($server_data['server_status'] == 1) $status = "<font color='#6e8d4c'><b>Online</b></font>";

	$last_update = $settings['last_update'];
	$time_diff = time() - $last_update;
	
	if($time_diff >= 60) {
		$time_lasted = floor($time_diff / 60)." минут";
	} else {
		$time_lasted = $time_diff." секунд";
	}
	
	
	
	echo "
			<div class='horizontal_line'>Заказ платной услуги для сервера</div>

			<div class='cont'>
			

		 ";
		 
	// Start of server page
	echo "<table cellspacing='0' cellpadding='0' width='100%' class='info_tbl'>";
	// Left col (info)

echo "<tr>
      <td class='vindex4'><br>
	  <div class='selected_server'><font style='font-size:16px;'> Выбранный вами сервер — {$server_data['server_name']}</font></div>";
	
	
	  echo "<table class='pay_list'>
			<tbody>
			<tr>
			<td colspan='2'>
			<div style='padding-top:4px;'><label><input type='checkbox' name='terms' value='' checked='' style='vertical-align:middle;' onchange='this.checked=true;'> При нажатии кнопки «Оплатить» вы соглашаетесь с&nbsp;<a href='/terms.html' target='_blank'>нашими правилами и условиями</a></label></div>
			</td>
			</tr>
			<tr>
			<td colspan='2'>
			<small style='color:#AAA;'>Внимание!<br>Возврат средств после заказа услуг — <b>НЕ ПРЕДУСМОТРЕН</b>.</small>
			</td>
			</tr>
			<tr>
			<td colspan='2'>
			
			</td>
			</tr>
<tr>
			<td>Через <b>Выберете услугу:</b>&nbsp;
				<select style='width: 120px;' id='wmtype'>
<option value='wmr'>WMR</option>
<option value='wmu'>WMU</option>
<option value='wmz'>WMZ</option>

			</td>
			<tr>
			<td>Через <b>WebMoney</b>&nbsp;
				<select style='width: 120px;' id='wmtype'>
<option value='wmr'>WMR</option>
<option value='wmu'>WMU</option>
<option value='wmz'>WMZ</option>

			</td>
			<td>
				<form action='https://merchant.webmoney.ru/lmi/payment.asp' method='POST'>
				<input type='hidden' name='LMI_PAYMENT_AMOUNT' value='10'>
				<input type='hidden' name='LMI_PAYMENT_DESC' value='Buy VIP status server #{$server_data['server_id']}'>
				<input type='hidden' name='LMI_PAYEE_PURSE' value='R845298246389'>
				<input type='submit' value='Оплатить!'>
				</form>
			</td>
			<td><!-- begin WebMoney Transfer : attestation label --> <a href='https://passport.webmoney.ru/asp/certview.asp?wmid=201341914818' target='_blank'><IMG SRC='/images/attestated.png' title='Здесь находится аттестат нашего WM идентификатора 201341914818' border='0'><br><font size='1'>Проверить аттестат</font></a><!-- end WebMoney Transfer : attestation label --></td>
			</tr>
			<tr>
			<td colspan='2'>
			";
			
	  echo "<div style='padding:10px;border-top:1px solid #4F4F4F;border-bottom:1px solid #4F4F4F;background:#232323;line-height:19px;'>
			<div style='font-size:15px;padding-bottom:10px;'><a href='https://check.webmoney.ru/' target='_blank' rel='nofollow' style='font-size:15px;text-decoration:none;padding:2px;border-bottom: 1px solid;'>WebMoney.Check</a> — самый быстрый и дешевый способ оплаты при помощи <b>телефона!</b></b></div>
			<div style='padding-bottom:5px;'><strong>Как пополнить WebMoney.Check:</strong></div>
			<object width='560' height='340'><param name='movie' value='http://www.youtube.com/v/Dq-ZN4G0MQE?fs=1&amp;hl=ru_RU&amp;rel=0'><param name='allowFullScreen' value='true'><param name='allowscriptaccess' value='always'><embed src='http://www.youtube.com/v/Dq-ZN4G0MQE?fs=1&amp;hl=ru_RU&amp;rel=0' type='application/x-shockwave-flash' allowscriptaccess='always' allowfullscreen='true' width='560' height='340'></object>
			<div style='padding-bottom:5px;padding-top:10px;'><strong>Как оплачивать при помощи WebMoney.Check:</strong></div>
			<object width='560' height='340'param name='movie' value='http://www.youtube.com/v/BxEzrrCBLd0?fs=1&amp;hl=ru_RU&amp;rel=0'><param name='allowFullScreen' value='true'><param name='allowscriptaccess' value='always'><embed src='http://www.youtube.com/v/BxEzrrCBLd0?fs=1&amp;hl=ru_RU&amp;rel=0' type='application/x-shockwave-flash' allowscriptaccess='always' allowfullscreen='true' width='560' height='340'></object>
			</div>";
	
	
	
	
	
	
	echo "</table>";
	echo "</div>";
}

?>



	<script type="text/javascript">
	function pay(xdata){
	obj=xdata.parentNode.childNodes[1].style; tmp=(obj.display!='block') ?
	'block' : 'none'; obj.display=tmp; return false; } 
	</script> 

	<script>
	(function($) {
	$(function() {
	
	$('ul.tabs').delegate('li:not(.current)', 'click', function() {
	$(this).addClass('current').siblings().removeClass('current')
	.parents('div.section').find('div.box').hide().eq($(this).index()).fadeIn(550);
	})
	
	})
	})(jQuery)
	</script>