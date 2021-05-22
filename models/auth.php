<?php  
	class Auth {
		protected $pdo; 

		public function __construct(\PDO $pdo) {
			$this->pdo = $pdo;
		}

		public function encrypt_password($pword) {
			$hashFormat="$2y$10$";
			$saltLength=22;
			$salt=$this->generate_salt($saltLength);
			return crypt($pword, $hashFormat.$salt);
		}

		protected function generate_salt($len) {
			$urs=md5(uniqid(mt_rand(), true));
			$b64String = base64_encode($urs);
			$mb64String = str_replace('+', '.', $b64String);
			return substr($mb64String, 0, $len);
		}

		public function pword_check($pword, $existingHash) {
			$hash=crypt($pword, $existingHash);
			// print("last:".$hash);
			if($hash===$existingHash) {
				return true;
			} 
			return false;
		}


		public function register($d){
			$hashFormat="$2y$10$";
			$saltLength=22;
			$salt=$this->generate_salt($saltLength);
			$newpass = crypt($d->user_password, $hashFormat.$salt);
			

			$sql = "SELECT * FROM user WHERE user_email='$d->user_email' OR user_name='$d->user_name' LIMIT 1";
			if($result = $this->pdo->query($sql)->fetchAll()) {
			 return false;
		 } else {

			 $sql = "INSERT INTO user (user_name, user_email, user_password) VALUES (?,?,?)";
			 $sql = $this->pdo->prepare($sql);
			 $sql->execute([
                $d-> user_name,
                $d-> user_email,
                $newpass
			 ]);
			 return true;
		 }
		}

		public function login($param) {
			$un = $param->param1;
			$pw = $param->param2;

			$sql = "SELECT * FROM user WHERE user_name='$un' LIMIT 1";
			if($res = $this->pdo->query($sql)->fetchAll()) {
				if($this->pword_check($pw, $res[0]['user_password'])) {
                    // print($res[0]['user_password']);
					return array("data"=>array("user_id"=>$res[0]['user_id'], "user_name"=>$res[0]['user_name'], "user_email"=>$res[0]['user_email']));
				} else {
					return array("error"=>"Incorrect username or passwords");
				}
			} else {
				return array("error"=>"Incorrect username or password");
			}
        }

	}
?>