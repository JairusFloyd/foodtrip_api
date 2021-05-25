<?php 
    class Post {
        protected $pdo; 

        public function __construct(\PDO $pdo) {
            $this->pdo = $pdo;
        }
        public function place_order($d) {
            $data = [];
            // print_r($d);
            $status = 'Pending';

            $sql = "INSERT into orders(customer_name,customer_email,customer_address,customer_number,food_name,qty,subtotal,status) VALUES (?,?,?,?,?,?,?,?)";

            $sql = $this->pdo->prepare($sql);
			 $sql->execute([
				 $d->customer_name, 
				 $d->customer_email,
                 $d->customer_address,
                 $d->customer_number,
                 $d->food_name,
                 $d->qty,
                 $d->subtotal,
                 $status
			 ]);
			 return array("msg"=>"Successfully Added new order");
        }

        public function check_out($d) {
            
			$sql = "UPDATE orders SET is_checked_out = 1, customer_number='$d->customer_number',customer_address='$d->customer_address' WHERE order_id = $d->order_id";
			$sql = $this->pdo->prepare($sql);
			$sql->execute([]);
			return array("msg"=>"Successfully Checked out");
		}

        public function cancel($d) {

			$sql = "UPDATE orders SET status = 'Cancelled' WHERE order_id = $d->order_id";
			$sql = $this->pdo->prepare($sql);
			$sql->execute([]);
			return array("msg"=>"Successfully cancelled");
		}
    }