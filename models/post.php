<?php 
    class Post {
        protected $pdo; 

        public function __construct(\PDO $pdo) {
            $this->pdo = $pdo;
        }
        public function place_order($d) {
            $data = [];
            // print_r($d);

            $sql = "INSERT into orders(customer_name,customer_email,customer_address,customer_number,food_name,qty,subtotal) VALUES (?,?,?,?,?,?,?)";

            $sql = $this->pdo->prepare($sql);
			 $sql->execute([
				 $d->customer_name, 
				 $d->customer_email,
                 $d->customer_address,
                 $d->customer_number,
                 $d->food_name,
                 $d->qty,
                 $d->subtotal
			 ]);
			 return array("msg"=>"Successfully Added new order");
        }
    }