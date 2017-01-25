<?php
/*
 * Menu display class
 * Made by starky
*/

/* Script security */
if (!defined("MONENGINE")) {
 header("Location: index.php");
 exit();
}

/* CLASS CODE */

class Menu {
 public $pages = Array();
 public $curpage;
 
 public function show() {
  foreach ($this->pages as $page) {
    $class = ($page['name'] == $this->curpage) ? "class='current'" : "";
   echo "<li {$class}><a href='{$page['url']}' title='{$page['descr']}'>{$page['title']}</a></li>";
  }
 }
 
 public function set($name) {
  $this->curpage = $name;
 }
 
 public function add($name, $url, $title, $descr='') {
  $this->pages[$name]['url'] = $url;
  $this->pages[$name]['title'] = $title;
  $this->pages[$name]['descr'] = $descr;
  $this->pages[$name]['name'] = $name;
 }
}
