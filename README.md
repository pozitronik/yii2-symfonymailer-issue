# yii2-symfonymailer-issue

Example for the [issue](https://github.com/yiisoft/yii2-symfonymailer/issues/35).

# installation

`git clone && composer install`

# Issue demonstration

Run test
 
`php vendor/bin/codecept run tests/unit/MailerQueueSymphonyTest.php`

It will fail with message

`Cannot serialize Symfony\Component\Mailer\Transport\Smtp\SmtpTransport`

The test code is here: `tests/unit/MailerQueueSymphonyTest.php`

Although, there is a same test with deprecated SwiftMailer:

`php vendor/bin/codecept run tests/unit/MailerQueueSwiftTest.php`

it works just fine.