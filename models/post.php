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
            $payment = 'COD';

            $sql = "INSERT into orders(user_fullname,user_email	,address,phone,food_name,qty,subtotal,status, payment) VALUES (?,?,?,?,?,?,?,?,?)";

            $sql = $this->pdo->prepare($sql);
			 $sql->execute([
				 $d->customer_name, 
				 $d->customer_email,
                 $d->customer_address,
                 $d->customer_number,
                 $d->food_name,
                 $d->qty,
                 $d->subtotal,
                 $status,
                 $payment
			 ]);
			 return array("msg"=>"Successfully Added new order");
        }

        public function check_out($d) {
            // print_r($d);
			$sql = "UPDATE orders SET user_id=$d->user_id,user_email='$d->user_email',is_check_out = 1, phone='$d->customer_number',address='$d->customer_address',delivery_date='$d->date' WHERE id = $d->order_id";
			$sql = $this->pdo->prepare($sql);
			$sql->execute([]);
			return array("msg"=>"Successfully Checked out");
		}

        public function cancel($d) {

			$sql = "UPDATE orders SET status = 'Cancelled' WHERE id = $d->order_id";
			$sql = $this->pdo->prepare($sql);
			$sql->execute([]);
			return array("msg"=>"Successfully cancelled");
		}
    }