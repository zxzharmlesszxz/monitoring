<?php
define("MONENGINE", true);
error_reporting(E_ALL);
// вся процедура работает на сессиях. Именно в ней хранятся данные пользователя, пока он находится на сайте. Очень важно запустить их в самом начале странички!!!
// подключаемся к базе
include("../core.php");
// some file
require_once("includes/inc.php");
session_start();
$msg_color = 'blue';
$msg_text = "<b>Подсказка</b>: нажмите кнопку \"Войти\" чтобы авторизоваться.";

if(count($_POST) != 0 and !$logged_in) {
	if(isset($_POST['username'])) {
		$login = $_POST['username'];
		if ($login == '') unset($login); 
	}

	if(isset($_POST['password'])) {
		$password = stripinput($_POST['password']);
		if($password =='') unset($password);
	}

	if(empty($login) or empty($password)) {
		$msg_color = 'red';
		$msg_text = "<b>Ошибка</b>: Вы ввели не все данные.";
	} else {
		//если логин и пароль введены,то обрабатываем их, чтобы теги и скрипты не работали, мало ли что люди могут ввести
		$login = stripslashes($login);
		$login = htmlspecialchars($login);
		$password = md5(md5($password));

		//удаляем лишние пробелы
		$login = trim($login);

		$result = dbquery("SELECT * FROM ".DB_ADMIN." WHERE admin_name='".$login."'");
		$myrow = dbarray_fetch($result);

		if(empty($myrow['admin_pass'])) {
			$msg_color = 'red';
			$msg_text = "<b>Ошибка</b>: введён неправильный логин, либо пароль.";
		} else {
			if($myrow['admin_pass'] == $password) {
				$_SESSION['admin_name'] = $myrow['admin_name']; 
				$_SESSION['admin_id'] = $myrow['admin_id'];
				$_SESSION['admin_password'] = $myrow['admin_pass'];
				$msg_color = 'green';
				$msg_text = "<b>Успех</b>: Вы упешно авторизовались.";
				$logged_in = true;
			} else {
				$msg_color = 'red';
				$msg_text = "<b>Ошибка</b>: введён неправильный логин, либо пароль.";
			}
		}
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
	<title>Вход в систему</title>
	<?php if($logged_in) echo "<meta http-equiv='Refresh' content='3; URL=".$settings['site_url']."backend/index.php'>";?>
<style type="text/css">
		@import url("template/css/style.css");
		@import url("template/css/forms.css");
		@import url("template/css/forms-btn.css");
		@import url("template/css/menu.css");
		@import url('template/css/style_text.css');
		@import url("template/css/datatables.css");
		@import url("template/css/fullcalendar.css");
		@import url("template/css/pirebox.css");
		@import url("template/css/modalwindow.css");
		@import url("template/css/statics.css");
		@import url("template/css/tabs-toggle.css");
		@import url("template/css/system-message.css");
		@import url("template/css/tooltip.css");
		@import url("template/css/wizard.css");
		@import url("template/css/wysiwyg.css");
		@import url("template/css/wysiwyg.modal.css");
		@import url("template/css/wysiwyg-editor.css");
</style>
	
	<!--[if lte IE 8]>
		<script type="text/javascript" src="template/js/excanvas.min.js"></script>
	<![endif]-->
	
	<script type="text/javascript" src="template/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="template/js/jquery.backgroundPosition.js"></script>
	<script type="text/javascript" src="template/js/jquery.placeholder.min.js"></script>
	<script type="text/javascript" src="template/js/jquery.ui.1.8.17.js"></script>
	<script type="text/javascript" src="template/js/jquery.ui.select.js"></script>
	<script type="text/javascript" src="template/js/jquery.ui.spinner.js"></script>
	<script type="text/javascript" src="template/js/superfish.js"></script>
	<script type="text/javascript" src="template/js/supersubs.js"></script>
	<script type="text/javascript" src="template/js/jquery.datatables.js"></script>
	<script type="text/javascript" src="template/js/fullcalendar.min.js"></script>
	<script type="text/javascript" src="template/js/jquery.smartwizard-2.0.min.js"></script>
	<script type="text/javascript" src="template/js/pirobox.extended.min.js"></script>
	<script type="text/javascript" src="template/js/jquery.tipsy.js"></script>
	<script type="text/javascript" src="template/js/jquery.elastic.source.js"></script>
	<script type="text/javascript" src="template/js/jquery.customInput.js"></script>
	<script type="text/javascript" src="template/js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="template/js/jquery.metadata.js"></script>
	<script type="text/javascript" src="template/js/jquery.filestyle.mini.js"></script>
	<script type="text/javascript" src="template/js/jquery.filter.input.js"></script>
	<script type="text/javascript" src="template/js/jquery.flot.js"></script>
	<script type="text/javascript" src="template/js/jquery.flot.pie.min.js"></script>
	<script type="text/javascript" src="template/js/jquery.flot.resize.min.js"></script>
	<script type="text/javascript" src="template/js/jquery.graphtable-0.2.js"></script>
	<script type="text/javascript" src="template/js/jquery.wysiwyg.js"></script>
	<script type="text/javascript" src="template/js/controls/wysiwyg.image.js"></script>
	<script type="text/javascript" src="template/js/controls/wysiwyg.link.js"></script>
	<script type="text/javascript" src="template/js/controls/wysiwyg.table.js"></script>
	<script type="text/javascript" src="template/js/plugins/wysiwyg.rmFormat.js"></script>
	<script type="text/javascript" src="template/js/costum.js"></script>
	
</head>

<body>

<div id="wrapper" class="login">
	
	<div class="box">
		<div class="title">
			Вход в систему
			<span class="hide"></span>
		</div>
		<div class="content">
			<div class="message inner <?php echo $msg_color;?>">
				<span><?php echo $msg_text;?></span>
			</div>
			<?php
			if(!$logged_in) {
				echo "
				<form method='POST'>
					<div class='row'>
						<label>Имя пользователя</label>
						<div class='right'><input type='text' name='username' value='' /></div>
					</div>
					<div class='row'>
						<label>Пароль</label>
						<div class='right'><input type='password' name='password' value='' /></div>
					</div>
					<div class='row'>
						<div class='right'>
							<button type='submit'><span>Войти</span></button>
						</div>
					</div>
				</form>
				";
			} else {
				echo "Вы будете перенаправлены через 3 секунды.<br>
				Нажмите <a href='index.php'>сюда</a> для немедленного перехода.";
			}
			?>
		</div>
	</div>
	
</div>

</body>

</html> 