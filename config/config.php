<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=utf-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    date_default_timezone_set("Asia/Manila");
    set_time_limit(1000);

    define("SERVER", "localhost");
    define("USER", "root");
    define("PW", "");
    define("DBASE", "foodtrip");
    define("CHARSET", "utf8");

    class Connection {
        protected $constring = "mysql:host=".SERVER.";dbname=".DBASE.";charset=".CHARSET;

        protected $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false
        ];

        public function connect() {
            return new \PDO($this->constring, USER, PW, $this->options);
        }
    }
?>