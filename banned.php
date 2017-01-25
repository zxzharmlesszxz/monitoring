<?php
/*
 * Server registration script
 * Made by starky
*/

$take_server = dbquery("SELECT * FROM ".DB_SERVERS." WHERE server_id = ".$_GET['id']."");
			$server_data = dbarray_fetch($take_server);

/* Other code */
echo "<div class='horizontal_line'>Cервер заблокирован</div>";
	echo "<div class='cont'>";
echo "<div class='msg redbg'>Сервер <b>$server_data[server_name]</b> заблокирован. Для выяснения причины Skype: monservers или Icq: 162-622</div>";
echo "		<table width='100%' height='150'>";
echo "			<tr><td valign='middle'>";
echo "				<td align='center' style='font-size:16px;'><a href='/'>Вернуться на главную страницу</a></td>";
echo "			</td></tr>";
echo "		</table>";
echo "	</div>";




?>
