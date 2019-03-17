function rating( server_id, direction, hash ) {
		if ($.cookies.get("vote" + server_id)) {
			alert ("Вы уже голосовали за этот сервер");
		} else if ($("#votes_count_"+server_id).html() == 0 && direction !="up") {
			alert ("Нельзя голосовать в минус");
		} else {
		alert ("Ваш голос успешно засчитан");
		$(this).parent().html("<img src='images/spinner.gif'/>");
		$("span#votes_count_"+server_id).fadeOut("fast");
		
		// ajax
			$.ajax({
				type: "POST",
				data: "action=vote"+direction+"&id="+server_id+"&hash="+hash,
				url:  "vote",
				success: function(msg)
				{
					if(msg == "cant_down") {
						alert ("Нельзя голосовать в минус");
					} else {
						$("span#votes_count_"+server_id).html(msg);
						
						$("span#votes_count_"+server_id).fadeIn();
				
						$("span#vote_buttons_"+server_id).remove();
						// set up a cookie
						$.cookies.set("vote" + server_id, 12345679, {hoursToLive: 24});
					}
				}
			});
		} // end
};
