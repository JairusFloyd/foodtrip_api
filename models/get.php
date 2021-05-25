<?php 
    class Get {
        protected $pdo; 

        public function __construct(\PDO $pdo) {
            $this->pdo = $pdo;
        }
        public function get_dish($d) {
            $data = [];

            $sql = "SELECT * FROM food WHERE food_category = '$d->food_category'";

            if($result = $this->pdo->query($sql)->fetchAll()) {
                foreach ($result as $record) {
                    array_push($data, $record);
                }
                return array("data"=>$data);
            } else {
                return array("error"=>"ERROR: No record found");
            }
        }

        public function placed_orders($d) {
            $data = [];

            $sql = "SELECT * FROM orders WHERE customer_email = '$d->customer_email' AND is_checked_out = 0";

            if($result = $this->pdo->query($sql)->fetchAll()) {
                foreach ($result as $record) {
                    array_push($data, $record);
                }
                return array("data"=>$data);
            } else {
                return array("error"=>"ERROR: No record found");
            }
        }

        public function checked_out($d) {
            $data = [];

            $sql = "SELECT * FROM orders WHERE customer_email = '$d->customer_email' AND is_checked_out = 1";

            if($result = $this->pdo->query($sql)->fetchAll()) {
                foreach ($result as $record) {
                    array_push($data, $record);
                }
                return array("data"=>$data);
            } else {
                return array("error"=>"ERROR: No record found");
            }
        }

    }