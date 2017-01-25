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
?>
<div class='horizontal_line'>Обратная связь</div>
<div class='cont'>
<div id="content" class="alone">
<br>

<h2>Если Вы хотите отправить нам сообщение, пожалуйста, посмотрите наш FAQ.</h2>
<br><div style="padding-left:10px;">
			<ul class="list">
					<p>Выберите проблему, с которой Вы столкнулись:</p>

				
		<li>
			<p><a href="#" class="js" onclick="$('#f-8').slideToggle();return(false);">У нас изменилось название сервера. Можно ли изменить название в мониторинге?</a></p>

			<blockquote id="f-8" style="display:none;margin:10px 0;">Название сервера меняется автоматически. Мы получаем название от Вашего сервера и сохраяем его у себя.</blockquote>
		</li>
		<li>
			<p><a href="#" class="js" onclick="$('#f-1').slideToggle();return(false);">Я добавил сервер, почему мне не пришло письмо о том, что он добавлен?</a></p>
			<blockquote id="f-1" style="display:none;margin:10px 0;">У нас автоматическая модерация. Письмо приходит тем, кто правильно прочитал условия добавления сервера в наш мониторинг.<br />Если на Вашем сайте, который Вы указали в анкете, установлена наша ссылка, то сервер будет мгновенно добавлен.<br />Никакие возражения и эмоции по этому поводу не принимаются.<br />Если Вы неправильно указали адрес сайта, то Вы сможете позже добавить сервер снова, т.к. он удалится из очереди модерации.</blockquote>
		</li>

		<li>
			<p><a href="#" class="js" onclick="$('#f-2').slideToggle();return(false);">Мне пришло письмо, что сервер добавлен, но я не вижу его на сайте!</a></p>
			<blockquote id="f-2" style="display:none;margin:10px 0;">Скорее всего, робот еще не успел проиндексировать Ваш сервер.<br />Или же он не может получить от него ответ (ввиду того, что тот выключен или имеются проблемы со связью).<br />Ничего с этим поделать нельзя.</blockquote>
		</li>
		<li>
			<p><a href="#" class="js" onclick="$('#f-3').slideToggle();return(false);">Я хочу поднять свой сервер в топ или выделить цветом!</a></p>

			<blockquote id="f-3" style="display:none;margin:10px 0;">Специально для Вас на <a href="/how/">этой странице</a> написано, что нужно делать, чтобы этого достичь.<br />Вы регистрируетесь, пополняете счет, делаете заказ.<br />Схема простая и вопросов возникнуть не должно.</blockquote>
		</li>
		<li>
			<p><a href="#" class="js" onclick="$('#f-4').slideToggle();return(false);">Я перевел на счет деньги с помощью Яndex.money, но они до сих пор не поступили на счет!</a></p>
			<blockquote id="f-4" style="display:none;margin:10px 0;">Вы не забыли указать в комментарии к переводу свой логин, на который необходимо зачислить деньги?<br />Если нет — то деньги будут зачислины в течении 2-3 дней.<br />Если да — пишите через <a class="js" onclick="$('#f-4').slideUp();$('#f-999').slideDown();return(false);">обратную связь</a>, с какого кошелька Вы платили и на какой логин надо зачислить.<br />С WebMoney таких вопросов не возникает, там деньги приходят мгновенно.</blockquote>

		</li>
		<li>
			<p><a href="#" class="js" onclick="$('#f-7').slideToggle();return(false);">Я пополнил свой счет, но не могу сделать заказ, т.к. все места заняты и хочу вернуть средства!</a></p>
			<blockquote id="f-7" style="display:none;margin:10px 0;">Действительно, чтобы сделать заказ, необходимо подождать, пока освободится место. Но можно и вернуть деньги.<br />Вам необходимо со <strong>своего e-mail</strong> написать в нашу службу поддержки по адресу <a href="mailto:info@my-cs.ru">info@my-cs.ru</a><br />просьбу о возврате денежных средств. Возврат производится в течении 5 рабочих дней.</blockquote>
		</li>

		<li>
			<p><a href="#" class="js" onclick="$('#f-6').slideToggle();return(false);">Меня забанили на Вашем сервере!</a></p>
			<blockquote id="f-6" style="display:none;margin:10px 0;">Нашем сервере? — Тут нет наших серверов. Мы мониторим и выдаем статистику по <strong>чужим</strong> серверам.<br />Для Вас имеет смысл зайти на страничку этого сервера и найти сайт поддержки сервера и там найти контакты администраторов, чтобы разобраться.<br />Писать в нашу обратную связь не имеет смысла, такие сообщения игнорируются.</blockquote>
		</li>
		<li>

			<p><a href="#" class="js" onclick="$('#f-5').slideToggle();return(false);">Мы хотим разместить у Вас рекламу. Сколько и за что?</a></p>
			<blockquote id="f-5" style="display:none;margin:10px 0;">На данный момент доступен только один вид рекламы на сайте — баннер в шапке.<br />Но мы готовы рассмотреть и другие варианты, которые не будут ущимлять интересы наших пользователей ни в чем.<br />Наша аудитория — молодые люди преимущественно в возрасте от 14 до 25 лет.<br />По <a href="#" onclick="$('#f-5').slideUp();$('#f-999').slideDown();return(false);" class="js">Вашему запросу</a> мы можем выслать гостевой доступ к статистике и рассказать о ценах на рекламу.</blockquote>
		</li>
		<li>
			<p><a href="#" class="js" onclick="$('#f-9').slideToggle();return(false);">Пропали все голоса за сервер, что делать?</a></p>

			<blockquote id="f-9" style="display:none;margin:10px 0;">Настал новый месяц? Все голоса сброшены. Об этом уже давно написано <a href="/how/">здесь</a>.</blockquote>
		</li></ul></div>
<br>
<h2>Вы не нашли ответа на свой вопрос? Тогда напишите нам!</h2>
<form id="formm" action="http://www.formm.ru/mail/" method="post" onsubmit="return verif();"><input type="hidden" name="subject" value="support@mon-servers.ru"/><input type="hidden" name="colors" value="232323.363636.FFFFFF.000000"/><div style="margin-left:50%;position:relative; left:-200px; width:400px;background:#363636;color:#FFFFFF;border:1px solid #000000;font:12px sans-serif;"><div style="padding:20px;background:#3FBDD1;color:#000000;border:1px solid #880000;text-align:center;"><strong>ОБРАТНАЯ СВЯЗЬ</strong></div><div style="padding:0 15px 10px 15px;border-top:solid 1px #000000;"><div style="margin-top:10px;">Ваше имя</div><input name="name" type="text" style="margin-left:-1px;width:100%;height:20px;background:#FFFFFF;color:#880000;border:1px solid #880000;font:13px sans-serif;" maxlength="50" /><div style="margin-top:10px;">Обратный e-mail</div><input name="email" type="text" style="margin-left:-1px;width:100%;height:20px;background:#FFFFFF;color:#880000;border:1px solid #880000;font:13px sans-serif;" maxlength="50" /><div style="margin-top:10px;">Сообщение</div><textarea name="text" style="margin-left:-1px;width:100%;height:100px; background:#FFFFFF;color:#880000;border:1px solid #880000;font:13px sans-serif;" rows="5" cols="20"></textarea><div style="width:100%;margin-top:10px;overflow:auto;"><a style="float:left;" href="http://www.formm.ru/"><img border="0" src="http://www.formm.ru/captcha/" alt="captcha"/></a><div style="margin-left:110px;"><div>Проверочный код</div><input name="captcha" type="text" style="margin-left:-2px;width:100%;height:20px; background:#FFFFFF;color:#880000;border:1px solid #880000;font:13px sans-serif;" maxlength="6" /></div></div><div style="margin-top:10px; text-align:center;"><input type="submit" value="Отправить" style="width:155px;height:25px;background:#232323;color:#FFFFFF;border-color:#FFFFFF;font:14px sans-serif; cursor:pointer;" /></div></div></div></form><script type="text/javascript">/*<![CDATA[*/ function verif() { var f = {}; var fm=document.forms["formm"].elements; for(var i=0; i<fm.length; i++) { var n=fm[i].name; var v=fm[i].value; if (n!="subject" && n!="colors" && n!="file" && v=="") { alert ("Заполните все поля формы"); return false; } else f[n]=v; } if(!f.email.match(/^[a-z\d]+((\.|\-)?[a-z\d]+)*@[a-z\d]+((\.|\-)?[a-z\d]+)*\.[a-z]{2,4}$/i)) { alert ("Укажите правильный e-mail"); return false; } else if (!f.captcha.match(/^[a-z\d]{5,6}$/i)) { alert ("Ошибка в проверочном коде"); return false; } else return true; } /*]]>*/</script>