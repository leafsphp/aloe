<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SMTP Host Address
    |--------------------------------------------------------------------------
    |
    | This is the host address of the SMTP server you want to connect to.
    |
    */
    'host' => _env('MAIL_HOST', 'smtp.mailtrap.io'),

    /*
    |--------------------------------------------------------------------------
    | SMTP Host Port
    |--------------------------------------------------------------------------
    |
    | Here you may specify the port used for your application.
    |
    */
    'port' => _env('MAIL_PORT', 2525),

    /*
    |--------------------------------------------------------------------------
    | Keep Alive
    |--------------------------------------------------------------------------
    |
    | This config is used to keep the connection to your mail server alive.
    | This is useful if you are sending multiple emails. It takes in a boolean.
    |
    */
    'keepAlive' => true,

    /*
    |--------------------------------------------------------------------------
    | Debug mode
    |--------------------------------------------------------------------------
    |
    | When this option is enabled, the mailer will log all the communication
    | with the SMTP server. This can come in handy when you're trying to
    | debug an application.
    |
    */
    'debug' => _env('MAIL_DEBUG', 'SERVER'),

    /*
    |--------------------------------------------------------------------------
    | Mail encryption
    |--------------------------------------------------------------------------
    |
    | Here you may specify the encryption protocol that should be used when
    | the application send mail messages. A sensible default using the
    | transport layer security protocol should provide great security.
    |
    */
    'security' => _env('MAIL_ENCRYPTION', 'STARTTLS'),

    /*
    |--------------------------------------------------------------------------
    | Server Auth
    |--------------------------------------------------------------------------
    |
    | This config handles the authentication details for your mailer.
    | It supports authentication with username and password and also
    | OAuth authentication.
    |
    | For OAuth authentication, you will need to add an OAuth
    | provider like league/oauth2-google to your project.
    |
    | An example OAuth config is shown below:
    |
    | use League\OAuth2\Client\Provider\Google;
    | use PHPMailer\PHPMailer\OAuth;
    |
    | 'auth' => new OAuth(
    |   [
    |     'userName' => 'mail@gmail.com',
    |     'clientSecret' => 'CLIENT_SECRET',
    |     'clientId' => 'CLIENT_ID',
    |     'refreshToken' => 'GMAIL_REFRESH_TOKEN',
    |     'provider' => new Google(
    |       [
    |         'clientId' => 'CLIENT_ID',
    |         'clientSecret' => 'CLIENT_SECRET',
    |       ]
    |    ),
    |  ]
    |)
    */
    'auth' => [
        'username' => _env('MAIL_USERNAME'),
        'password' => _env('MAIL_PASSWORD'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Default addresses
    |--------------------------------------------------------------------------
    |
    | This config is used to set default values for the
    | `recipientEmail`, `recipientName`,
    | `senderEmail`, `senderName`,
    | `replyToName`, and `replyToEmail` of your emails.
    |
    */
    'defaults' => [
        'senderName' => _env('MAIL_SENDER_NAME'),
        'senderEmail' => _env('MAIL_SENDER_EMAIL'),
        'replyToName' => _env('MAIL_REPLY_TO_NAME'),
        'replyToEmail' => _env('MAIL_REPLY_TO_EMAIL'),
    ],
];
