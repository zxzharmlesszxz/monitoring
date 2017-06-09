<?php

/**
 * Class ServerEdit
 */
class ServerEdit
{
    /**
     * @var
     */
    var $subject;
    /**
     * @var
     */
    var $server_id;
    /**
     * @var
     */
    var $server_email;
    /**
     * @var
     */
    var $server_data;
    /**
     * @var
     */
    var $secret_key;
    /**
     * @var array
     */
    var $errors = Array();
    /**
     * @var
     */
    var $message;
    /**
     * @var array
     */
    var $save_errors = Array();
    /**
     * @var array
     */
    var $edit_data = Array();


    /**
     * @return bool
     */
    public function CheckData()
    {
        if (!is_numeric($this->server_id) or !isValidEmail($this->server_email)) {
            if (!is_numeric($this->server_id)) $this->errors[] = "Некорректный id сервера.";
            if (!isValidEmail($this->server_email)) $this->errors[] = "Некорректный E-mail.";

            return false;
        }
        $get_server = db()->query("SELECT * FROM `" . DB_SERVERS . "` WHERE `server_id` = '{$this->server_id}' AND `server_email` = '{$this->server_email}'");
        if (db()->num_rows($get_server) == 0) {
            $this->errors[] = "Ошибка: Введен неправильный адрес электропочты или адрес сервера.";

            return false;
        } else {
            $this->server_data = db()->fetch_array($get_server);
            return true;
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public function SetServerId($id)
    {
        if (is_numeric($id)) {
            $this->server_id = $id;
            return true;
        }
        return false;
    }

    /**
     * @param $email
     * @return bool
     */
    public function SetServerEmail($email)
    {
        if (isValidEmail($email)) {
            $this->server_email = $email;
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function SetupKey()
    {
        if (!is_numeric($this->server_id)) return false;
        $length = 100;
        $key = '';
        list($usec, $sec) = explode(' ', microtime());
        mt_srand((float)$sec + ((float)$usec * 100000));
        $inputs = array_merge(range('z', 'a'), range(0, 9), range('A', 'Z'));
        for ($i = 0; $i < $length; $i++) {
            $key .= $inputs{mt_rand(0, 61)};
        }
        $this->secret_key = $key;
        $lifetime = time() + 1800;
        $add_link = db()->query("INSERT INTO `" . DB_SERVERS_EDITS . "` (`edit_server_id`, `edit_secret_key`, `edit_lifetime`) VALUES ('{$this->server_id}','{$this->secret_key}', '{$lifetime}')");
        if ($add_link) return true;
        return false;
    }

    /**
     * @return bool
     */
    public function SendMail()
    {
        if (!is_array($this->server_data)) return false;
        global $settings;
        $this->headers = "Content-Type: text/html; charset = utf-8";
        $this->subject = "Редактирование сервера :: monitoring.contra.net.ua";
        $this->message = "
Доброго времени суток. Вы отправили запрос на редактирование сервера в мониторинге https://monitoring.contra.net.ua.
Для редактирования воспользуйтесь этой ссылкой : {$settings['site_url']}edit/key/{$this->secret_key}/
Ссылка будет доступна 30 минут с начала подачи заявки.

			Если Вы не подавали заявки на редактирование, то просто проигнорируйте данное письмо.
			С уважением команда мониторинга  https://monitoring.contra.net.ua
";
        $send_mail = mail($this->server_data['server_email'], $this->subject, $this->message);
        return ($send_mail) ? true : false;
    }

    /**
     * @param $key
     * @return bool
     */
    public function CheckKey($key)
    {
        if (strlen($key) != 100) return false;
        $key = db()->escape_value($key);
        $check_key = db()->query("SELECT * FROM `" . DB_SERVERS_EDITS . "` WHERE BINARY `edit_secret_key` = '{$key}' AND `edit_lifetime` > '" . time() . "' AND `edit_date` = '0' LIMIT 1");
        $this->edit_data = db()->fetch_array($check_key);
        if (db()->num_rows($check_key) == 0) return false;
        $check_server = db()->query("SELECT * FROM `" . DB_SERVERS . "` WHERE `server_id` = '{$this->edit_data['edit_server_id']}'");
        if (db()->num_rows($check_server) == 0) return false;
        $this->server_data = db()->fetch_array($check_server);
        $this->server_id = $this->server_data['server_id'];
        $this->secret_key = $this->edit_data['edit_secret_key'];
        return true;
    }

    /**
     * @param $address
     * @param string $icq
     * @param string $site
     * @param string $about
     * @param string $game
     * @param string $mode
     * @return bool
     */
    public function SaveChanges($address, $icq = '', $site = '', $about = '', $game = '', $mode = '')
    {
        if (!is_array($this->server_data) or !is_array($this->edit_data)) return false;
        $regex_ipport = "[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\:[0-9]{1,5}";
        $regex_hostport = "[a-zA-Z0-9](-*[a-zA-Z0-9]+)*(\.[a-zA-Z0-9](-*[a-zA-Z0-9]+)*)+\:[0-9]{1,5}";
        if (!preg_match("/$regex_ipport/", $address) and !preg_match("/$regex_hostport/i", $address)) {
            $this->save_errors[] = "Неправильный формат адреса сервера.";
            return false;
        }
        if (!is_numeric($icq) or (is_numeric($icq) and strlen($icq) > 9) or (is_numeric($icq) and strlen($icq) < 4)) {
            $this->save_errors[] = "Некорректный ICQ.";
            return false;
        }
        if (!isValidURL($site)) {
            $this->save_errors[] = "Некорректный адрес сайта.";
            return false;
        }
        $address = db()->escape_value($address);
        $game = db()->escape_value($game);
        $mode = db()->escape_value($mode);
        $site = db()->escape_value($site);
        $about = db()->escape_value($about);
        $update_server_data = db()->query("UPDATE `" . DB_SERVERS . "` SET `server_ip` = '{$address}', `server_site` = '{$site}', `server_icq` = '{$icq}', `server_game` = '{$game}', `server_mode` = '{$mode}', `about` = '{$about}' WHERE `server_id` = '{$this->server_data['server_id']}'");
        if (!$update_server_data) {
            $this->save_errors[] = "Ошибка сохранения данных о сервере.";
            return false;
        }
        $edit_data = $this->server_data['server_ip'];
        $edit_data_new = $address;
        $update_edit_data = db()->query("UPDATE `" . DB_SERVERS_EDITS . "` SET `edit_date` = '" . time() . "', `edit_ip` = '" . $_SERVER['REMOTE_ADDR'] . "', `edit_data` = '{$edit_data}', `edit_data_new` = '{$edit_data_new}' WHERE `edit_id` = '{$this->edit_data['edit_id']}'");
        if (!$update_edit_data) $this->save_errors[] = "Ошибка сохранения данных.";
        return true;
    }
}
