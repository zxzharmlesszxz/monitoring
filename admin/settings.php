<?php
/*
 * Menu display class
 * Made by starky
*/

/* Script security */
if (!defined("MONENGINE")) {
	header("Location: index.php");
	exit();
}
/* Other code */
$errors = Array();
$message = '';
if (isset($_POST['save_changes']) and $_POST['save_changes'] == 1) {
	if (
	 !isset($_POST['site_name']) or 
	 !isset($_POST['site_url']) or 
	 !isset($_POST['site_email']) or 
	 !isset($_POST['enable_registration']) or 
	 !isset($_POST['site_open']) or 
	 !isset($_POST['servers_per_page']) or 
	 !isset($_POST['top_rows'])) {
		$errors[] = 'Не все данные были переданы в запросе.';
	}
	
	if (
	myempty($_POST['site_name']) or 
	myempty($_POST['site_url']) or 
	myempty($_POST['site_email']) or 
	myempty($_POST['enable_registration']) or 
	myempty($_POST['site_open']) or 
	myempty($_POST['servers_per_page']) or 
	myempty($_POST['top_rows'])) {
		$errors[] = 'Вы заполнили не все поля.';
	}
	
	$site_name = mysql_real_escape_string($_POST['site_name']);
	$site_url = mysql_real_escape_string($_POST['site_url']);
	$site_email = mysql_real_escape_string($_POST['site_email']);
	$site_registration = mysql_real_escape_string($_POST['enable_registration']);
	$site_open = mysql_real_escape_string($_POST['site_open']);
	$site_spp = mysql_real_escape_string($_POST['servers_per_page']);
	$site_top_rows = mysql_real_escape_string($_POST['top_rows']);
	
 if (!isValidUrl($site_url)) {
  $errors[] = 'Введён неправильный URL сайта.';
 }

	if ($site_url{mb_strlen($site_url, 'UTF-8') - 1} != "/") {
  $site_url = $site_url."/";
 }

	if (!isValidEmail($site_email)) {
  $errors[] = 'Введён неправильный E-mail адрес.';
 }

	if ($site_spp < 1) {
  $errors[] = 'Минимальное количество серверов на одной странице - 1.';
 }

	if ($site_top_rows < 0) {
  $errors[] = 'Кол-во строк топ-серверов не может быть ниже чем 0.';
 }

	if (count($errors) == 0 and isOnOff($site_registration) and isOnOff($site_open)) {
		$site_close = 0;
		if ($site_open == 0) {
    $site_close = 1;
   }
		if (isset($_POST['site_close_reason'])) {
			$site_close_reason = mysql_real_escape_string($_POST['site_close_reason']);
		} else {
			$site_close_reason = '';
		}
		$update_query = "
		UPDATE `".DB_SETTINGS."` SET 
		`site_name` = '{$site_name}',
		`site_url` = '{$site_url}',
		`site_email` = '{$site_email}',
		`enable_registration` = '{$site_registration}',
		`site_closed` = '{$site_close}',
		`site_closed_message` = '{$site_close_reason}',
		`servers_per_page` = '{$site_spp}',
		`top_rows` = '{$site_top_rows}'";
		$update = dbquery($update_query);
		if ($update) {
			$message = '<div class=\'message green\'><span><b>Успех</b>: изменения успешно сохранены.</span></div>';
			$settings = dbarray(dbquery("SELECT * FROM ".DB_SETTINGS)); // Refreshing info 
		} else {
			$message = '<div class=\'message red\'><span><b>Ошибка</b>: не удалось записать данные в БД.</span></div>';
		}
	} else {
		$message = "<div class='message orange'><span><b>Внимание</b>: {$errors[0]}</span></div>";
	}
}

echo "
<script>
$(document).ready(function() {
	$('#site_open').change(function() {
		if($('#site_open option:selected').val() == 0) {
			$('#site_close_reason').attr('disabled',false);
		} else {
			$('#site_close_reason').attr('disabled',true);
		}
	}).change();
});
</script>
<div id='right'>
<div class='section'>
<div class='box'>
	<div class='title'>Редактирование настроек сайта<span class='hide'></span></div>
	<div class='content'>
		".$message."
		<form action='' method='POST'>
		<div class='row'>
			<label>Название сайта</label>
			<div class='right'>
				<input type='text' name='site_name' maxlength='25' value='{$settings['site_name']}'>
			</div>
		</div>
		
		
		<div class='row'>
			<label>URL сайта</label>
			<div class='right'>
				<input type='text' name='site_url' value='{$settings['site_url']}'>
			</div>
		</div>
		
		<div class='row'>
			<label>E-mail сайта</label>
			<div class='right'>
				<input type='text' name='site_email' value='{$settings['site_email']}'>
			</div>
		</div>
		
		<div class='row'>
			<label>Регистрация</label>
			<div class='right'>
				<select name='enable_registration'>
					<option value='1'".(($settings['enable_registration'] == 1) ? " selected='selected'" : "").">Включена</option>
					<option value='0'".(($settings['enable_registration'] == 0) ? " selected='selected'" : "").">Выключена</option>
				</select>
			</div>
		</div>
		
		<div class='row'>
			<label>Статус сайта</label>
			<div class='right'>
				<select name='site_open' id='site_open'>
					<option value='1'".(($settings['site_closed'] == 0) ? " selected='selected'" : "").">Открыт</option>
					<option value='0'".(($settings['site_closed'] == 1) ? " selected='selected'" : "").">Закрыт</option>
				</select>
				<br><input type='text' placeholder='Причина закрытия сайта' value='{$settings['site_closed_message']}' name='site_close_reason' id='site_close_reason'>
			</div>
		</div>
		
		<div class='row'>
			<label>Серверов / стр</label>
			<div class='right'>
				<input type='text' name='servers_per_page' class='onlynum' style='width:70px;' value='{$settings['servers_per_page']}'>
			</div>
		</div>
		
		<div class='row'>
			<label>Строк в топе</label>
			<div class='right'>
				<input type='text' name='top_rows' class='onlynum' style='width:70px;' value='{$settings['top_rows']}'>
			</div>
		</div>
		
		<div class='row'>
			<div class='right'>
				<input type='hidden' name='save_changes' value='1'>
				<button type='submit' class='green'><span>Сохранить</span></button> <button type='button' class='grey' onClick=\"window.location.href='index.php';\"><span>Отмена</span></button>
			</div>
		</div>
		</form>
	</div>
</div>
</div>
</div>";
