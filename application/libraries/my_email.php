<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class My_Email {

	private $phpmailer;

	public function __construct(){
		
		require_once('PHPMailerAutoload.php');

		$this->phpmailer = new PHPMailer();

		return $this;
	}

	public function sendEmail($infos = array()){

		$this->phpmailer->Charset = 'UTF-8';
		$this->phpmailer->isSMTP();
		$this->phpmailer->Host = EMAIL_HOST;
		$this->phpmailer->SMTPAuth = EMAIL_AUTH;
		$this->phpmailer->Username = EMAIL_USERNAME;
		$this->phpmailer->Password = EMAIL_PASSWORD;
		$this->phpmailer->Port = EMAIL_PORT;
		$this->phpmailer->SMTPSecure = EMAIL_SECURE;

		$this->phpmailer->From = EMAIL_USERNAME;
		$this->phpmailer->FromName = $infos['fromName'];
		$this->phpmailer->addAddress($infos['to'], $infos['toName']);
		
		$this->phpmailer->isHTML(EMAIL_HTML);

		$this->phpmailer->Subject = $infos['subject'];
		$this->phpmailer->Body = $infos['body'];		

		$check = $this->phpmailer->send();

		if($check){
			return true;
		}else{
			return $this->phpmailer->ErrorInfo;
		}
	}
}
?>