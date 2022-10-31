<?php

namespace App\Http\Traits;

use App\Models\MailContents;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

trait MailerTrait
{
    use LoggerTrait;

    public function sendMail($mailKey, $email, $mailData)
    {
        ini_set('memory_limit', '1024M');
        //MailTrap
        // $mail->isSMTP();
        // $mail->Host = 'smtp.mailtrap.io';
        // $mail->SMTPAuth = true;
        // $mail->Port = 2525;
        // $mail->Username = '477673d92aff91';
        // $mail->Password = '9a37318df454a7';

        $mailContents = MailContents::where('mail_key', $mailKey)->first();
        //Gmail
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Mailer = "smtp";
        // $mail->Mailer = env('MAIL_MAILER');
        $mail->Host = "smtp.gmail.com";
        // $mail->Host = env('MAIL_HOST');
        // dd(env('MAIL_HOST'));
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ttl";
        // $mail->SMTPSecure = env('MAIL_SECURE');
        // $mail->Username = env('MAIL_USERNAME');
        // dd(config("MAIL_USERNAME"));
        $mail->Username = "krisztianszabodev@gmail.com";
        $mail->Password = "zcqiausrkiplfaau";
        $mail->Port = "587";

        $mail->setFrom($mailContents['sender'], 'Szabó szeszfőzde');
        // dd($mailData['email']);
        $mail->addAddress($email);
        // $mail->addCC($request->emailCc);
        // $mail->addBCC($request->emailBcc);
        // $mail->addReplyTo('sender@example.com', 'SenderReplyName');
        // if(isset($_FILES['emailAttachments'])) {
        //     for ($i=0; $i < count($_FILES['emailAttachments']['tmp_name']); $i++) {
        //         $mail->addAttachment($_FILES['emailAttachments']['tmp_name'][$i], $_FILES['emailAttachments']['name'][$i]);
        //     }
        // }
        $mail->isHTML(true);
        $mail->Subject = $mailContents['subject'];
        // dd($mail->Subject);
        $mail->Body = $this->formatedBody($mailContents->content, $mailData);
        $content = "Email:" .
            "\nKi: " . $mailContents['sender'] .
            "\nKinek: " . $mailData['email'] .
            "\nEmail sablon kulcs: " . $mailKey .
            "\nFejléc: " . $mailContents['subject'] .
            "\nTárgy: " . $mail->Body;
        $this->logger(1, $content);
        // dd($mail);
        // dd($mailData);
        $mail->send();
    }

    function formatedBody($mailContent, $mailData)
    {
        // $mailContents = MailContents::where('mail_key', $mailKey)->first();
        foreach ($mailData as $key => $value) {
            $key = '##' . $key . '##';
            $mailContent = str_replace($key, $value, $mailContent);
        }
        return $mailContent;
    }
}
