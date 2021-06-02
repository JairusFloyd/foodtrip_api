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
			if($hash=$existingHash) {
				return true;
			} 
			return false;
		}

		
		public function register($d){
			// print_r($d);
			$hashFormat="$2y$10$";
			$saltLength=22;
			$salt=$this->generate_salt($saltLength);
			$newpass = crypt($d->pass, $hashFormat.$salt);
			

			$sql = "SELECT * FROM users WHERE user_name='$d->username' OR email='$d->email' LIMIT 1";
			if($result = $this->pdo->query($sql)->fetchAll()) {

			 return array("result"=>"0");
			 return false;
		 } else {

			$sql = "INSERT INTO users (user_fullname,user_name,email,password) VALUES (?,?,?,?)";
			$sql = $this->pdo->prepare($sql);
			$sql->execute([
				$d->fullname,
				$d->username,
				$d->email,  
				$newpass
				
			 ]);
			 return array("result"=>"1");
			 return true;
		 }
		}

		public function login($param) {
			$data = [];
			$un = $param->param1;
			$pw = $param->param2;

			$sql = "SELECT * FROM users WHERE user_name='$un' LIMIT 1";
			if($res = $this->pdo->query($sql)->fetchAll()) {
				if($this->pword_check($pw, $res[0]['password'])) {
                    foreach ($res as $record) {
						array_push($data, $record);
					}
					return array("data"=>$data);
				} else {
					return array("error"=>"Incorrect username or passwords");
				}
			} else {
				return array("error"=>"Incorrect username or password");
			}
        }

	}
?>