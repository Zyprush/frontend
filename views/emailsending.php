<?php
require '../assets/plugins/PHPMailer/src/PHPMailer.php';
require '../assets/plugins/PHPMailer/src/SMTP.php';
require '../assets/plugins/PHPMailer/src/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// require 'vendor/autoload.php';
//========================================================
header('Content-Type: application/json');
echo 'here';
$aResult = array();

if( !isset($_POST['functionname']) ) { $aResult['error'] = 'No function name!'; }

if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No function arguments!'; }

if( !isset($aResult['error']) ) {

    switch($_POST['functionname']) {
        case 'sendEmail':
          sendEmail($_POST['arguments'][0], $_POST['arguments'][1], $_POST['arguments'][2]);
          break;

        default:
           $aResult['error'] = 'Not found function '.$_POST['functionname'].'!';
           break;
    }

}

echo json_encode($aResult);

//========================================================



function sendEmail($toEmail,$message,$subject){
  $mail = new PHPMailer(true);

  try {
      // $mail->SMTPDebug = 2;
      $mail->isSMTP();
      $mail->SMTPOptions = array(
      'ssl' => array(
          'verify_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => false
      )
  );
      $mail->Host       = 'smtp.gmail.com';
      $mail->SMTPAuth   = true;
      $mail->Username   = 'dict.certgen@gmail.com';
      $mail->Password   = 'hevcxnafzaknuhgl';
      $mail->SMTPSecure = 'tls';
      $mail->Port       = 587;

      $mail->From = "dict.certgen@gmail.com";
      $mail->FromName = "DICT CertGen";
      $mail->addAddress($toEmail);


      $mail->isHTML(true);
      $mail->Subject = $subject;
      $mail->Body    = $message;
      $mail->AltBody = 'Body in plain text for non-HTML mail clients';
      if (isset($_POST['attachment'])){
        $mail->AddStringAttachment(base64_decode($_POST['attachment'][0]), $_POST['attachment'][1]);
      }



      $mail->send();
      echo "Mail has been sent successfully!";
  } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}

?>
