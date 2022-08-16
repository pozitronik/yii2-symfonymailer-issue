<?php
declare(strict_types = 1);

use Codeception\Test\Unit;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\symfonymailer\Message;

/**
 * Class MailerQueueSymphonyTest
 */
class MailerQueueSymphonyTest extends Unit {
	/**
	 * Проверка очереди с SymphonyMailer
	 * @return void
	 * @throws Exception
	 * @throws InvalidConfigException
	 * @throws Throwable
	 */
	public function testMailerQueueSymphony():void {
		Yii::$app->set('queue_email', [
			'class' => yii\queue\file\Queue::class,
			'path' => '@runtime/queues/email',
			'ttr' => 3600
		]);
		Yii::$app->set('mailer', [
			'class' => YarCode\Yii2\QueueMailer\Mailer::class,
			'queue' => 'queue_email',
			'syncMailer' => [
				'class' => yii\symfonymailer\Mailer::class,
				'transport' => [
					'scheme' => 'smtp',
					'host' => 'localhost',
					'port' => 25
				],
			],
		]);

		$message = Yii::$app->mailer->compose()
			->setSubject('test email')
			->setFrom('test@email.local')
			->setTextBody(Yii::$app->security->generateRandomString())
			->setTo('test@queueemail.local');
		$this::assertTrue(Yii::$app->mailer->send($message));

		/* not required for demo
		 * (new YarCode\Yii2\QueueMailer\Jobs\SendMessageJob([
			'mailer' => Yii::$app->mailer,
			'message' => $message
		]))->execute(Yii::$app->queue_email);*/

	}

	/**
	 * @return void
	 * @throws Exception
	 * @throws InvalidConfigException
	 */
	public function testMailerQueueSymphonyUnsetTransportObject():void {
		Yii::$app->set('queue_email', [
			'class' => yii\queue\file\Queue::class,
			'path' => '@runtime/queues/email',
			'ttr' => 3600
		]);
		Yii::$app->set('mailer', [
			'class' => YarCode\Yii2\QueueMailer\Mailer::class,
			'queue' => 'queue_email',
			'syncMailer' => [
				'class' => yii\symfonymailer\Mailer::class,
				'transport' => [
					'scheme' => 'smtp',
					'host' => 'localhost',
					'port' => 25
				],
			],
		]);

		/** @var Message $message */
		$message = Yii::$app->mailer->compose()
			->setSubject('test email')
			->setFrom('test@email.local')
			->setTextBody(Yii::$app->security->generateRandomString())
			->setTo('test@queueemail.local');
		unset($message->mailer);
		$this::assertTrue(Yii::$app->mailer->send($message));

	}
}