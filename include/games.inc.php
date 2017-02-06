<?php

$games = array(
 'cs16' => 'CS 1.6',
 'csgo' => 'CS: GO',
 'cssource' => 'CS: Source',
 'cszero' => 'CS: Zero',
 'hl' => 'Half-Life',
 'hl2' => 'Half-Life 2',
 'l4d' => 'Left 4 dead',
 'l4d2' => 'Left 4 dead 2',
 'teamfortess' => 'Team Fortess',
 'garrysmod' => 'Garry\'s Mod',
);


function games_menu() {
 global $games;
 echo "
    <div id='sort'>
     <ul>
      <li><a title='Все сервера мониторинга' href='/' rel='nofollow'>Все сервера</a></li>
 ";

 foreach ($games as $game => $name) {
  echo "<li><a title='Игровые сервера {$name}' href='/{$game}' rel='nofollow'>{$name}</a></li>";
 }

 echo "
     </ul>
    </div>";
}

function select_games() {
 global $games;
 foreach ($games as $game => $title){
  $games[$game] = "<option value='{$game}'>{$title}</option>";
 }
 return implode('\n', $games);
}
