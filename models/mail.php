<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
   //Load Composer's autoloader
   require 'vendor/autoload.php';

class Mailer{
		protected $pdo; 

		public function __construct(\PDO $pdo) {
			$this->pdo = $pdo;
		}
            
    
        public function mailer($d){
            //Instantiation and passing `true` enables exceptions
           print_r($d);
            $receiver = $d->email;
            $subj = $d->subj;
            $content = $d->body;
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'foodtrip999111@gmail.com';                     //SMTP username
                $mail->Password   = 'akoito00';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom('foodtrip999111@gmail.com', 'FoodTrip');
                $mail->addAddress($receiver);     //Add a recipient
                //$mail->addAddress('ellen@example.com');               //Name is optional
                $mail->addReplyTo('foodtrip999111@gmail.com', 'FoodTrip');
                //$mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');

                //Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = $subj ;
                $mail->Body    = $content;
                $mail->AltBody =  $content;

                $mail->send();
                return array("Message has been sent");
            } catch (Exception $e) {
                return array("error"=>"Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            }
        }
    }
        ?>