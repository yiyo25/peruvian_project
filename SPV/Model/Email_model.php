<?php
class Email{
	public function __construct(){
		require_once("mail/htmlMimeMail5.php");
        $this->correoRemitente = $_SESSION["objUsu"]["Correo"];;
		//Logica de inicializacion del login_model
		//Hacer la conexion con la base de datos
		//tengo la instancia pdo en la propiedad
		//database
		//parent::__construct();
	}
	//Reglas de negocios
	public function Enviar($Title,$content,$arrayDestino,$bcc=NULL,$param1,$param2,$formulario){
		$mail = new htmlMimeMail5();
		$mail->setFrom('Sist Prog de Vuelo - <'.$this->correoRemitente.'>');
		$mail->setSMTPParams('mail01.peruvian.pe', 25, 'mail01.peruvian.pe', false, 'alertas.web@peruvian.pe', 'peruvian2825x');
		$mail->setSubject($Title);
		$mail->setPriority('high');
		$mail->setHTML($content);
        if($formulario == 'itinerario'){
            $mail->addAttachment(new FileAttachment(URLRUTAITINERARIO.'itinerario_'.$param1.'_'.$param2.'.xlsx'));
        }
        if($formulario == 'simulador'){
            $mail->addAttachment(new FileAttachment(URLRUTASIMULADOR.'simulador'.$param1.'_'.$param2.'.xlsx'));
        }
		if($bcc)
			$mail->setBcc($bcc);
		$mail->send($arrayDestino,'smtp');
	}
}
?>