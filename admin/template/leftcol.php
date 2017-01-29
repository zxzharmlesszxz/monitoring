<?php
		
$comments_num = dbquery("SELECT id FROM `".DB_COMMENTS."`");
$comments_num = mysql_num_rows($comments_num);
$last_update = @date("d.m H:i", $settings['last_update']);

echo <<<EOT
		<div id="left">
			<div class="box statics">
				<div class="content">
					<ul>
						<li>
          <h2>Статистика</h2>
        </li>
						<li>Отзывов <div class="info blue"><span>{$comments_num}</span></div></li>
						<li>Серверов online<div class="info green"><span>{$servers_total}</span></div></li>
						<li>Обновление <div class="info black"><span>{$last_update}</span></div></li>
					</ul>
				</div>
			</div>
		</div>
EOT;
