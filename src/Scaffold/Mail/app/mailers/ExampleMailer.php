<?php

namespace App\Mailers;

use Leaf\Mail;

/*
|--------------------------------------------------------------------------
| ExampleMailer
|--------------------------------------------------------------------------
|
| This file is just to give you an overview on working with
| Leaf Mail. You can delete it if you want.
|
| Mailers have methods called "actions" which are responsible
| for handling a specific type of email. For instance, the
| `UserMailer` may have a `welcome` action for sending welcome emails.
|
| You can use these actions like this:
| ```php
| ExampleMailer::welcome($user)->send();
| ```
|
*/

class ExampleMailer
{
    public static function example($user)
    {
        return new Mail([
            'subject' => 'Leaf Mail Test',
            'body' => 'This is a test mail from Leaf Mail',
            'recipientEmail' => 'name@example.com',
            'recipientName' => 'First Last',

            // these have been set as defaults in .env file
            // you can override them here, otherwise, just remove them
            'senderName' => 'Leaf Mail',
            'senderEmail' => 'name@example.com',
        ]);
    }

    public static function exampleWithTemplate($user)
    {
        return new Mail([
            'subject' => 'Leaf Mail Test',
            // just add the view() function to your body.
            // It will be rendered immediately as html
            'body' => view('mails.example', $user),
            'recipientEmail' => 'name@example.com',
            'recipientName' => 'First Last',

            // next couple of lines can be skipped if you
            // set defaults in the config/mail.php file
            'senderName' => 'Leaf Mail',
            'senderEmail' => 'name@example.com',
        ]);
    }

    public static function exampleWithAttachments($user)
    {
        $mail = new Mail([
            'subject' => 'Leaf Mail Test',
            'body' => 'This is a test mail from Leaf Mail',
            'recipientEmail' => 'name@example.com',
            'recipientName' => 'First Last',

            // next couple of lines can be skipped if you
            // set defaults in the config/mail.php file
            'senderName' => 'Leaf Mail',
            'senderEmail' => 'name@example.com',
        ]);

        $mail->attach('path/to/file');

        return $mail;
    }
}
