<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  require "vendor/autoload.php";

  function sendEmail($stuid, $stuemail, $stuname, $verification_code) {
    $mail = new PHPMailer(true);

    $stuemail = $stuemail;
    $stuname = $stuname;
  
    try {
      //Server settings
      $mail->isSMTP();                               
      $mail->Host       = 'smtp.gmail.com';               
      $mail->SMTPAuth   = true;                             
      $mail->Username   = 'studentms.mailer@gmail.com';          
      $mail->Password   = 'kclhrpesvbyxglpy'; 
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   
      $mail->Port       = 587;                          
  
      //Recipients
      $mail->setFrom('studentms.mailer@gmail.com', 'Studentms Mailer');
      $mail->addAddress($stuemail, $stuname);
  
      $url = "http://localhost/studentms/verify.php?stuid=$stuid&code=$verification_code";
  
      // Content
      $mail->isHTML(true);                              
      $mail->Subject = 'Verify Your Account';
      $mail->Body    = '
        <p>Hello '.$stuname.'</p>
        <p>Please verify your email in order to login.</p>
        <a href="'.$url.'">Verify Account</a>
      ';
      $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
  
      // Send the email
      $mail -> send();
      
      // header("location: index.php?r=true");
      echo "Verification send.";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
  }


  
?>