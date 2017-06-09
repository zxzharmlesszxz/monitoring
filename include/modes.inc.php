<?php

$modes = array(
    'classic' => 'Classis',
    'warcraft' => 'WarCraft',
    'csdm' => 'DeathMatch',
    'gungame' => 'Gun Game',
    'hns' => 'HNS',
    'surf' => 'Surf',
    'jump' => 'Jump',
    'deathrun' => 'Deathrun',
    'diablomod' => 'Diablo',
    'superhero' => 'Super Hero',
    'jailbreak' => 'Jail Break',
    'soccerjam' => 'SoccerJam',
    'knife' => 'Knife',
    'zombiemod' => 'Zombie',
);


/**
 *
 */
function modes_menu()
{
    global $modes;
    echo "
    <div class='sort'>
     <ul class='sort_nav'>
 ";

    foreach ($modes as $mode => $title) {
        echo "<li><a title='Сервера с модом {$title}' href='/{$mode}' rel='nofollow'>{$title}</a></li>";
    }

    echo "
     </ul>
    </div>";
}

/**
 * @return string
 */
function select_modes()
{
    global $modes;
    $modess = array();

    foreach ($modes as $mode => $title) {
        $modess[$mode] = "<option value='{$mode}'>{$title}</option>";
    }

    return implode('\n', $modess);
}
