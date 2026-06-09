<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'phpmailer/src/Exception.php';
	require 'phpmailer/src/PHPMailer.php';

	$mail = new PHPMailer(true);
	$mail->CharSet = 'UTF-8';
	$mail->setLanguage('ru', 'phpmailer/language/');
	$mail->IsHTML(true);

	//От кого письмо
	$mail->setFrom('bogdanpikul@gmail.com', 'Geon River');
	//Кому отправить
	$mail->addAddress('bogdanpikul@gmail.com');
	//Тема письма
	$mail->Subject = 'Cooperation offer from Website"';

	//Рука
	/*
	$hand = "Правая";
	if($_POST['hand'] == "left"){
		$hand = "Левая";
	}
	*/

	$proposal = "Timber";
if($_POST['proposal'] == "pallet") {
        $proposal = "Pallet";
    } elseif($_POST['proposal'] == "pellet"){
        $proposal = "Pellet";
    } elseif($_POST['proposal'] == "ruf"){
        $proposal = "Ruf";
    } 




	//Тело письма
	$body = '<h1>Cooperation offer - Geon River Website</h1>';
	
	if(trim(!empty($_POST['name']))){
		$body.='<p><strong>Name:</strong> '.$_POST['name'].'</p>';
	}
	if(trim(!empty($_POST['email']))){
		$body.='<p><strong>E-mail:</strong> '.$_POST['email'].'</p>';
	}
	if(trim(!empty($_POST['proposal']))){
		$body.='<p><strong>Subject:</strong> '.$proposal.'</p>';
	}
	if(trim(!empty($_POST['country']))){
		$body.='<p><strong>Country:</strong> '.$_POST['country'].'</p>';
	}
	
	if(trim(!empty($_POST['message']))){
		$body.='<p><strong>Message:</strong> '.$_POST['message'].'</p>';
	}
	
	//Прикрепить файл
	if (!empty($_FILES['image']['tmp_name'])) {
		//путь загрузки файла
		$filePath = __DIR__ . "/files/" . $_FILES['image']['name']; 
		//грузим файл
		if (copy($_FILES['image']['tmp_name'], $filePath)){
			$fileAttach = $filePath;
			$body.='<p><strong>Photo in the application</strong>';
			$mail->addAttachment($fileAttach);
		}
	}

	$mail->Body = $body;

	//Отправляем
	if (!$mail->send()) {
		$message = 'Error!';
	} else {
		$message = 'The message has been sent!';
	}

	$response = ['message' => $message];

	header('Content-type: application/json');
	echo json_encode($response);
?>