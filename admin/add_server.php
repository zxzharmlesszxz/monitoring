<?php
/*
 * Server registration script
 * Made by starky
*/

/* Script security */
if(!defined("MONENGINE")) {
	header("Location: index.php");
	exit();
}
require(INCLUDES."countries.class.php");
$countries = new countries;
$address = '';
$steam = 0;
$message = '';
$email = $settings['site_email'];
$site = '';
$icq = '';
$location = '';
$about = '';
if(isset($_POST['submit_registration'])) {
	$address = mysql_real_escape_string($_POST['server_address']);
	$steam = 0;
	$errors = Array();
	if(isset($_POST['server_steam'])) $steam = 1;
	$email = mysql_real_escape_string($_POST['server_email']);
	$site = mysql_real_escape_string($_POST['server_site']);
	$game = mysql_real_escape_string($_POST['server_game']);
	$mode = mysql_real_escape_string($_POST['server_mode']);
	$icq = mysql_real_escape_string($_POST['server_icq']);
	$location = mysql_real_escape_string($_POST['server_location']);
	$about = mysql_real_escape_string($_POST['server_about']);
	
	$regex_ipport = "[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\:[0-9]{1,5}";
	$regex_hostport = "[a-zA-Z0-9](-*[a-zA-Z0-9]+)*(\.[a-zA-Z0-9](-*[a-zA-Z0-9]+)*)+\:[0-9]{1,5}";
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors[] = "Необходимо ввести корректный E-mail адрес.";
	} elseif(empty($address)) {
		$errors[] = "Не заполнено обязательное поле \"Адрес сервера\"";
	} elseif(!preg_match("/$regex_ipport/", $address) and !preg_match("/$regex_hostport/i", $address)) {
		$errors[] = "Неверный формат адреса сервера.";
	} else {
		$check_server = mysql_query("SELECT * FROM `".DB_SERVERS."` WHERE `server_ip` = '{$address}'");
		if(mysql_num_rows($check_server) != 0) $errors[] = "Данный сервер уже есть в базе.";
	}
	if(!array_key_exists($location, $countries->countries)) $errors[] = "Выбрана несуществующая локация $location.";
	
	if(!empty($icq) and !is_numeric($icq)) {
		$errors[] = "Введите корректный ICQ.";
	} else {
		if(strlen($icq) > 9) $errors[] = "Введите корректный ICQ.";
	}
	
	if(!empty($site) and !isValidURL($site)) $errors[] = "Введите корректный адрес сайта.";
	
	if(count($errors) == 0) {
		$add_server_query = "INSERT INTO `".DB_SERVERS."` (
		`server_game`,
		`server_mode`,
		`server_ip`, 
		`server_location`, 
		`server_steam`, 
		`server_regdata`, 
		`server_email`, 
		`server_icq`, 
		`server_new`, 
		`server_site`, 
		`about`
		) 
		VALUES 
		(
		'{$game}', 
		'{$mode}',
		'{$address}', 
		'{$location}', 
		'{$steam}', 
		'".time()."', 
		'{$email}', 
		'{$icq}', 
		'0', 
		'{$site}', 
		'{$about}'
		)";
		
		$add_server = dbquery($add_server_query);
		if(!$add_server) $errors[] = "Ошибка записи в базу данных.";
	}
	
	if(count($errors) != 0) {
		$message = "<div class='message red'><span>{$errors[0]}</span></div>";
	} else {
		$message = "<div class='message green'><span><b>Успех</b>: сервер был успешно добавлен.</span></div>";
	}
}
/* Other code */
echo "<div id='right'>
		<div class='section'>
			<div class='box'>
				<div class='title'>Регистрация нового сервера в мониторинге<span class='hide'></span></div>
				<div class='content'>
					$message
					<form action='' method='POST'>
					<div class='row'>
						<label>Адрес сервера <font color='red'>*</font></label>
						<div class='right'>
							<input type='text' name='server_address' placeholder='127.0.0.1:27015' value='$address'>
						</div>
					</div>
					
		<div class='row'>				
<label>Игра сервера:</label>
			<div class='right'>
<select name='server_game' value='{$game}'>
     <option value='cs16'>Counter-Strike</option> 
     <option value='css'>Counter-Strike: Source</option> 
	 <option value='cz'>Counter Strike: Condition zero</option>
	 <option value='csgo'>Counter-Strike: Global Offensive</option> 
     <option value='hl2dm'>Half-Life 2</option> 
     <option value='hl2dm'>Half-Life 2 DM</option> 
     <option value='l4d'>Left 4 Dead</option> 
     <option value='l4d2'>Left 4 Dead 2</option>
     <option value='tf2'>Team Fortress 2</option> 
     <option value='gm'>Garry's Mod</option>
     </select>
	 	</div>
			</div>
			
					<div class='row'>				
<label>Мод сервера:</label>
			<div class='right'>
<select name='server_mode' value='{$mode}'>
   <option value='classic'>Classic</option>
<option value='warcraft'>Warcraft</option>
<option value='csdm'>CSDM</option>
<option value='gungame'>GunGame</option>
<option value='hns'>HNS</option>
<option value='surf'>Surf</option>
<option value='jump'>Jump</option>
<option value='deathrun'>Deathrun</option>
<option value='diablomod'>DiabloMod</option>
<option value='superhero'>SuperHero</option>
<option value='soccerjam'>Soccer Jam</option>
<option value='jailbreak'>JailBreak</option>
<option value='knife'>Knife</option>
<option value='zombiemod'>Zombie Mod</option>
     </select>
	 	</div>
			</div>
					
					<div class='row'>
						<label>Опции</label>
						<div class='right'>
							<input type='checkbox' name='server_steam' value='1' id='server_steam'".(($steam == 1) ? " checked='checked'" : "").">
							<label for='server_steam'>Сервер Steam</label>
						</div>
					</div>
										
					<div class='row'>
						<label>E-mail владельца <font color='red'>*</font></label>
						<div class='right'>
							<input type='text' name='server_email' value='$email' id='server_email'>
						</div>
					</div>
										
					<div class='row'>
						<label>Сайт сервера</label>
						<div class='right'>
							<input type='text' name='server_site' value='$site' id='server_site'>
						</div>
					</div>
										
					<div class='row'>
						<label>ICQ администратора</label>
						<div class='right'>
							<input type='text' name='server_icq' value='$icq' id='server_icq'>
						</div>
					</div>
					
					<div class='row'>
						<label>Локация сервера <font color='red'>*</font></label>
						<div class='right'>
							<select name='server_location' class='big'>";
							foreach($countries->countries as $country_code => $country_name) {
								echo "<option value='{$country_code}'".(($country_code == $location) ? " selected='selected'" : "").">{$country_name}</option>";
							}
echo "
						</select></div>
					</div>

					<div class='row'>
						<label>О сервере</label>
						<div class='right'>
							<textarea name='server_about' placeholder='Прочая информация о сервере...'>$about</textarea>
						</div>
					</div>
										
					<div class='row'>
						<div class='right'>
							<button type='submit' name='submit_registration' class='blue'><span>Зарегистрировать</span></button>  
							<button type='button' onClick='window.location.href='index.php'><span>Отмена</span></button>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
";
?>