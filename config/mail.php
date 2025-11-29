<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once dirname(__DIR__) . "/vendor/autoload.php";

function sendEmail(
    string $subject,
    string $bodyHtml,
    string $bodyPlain = "",
): bool {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = getenv("SMTP_HOST");
        $mail->SMTPAuth = true;
        $mail->Username = getenv("SMTP_USER");
        $mail->Password = getenv("SMTP_PASS");
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = intval(getenv("SMTP_PORT"));
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = "error_log";

        $mail->setFrom(getenv("MAIL_FROM"), getenv("MAIL_FROM_NAME"));
        $mail->addAddress(getenv("MAIL_TO"), getenv("MAIL_TO_NAME"));

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $bodyHtml;
        $mail->AltBody = $bodyPlain !== "" ? $bodyPlain : strip_tags($bodyHtml);

        return $mail->send();
    } catch (Exception $e) {
        return false;
    }
}
