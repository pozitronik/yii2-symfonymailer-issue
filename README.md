# yii2-symfonymailer-issue

Example for the [issue](https://github.com/yiisoft/yii2-symfonymailer/issues/35).

### What steps will reproduce the problem?
 
Trying to use yii2-symfonymailer in queue job.
### What's expected?

Everything is working.
### What do you get instead?
 
`BadMethodCallException : Cannot serialize Symfony\Component\Mailer\Transport\Smtp\SmtpTransport` at ` \vendor\symfony\mailer\Transport\Smtp\SmtpTransport.php:356`
### Additional info
 
At the current moment this extension can't be used in queue jobs (with https://github.com/yarcode/yii2-queue-mailer as example), because that jobs are serialized, but initialized Transport object prevents serialization. Deprecated yii2-swiftmailer extension has no such problem. The reason is that, the Transport object is initializing [directly in setter](https://github.com/yiisoft/yii2-symfonymailer/blob/1a64cf981796866bcc7124e67ab8a1ef3ca1190a/src/Mailer.php#L80), if it passed as array configuration. It seems, that this behavior can be changed easily. This require just to remove Transport object initialization from `setTransport()` (it all be done in `getTransport()` anyway). I prepared pull request, that demonstrates my idea, and this code perfectly works within queues. I did not remove the Transport initialization code from setter, in order to not to break current tests, but added a class variable to control the described behavior.

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
