<?php

namespace JimmyPhimmasone\Repository;

use Silex\Application;

class ContactRepository
{
	protected $mailer;
	protected $email;

	public function __construct(Application $app)
	{
		$this->mailer = $app['mailer'];
		$this->email = $app['email'];
	}

	public function getMailer()
	{
		return $this->mailer;
	}

	/**
	 * Send mail
	 *
	 * @param string $from sender(s)
	 * @param string $subject
	 * @param string $content
	 *
	 */
    public function sendEmail($from, $subject, $content)
    {
    	$message = \Swift_Message::newInstance()
	        ->setSubject($subject)
	        ->setFrom(array($from))
	        ->setTo(array($this->email))
	        ->setBody($content)
		;

    	return $this->getMailer()->send($message);
    }
}