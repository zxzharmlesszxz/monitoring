var replyId = 0;
						
function setReplyId(id) {
	replyId = id;
}
						
function delReply() {
	$.ajax({
		type: "POST",
		url: "do.php",
		data: "task=delreply&id="+replyId,
		success: function(msg){
			if(msg == 'fail') {
				alert('Не удалось удалить запись.');
			} else if(msg == 'success') {
				$('#comment_'+replyId).remove();
			}
		}
	});
	dialogClose('.modal');
	if($('ul.comments').children('li').length == 1) {
		$('ul.comments').append('<li class="comment"><center>Список отзывов пуст.</center></li>');
	}
}

function changeStatus(id) {
	$.ajax({
		type: "POST",
		url: "do.php",
		data: "task=changestatus&id="+id,
		success: function(msg){
			if(msg == 'fail') {
				alert('Не удалось изменить статус.');
			} else if(msg == 'success') {
				window.location.reload();
			}
		}
	});
	dialogClose('.modal');
}
						
function dialogClose(id) {
	$(id).dialog('close');
}

function approveReply(id, type) {
	$.ajax({
		type: "POST",
		url: "do.php",
		data: "task=approvereply&id="+id+"&type="+type,
		success: function(msg){
			if(msg == 'success') {
				$('#reply_'+id).remove();
				var not_approved = $('#not_approved').text();
				var not_approved = not_approved - 1;
				$('#not_approved').text(not_approved);
			} else {
				alert('Ошибка подтверждения');
			}
		}
	});
}