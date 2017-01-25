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


$server = "mail";

function socketmail($server='localhost', $to, $from, $subject, $message) {
    $connect = fsockopen ($server, 25, $errno, $errstr, 30);
    sleep(10);
    fputs($connect, "HELO $server\r\n");
    sleep(3);
    fputs($connect, "MAIL FROM: $from\n");
    sleep(3);
    fputs($connect, "RCPT TO: $to\n");
    sleep(3);
    fputs($connect, "DATA\r\n");
    sleep(1);
    fputs($connect, "Content-Type: text/plain; charset=utf8\n");
    fputs($connect, "To: $to\n");
    fputs($connect, "Subject: $subject\n");
    fputs($connect, "\n\n");
    fputs($connect, stripslashes($message)." \r\n");
    fputs($connect, ".\r\n");
    fputs($connect, "RSET\r\n");
}



?>

<div class='horizontal_line'>Обратная связь</div>
<div class='cont'>

		<style>td.faq-arrow {padding-top: 5px;padding-bottom: 5px;}</style>
		<style>td.faq {padding-left: 10px;padding-top: 5px;padding-bottom: 5px;}</style>
		<style>div.faq-answer {margin-top: 5px;padding:5px;padding-left:10px;padding-right:10px;background:#413F3F;border: 1px solid #3E3E3E;display:none;}</style>
		<style>div.answer-open {padding-bottom:2px;}</style>
		<style>.answer-open a {text-decoration:none;padding-bottom:1px;border-bottom: 1px dashed;}</style>
		<script>
			jQuery( document ).ready( function($) {
				$(".answer-open-l a").click( function(){
					$(this.parentElement.parentElement).find(".faq-answer").toggle();
					return false;
				});
				
				$(".answer-open-sb a").click( function(){
					$('#sendbox-a').toggle();
					return false;
				});
			});
		</script>
		<div class="faq2">Если Вы хотите отправить нам сообщение, пожалуйста, посмотрите наш FAQ.</div>
		<div style="padding-left:10px;">
			<table cellpadding="0" cellspacing="0">

			<tr>
					<td valign="top" class="faq-arrow"><img src="/images/para-vip.gif" width="9" height="13" style="margin-top:2px;" /></td>
					<td valign="top" class="faq">
						<div class="answer-open answer-open-l"><a href="#">Что это за сайт и для чего он нужен?</a></div>
						<div class="faq-answer">
							Вы попали на сайт Мониторинга игровых серверов по Украине. <br>
							Наш мониторинг собирает информацию от серверов CS 1.6, CS:S, CS:GO каждые 3 минуты и показывает её вам<br>
							 <br>
							 
						</div>
					</td>
				</tr>
			
			<tr>
					<td valign="top" class="faq-arrow"><img src="/images/para-vip.gif" width="9" height="13" style="margin-top:2px;" /></td>
					<td valign="top" class="faq">
						<div class="answer-open answer-open-l"><a href="#">Как работает ВИП и ТОП</a></div>
						<div class="faq-answer">
							ВИП - это раскрутка вашего сервера через сайт и в самом мониторинге.</br>
							ТОП - это раскрутка вашего сервера в шапке мониторинга.</br>
						    							 
						</div>
					</td>
				</tr>

				<tr>
					<td valign="top" class="faq-arrow"><img src="/images/para-vip.gif" width="9" height="13" style="margin-top:2px;" /></td>
					<td valign="top" class="faq">
						<div class="answer-open answer-open-l"><a href="#">Возможно ли программно раскрутить сервер?</a></div>
						<div class="faq-answer">
							Наш ответ - НЕТ. Реально работаящих программ для раскрутки игровых серверов <b>НЕ СУЩЕСТВУЕТ!<b><br>
							Поэтому если вам кто то предлагает программу для раскрутки, пожалуйста, не ведитесь. Скорее всего вас обманут.<br>
							Раскручивать сервера лучше всего путем покупки ВИП/ТОП/Буст слуг в мониторингах.
						</div>
					</td>
				</tr>
				<tr>
					<td valign="top" class="faq-arrow"><img src="/images/para-vip.gif" width="9" height="13" style="margin-top:2px;" /></td>
					<td valign="top" class="faq">
						<div class="answer-open answer-open-l"><a href="#">Меня забанили на сервере!</a></div>
						<div class="faq-answer">
							К сожелению, в таком случае мы ничем не можем вам помочь.<br>
							В мониторинге нету наших серверов. Мы мониторим только сервера пользователей.
					
						</div>
					</td>
				</tr>
				
				
								<tr>
					<td valign="top" class="faq-arrow"><img src="/images/para-vip.gif" width="9" height="13" style="margin-top:2px;" /></td>
					<td valign="top" class="faq">
						<div class="answer-open answer-open-l"><a href="#">Как редактировать свой сервер?</a></div>
						<div class="faq-answer">
							Редактировать свой сервер вы можете на этом странице http://monitoring.contra.net.ua/edit/<br>
							Там потребуется указать ID вашего сервера и ваш Email который вы вводили при добавлении сервера.<br>
							Вам на емайл придет письмо с ссылкой к странице редактирвоания вашего сервера (ссылка одноразовая)
							
						</div>
					</td>
				</tr>
				
				<tr>
					<td valign="top" class="faq-arrow"><img src="/images/para-vip.gif" width="9" height="13" style="margin-top:2px;" /></td>
					<td valign="top" class="faq">
						<div class="answer-open answer-open-l"><a href="#">Как мне узнать то, что сервер добавлен?</a></div>
						<div class="faq-answer">
							В <a href="hsearch" target="_blank">поиск</a> впишите IP:PORT сервера.<br>
							Если сервер добавлен, то в результате поиска вы сразу же его увидите.
						</div>
					</td>
				</tr>
				<tr>
					<td valign="top" class="faq-arrow"><img src="/images/para-vip.gif" width="9" height="13" style="margin-top:2px;" /></td>
					<td valign="top" class="faq">
						<div class="answer-open answer-open-l"><a href="#">При добавлении сервера ошибка, что сервер не отвечает, как быть?</a></div>
						<div class="faq-answer">
							Возможно сервер выключен или на нем идет смена карты. Подождите немного, и попробуйте добавить сервер еще раз.<br />
							<b>Если вы добавляете сервера IP адреса которых начинаются с 192., 127. или 10., добавлять их не стоит, они доступны только с вашей LAN сети.</b>
						</div>
					</td>
				</tr>
				<tr>
					<td valign="top" class="faq-arrow"><img src="/images/para-vip.gif" width="9" height="13" style="margin-top:2px;" /></td>
					<td valign="top" class="faq">
						<div class="answer-open answer-open-l"><a href="#">У нас изменилось название сервера. Как изменить его в мониторинге?</a></div>
						<div class="faq-answer">
							Название сервера меняется автоматически. Мы получаем название от Вашего сервера и сохраяем его у себя в базе данных.
						<br> Поэтому радактировать его вручную не имеет никакого смысла.
						</div>
					</td>
				</tr>
			
				<tr>
					<td valign="top" class="faq-arrow"><img src="/images/para-vip.gif" width="9" height="13" style="margin-top:2px;" /></td>
					<td valign="top" class="faq">
						<div class="answer-open answer-open-l"><a href="#">Сколько человек заходит на ваш сайт?</a></div>
						<div class="faq-answer">
							На данный момент наш сайт посещают около трехсот уникальных посетителей в сутки.<br>
							С каждым днем мы стараемся все больше и больше пользователей привлечь на наш сайт.
							</div>
					</td>
				</tr>
				<tr>
			
					<td valign="top" class="faq-arrow"><img src="/images/para-vip.gif" width="9" height="13" style="margin-top:2px;" /></td>
					<td valign="top" class="faq">
						<div class="answer-open answer-open-l"><a href="#">Как сменить Email и Владельца сервера?</a></div>
						<div class="faq-answer">
							Нужно связаться с администрацией по Skype: vengeanson, далее<br>
							в название вашего сервера (cstrike/server.cfg переменная hostname) вписать ID вашего сервера в нашем Мониторинге, например:<br>
							Для сервера http://monitoring.contra.et.ua/server/16 - .:HOT:.tm>|qq CEPBEP, ID сервера = 16<br><br>
							После чего сообщить свой Email, для передачи прав на управление сервером.<br><br>
							ВНИМАНИЕ! Если администрации сайта нету в сети или вам не отвечают, не оставляйте в названии вашего сервера его ID<br>
							Мошенники смогут написать нам и получить доступ на управление вашим сервером!
						</div>
					</td>
				</tr>
				
	
					<td valign="top" class="faq-arrow"><img src="/images/para-vip.gif" width="9" height="13" style="margin-top:2px;" /></td>
					<td valign="top" class="faq">
						<div class="answer-open answer-open-l"><a href="#">Наши контакты - ICQ/Skype/Email</a></div>
						<div class="faq-answer">
							Если вы прочитали весь FAQ и не нашли ответа, вы можете связаться с нами.<br>
							Внимание, на вопросы, на которые есть ответы в FAQ, техническая поддержка отвечать не будет!<br><br>
							
							Возможна связь через Skype: vengeanson, Email: noise98@ukr.net<br>
							(Добавлять нас в список контактов не нужно! Нужно писать сразу по существу проблемы или вопроса!)<br><br>
							Внимание! Контакты Технической поддержки предназначены только для решения технических проблем!<br>
							Ни каких консультаций по поводу раскрутки или настройки игры мы не оказываем!
						</div>
					</td>
				</tr>
				<tr>
					<!--td valign="top" class="faq-arrow"><img src="/images/para-vip.gif" width="9" height="13" style="margin-top:2px;" /></td>
					<td valign="top" class="faq">
						<div class="answer-open answer-open-sb"><a href="#">Я прочитал весь FAQ и не нашел здесь ответа на свой вопрос!</a></div>
					</td-->
				</tr>
			</table>
		</div>
		
		<div class="faq2">Если Вы не нашли ответ на свой вопрос, то отправте нам сообщение:</div>

	<?php


                 $error    = ''; // сообщение об ошибке
                 $name     = ''; // имя отправителя
                 $email    = ''; // email отправителя
                 $subject  = ''; // тема
                 $message  = ''; // сообщение
               	 $spamcheck = ''; // проверка на спам

            if(isset($_POST['send']))
            {
                 $name     = stripinput($_POST['name']);
                 $email    = stripinput($_POST['email']);
                 $subject  = stripinput($_POST['subject']);
                 $message  = stripinput($_POST['message']);
				 $captcha = stripinput($_POST['keystring']);
                if(trim($name) == '')
	
			{
            
			        $error = "<div class='msg redbg'>Вы не ввели своё имя.</div>";
                }
            	    else if(trim($email) == '')
                {
                    $error = "<div class='msg redbg'>Вы не ввели свой e-mail.</div>";
                }
                else if(!isEmail($email))
                {
                    $error = "<div class='msg redbg'>Вы ввели не правильный e-mail.</div>";
                }
            	    if(trim($subject) == '')
                {
                    $error = "<div class='msg redbg'>Вы не ввели тему сообщения.</div>";
                }
            	else if(trim($message) == '')
                {
                    $error = "<div class='msg redbg'>Вы не ввели сообщение.</div>";
                }
					
				else if(isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] !== $captcha){
				$error = "<div class='msg redbg'>Вы не верно ввели текст с картинки.</div>";
				}
				unset($_SESSION['captcha_keystring']);
                if($error == '')
                {

			
                    if(get_magic_quotes_gpc())
                    {
                        $message = stripslashes($message);
                    }

                 
                    $to = $settings['site_email'];

                
               $subject = $locale_conact['007']." : " . $subject;

                    $msg     = "From : $name \r\ne-Mail : $email \r\nSubject : $subject \r\n\n" . "Message : \r\n$message";

                    mail($to, $subject, $msg, "From: $email\r\nReply-To: $email\r\nReturn-Path: $email\r\n");

            ?>

                  <div style="text-align:center;">

                       <div class='msg greenbg'>Спасибо <?=$name;?>, Ваше сообщение успешно отправлено администрации!</div>
                  </div>


            <?php
                }
            }

            if(!isset($_POST['send']) || $error != '')
            {
            ?>

            <?=$error;?>

			
            <form  method="post" name="contFrm" id="contFrm" action="">


					<form action='' method='POST'>
		<table width='100%' class='regform'>

			
			<tr>
			
			
                      <td align='right'>Полное имя:</td>
            			<td><input name="name" type="text" class="box" id="name" size="30" value="<?=$name;?>" /></td></tr>
<tr>
            			 <td align='right'>Ваш E-mail:</td>
            			 	<td><input name="email" type="text" class="box" id="email" size="30" value="<?=$email;?>" /></td></tr>
<tr>
            			 <td align='right'>Тема письма:</td>
            			<td><input name="subject" type="text" class="box" id="subject" size="30" value="<?=$subject;?>" /></td></tr>
<tr>
            			<td align='right'>Сообщение:</td>
                 		<td><textarea name="message" cols="40" rows="3"  id="message"><?=$message;?></textarea></td></tr>
<tr>
				<td align='right'>Код безопасности:</td>
				<td><img src='cap/index.php?".session_name()."=".session_id()."'></td>
			</tr>
			<tr>
				<td align='right'>&nbsp;</td>
				<td><input type='text' style='width:160px;' name='keystring' /></td>
			</tr>
<tr>
<td colspan='2' align='center'>
           		   <input name="send" type="submit" class="button" id="send" value="Отправить сообщение" /></tr></td>

</table>

            <?php
            }

            function isEmail($email)
            {
                return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i"
                        ,$email));
            }
            
						
?>
<br>
<center><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- CS 1.6 как лучшая игра -->
<ins class="adsbygoogle"
     style="display:inline-block;width:320px;height:100px"
     data-ad-client="ca-pub-0760255674877926"
     data-ad-slot="4806637623"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></center>
						
				
     
