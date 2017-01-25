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
			
									<li>
					<p><a name="feedback-form" href="#" class="js" onclick="$('#f-999').slideToggle();return(false);">Я не нашел здесь ответа на свой вопрос!</a></p>
					<blockquote id="f-999" style="display:none;margin:10px 0;">
												<form action="/feedback/#feedback-form" method="post" class="select_serv_v">
	<label>ФИО:<input type="text" name="name" size="50" value="" /></label>

	<label>E-mail:<input type="text" name="email" size="50" value="" /></label>
	<label>Ваш сервер или сайт:<input type="text" name="server" size="50" value="" /><small>Адрес сервера: IP и порт</small></label>
	<label>Текст сообщения:<textarea name="text" cols="80" rows="7"></textarea></label>
	<label>Введите код на картинке *:<span style="display:block;margin:5px 0 0 0;"><img src="/images/icode.php?1772755449" alt="" id="icode" /></span><small><a href="#" class="js" onclick="$('#icode').attr('src', '/images/icode.php?' + Math.random());return(false);">сменить код</a></small><input type="text" name="icode" size="10" value="" autocomplete="off" /></label>
	<input type="submit" value="отправить" class="btn" />

</form>					</blockquote>
				</li>
			</ul>
			
			
		</li></ul></div>
<br><br><br><br><br><br><br>