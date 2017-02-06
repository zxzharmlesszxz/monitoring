<?php

$modes = array(
 'classic',
 'warcraft',
 'csdm',
 'gungame',
 'hns',
 'surf',
 'jump',
 'deathrun',
 'diablomod',
 'superhero',
 'jailbreak',
 'soccerjam',
 'knife',
 'zombie',
);


function modes_menu() {
 echo "
    <div class="sort">
     <ul class="sort_nav">
 ";

 foreach ($modes as $mode) {
  echo "<li><a title='Сервера с модом {$mode}' href='/{$mode}' rel='nofollow'>{$mode}</a></li>";
 }

 echo "
     </ul>
    </div>";
}
