<?php
require_once('cap/kcaptcha.php');

if (isset($_REQUEST[session_name()]))
    session_start();

$captcha = new KCAPTCHA();

if ($_REQUEST[session_name()])
    $_SESSION['captcha_keystring'] = $captcha->getKeyString();
