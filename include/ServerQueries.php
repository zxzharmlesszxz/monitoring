<?php

/**
 * Class ServerQueries
 */
abstract class ServerQueries
{
    /**
     * @var bool
     */
    protected $resource;
    /**
     * @var string
     */
    protected $raw;
    /**
     * @var bool
     */
    protected $connected;
    /**
     * @var
     */
    protected $ip;
    /**
     * @var
     */
    protected $port;

    /**
     * ServerQueries constructor.
     */
    function __construct()
    {
        $this->resource = false;
        $this->connected = false;
        $this->raw = "";
    }

    /**
     *
     */
    function __destrcut()
    {
        self::disconnect();
    }

    /**
     * @param $address
     * @param $port
     * @return bool
     */
    public function connect($address, $port)
    {
        self::disconnect();
        $this->port = (int)$port;
        $this->ip = @gethostbyname($address);
        if ($this->resource = @fsockopen('udp://' . $this->ip, $this->port, $errno, $errstr, 1)) {
            $this->connected = true;
            stream_set_timeout($this->resource, 1);
        }
        return $this->connected;
    }

    /**
     *
     */
    public function disconnect()
    {
        if ($this->connected) {
            if (is_resource($this->resource))
                fclose($this->resource);
            $this->connected = false;
        }
    }

    /**
     * @param $data
     */
    protected function send($data)
    {
        fwrite($this->resource, $data);
    }

    /**
     * @param bool $many_packets
     * @return bool
     */
    protected function read($many_packets = false)
    {
        if ($many_packets)
            $this->raw = stream_get_contents($this->resource);
        else
            $this->raw = fread($this->resource, 2048);
        return true;
    }

    /**
     * @return int
     */
    protected function getByte()
    {
        $return = @ord($this->raw[0]);
        $this->raw = substr($this->raw, 1);
        return $return;
    }

    /**
     * @return mixed
     */
    protected function getShort()
    {
        $return = @unpack('sint', $this->raw);
        $this->raw = substr($this->raw, 2);
        return $return['int'];
    }

    /**
     * @return mixed
     */
    protected function getLong()
    {
        $return = @unpack('iint', $this->raw);
        $this->raw = substr($this->raw, 4);
        return $return['int'];
    }

    /**
     * @return mixed
     */
    protected function getFloat()
    {
        $return = @unpack('fint', $this->raw);
        $this->raw = substr($this->raw, 4);
        return $return['int'];
    }

    /**
     * @return string
     */
    protected function getString()
    {
        $str = "";
        $i = 0;
        while (isset($this->raw[$i]) && ($this->raw[$i] != "\0")) {
            $str .= $this->raw[$i];
            $i++;
        }
        $this->raw = substr($this->raw, strlen($str) + 1);
        return $str;
    }
}
