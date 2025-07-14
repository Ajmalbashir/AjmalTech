<?php
include('../smtp/PHPMailerAutoload.php');

// Get form values safely
$name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
$email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
$subject = isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : '';
$message = isset($_POST['message']) ? nl2br(htmlspecialchars($_POST['message'])) : '';

// Email body
$body = "
    <h3>New Contact Form Submission</h3>
    <p><strong>Name:</strong> $name</p>
    <p><strong>Email:</strong> $email</p>
    <p><strong>Subject:</strong> $subject</p>
    <p><strong>Message:</strong><br>$message</p>
";

// Call the function and pass name/email too
echo smtp_mailer('muhammadajmalbashir44@gmail.com', $subject, $body, $email, $name);

// Modified function
function smtp_mailer($to, $subject, $msg, $replyEmail = null, $replyName = null){
    $mail = new PHPMailer(); 
    $mail->IsSMTP(); 
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = 'tls'; 
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587; 
    $mail->IsHTML(true);
    $mail->CharSet = 'UTF-8';

    $mail->Username = "muhammadajmalbashir44@gmail.com";
    $mail->Password = "ykgj kfyp qrau kbwj";
    $mail->SetFrom("muhammadajmalbashir44@gmail.com", "Portfolio Contact Form");

    $mail->Subject = $subject;
    $mail->Body = $msg;
    $mail->AddAddress($to);

    // Only set reply-to if values are not empty
    if (!empty($replyEmail) && !empty($replyName)) {
        $mail->AddReplyTo($replyEmail, $replyName);
    }

    $mail->SMTPOptions = array('ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => false
    ));

    if(!$mail->Send()){
        return "Mailer Error: " . $mail->ErrorInfo;
    } else {
        return "OK";
    }
}
?>
