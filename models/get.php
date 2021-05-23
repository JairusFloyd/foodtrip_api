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
    }