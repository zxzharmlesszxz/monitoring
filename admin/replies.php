<?php
/*
 * Reply operations
 * Made by starky
*/

/* Script security */
if(!defined("MONENGINE")) {
	header("Location: index.php");
	exit();
}
/* Other code */
$get_replies = dbquery("SELECT * FROM `".DB_COMMENTS."` WHERE `type` = '0' ORDER BY `id` ASC");
$replies_num = mysql_num_rows($get_replies);
echo "<div id='right'>
		<div class='section'>
			<div class='box'>
				<div class='title'>Неподтверждённые отзывы (<span id='not_approved'>$replies_num</span>)<span class='hide'></span></div>
				<div class='content'>
				";
			if($replies_num == 0) {
				echo "	<div class='row'>
							<center>Нет непромодерированных отзывов.</center>
						</div>
					";
			} else {
				echo "<table cellspacing='0' cellpadding='0' width='100%'>
								<thead>
									<tr>
										<th>Текст комментария</th>
										<th>Подтвердить</th>
									</tr>
								</thead>
								<tbody>
								

					";
				while($reply = dbarray_fetch($get_replies)) {
					echo "	<tr id='reply_{$reply['id']}'>
								<td>{$reply['text']}</td>
								<td>
									<button type='button' class='green' onClick=\"approveReply('{$reply['id']}', '1');\"><span>Позитивный</span></button> 
									<button type='button' class='red' onClick=\"approveReply('{$reply['id']}', '2');\"><span>Негативный</span></button>
								</td>
							</tr>
						";
				}
							
				echo "</tbody></table></div>";
			}
echo "		</div>
		</div>
	</div>";

?>