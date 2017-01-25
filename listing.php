	<?php
				echo "
					<div style='padding:10px;border-top:1px solid #4F4F4F;'>
			<style>.topserv_list li, .viplist li {padding-bottom:10px;}</style>
			<style>.topserv_list span {color:#3ECBFA;}</style>
			<style>.viplist span {color:#AAAAAA;}</style>
			<div style='color:#1584C4;'>
				<div style='font-size:20px;'>
<div class='listingtop'><b>Листинг серверов в шапке сайта (текущее время на сервере ".date("d.m.Y H:i:s")."):</b>
<ol>";
for($itop=1;$itop<5 * LINES_NUM+1;$itop++)
{
		$rtop = mysql_fetch_array(mysql_query("SELECT * FROM `mon_servers` WHERE server_top=$itop"));
		if($rtop['server_top']) 
		{
			echo "<li>Место занято сервером <a href='/server/{$rtop['server_id']}/'>{$rtop['server_name']}</a>. Освободится через ".time2string($rtop['server_top_time'] - time(),true,false,false,false)." (".formatDate("d.m.Y H:i:s",$rtop['server_top_time']).")</li>";
		}
		else
		{
			echo "<li>Место свободно!</li>";
		}
}
echo "</ol>
</div>
<div class='listingvip'><h2><b>Листинг VIP серверов:</b></h2>
<ol>";
$qvip = mysql_query("SELECT * FROM `mon_servers` WHERE server_vip=1");
if(mysql_num_rows($qvip) == 1) echo "<li>Все места свободны</li>";
while($rvip = mysql_fetch_array($qvip))
{
echo "<li>Место занято сервером <a href='/server/{$rvip['server_id']}/'>{$rvip['server_name']}</a>. Освободится через ".time2string($rvip['server_vip_time'] - time(),true,false,false,false)." (".formatDate("d.m.Y H:i:s",$rvip['server_vip_time']).")</li>";	
}
echo "</ol>
</div>	
<div class='listingcolor'><h2><b>Выделенные серверы:</b></h2>
<ol>";
$qcolor = mysql_query("SELECT * FROM `mon_servers` WHERE server_row_style RLIKE '_'");
if(mysql_num_rows($qcolor) == 1) echo "<li>Все места свободны</li>";
while($rcolor = mysql_fetch_array($qcolor))
{
echo "<li>Место занято сервером <a href='/server/{$rcolor['server_id']}/'>{$rcolor['server_name']}</a>. Освободится через ".time2string($rcolor['server_color_time'] - time(),true,false,false,false)." (".formatDate("d.m.Y H:i:s",$rcolor['server_color_time']).")</li>";	
}
echo "</ol>
";

?>