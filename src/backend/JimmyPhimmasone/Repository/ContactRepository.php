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
	 * @param string $name
	 * @param string $subject
	 * @param string $content
	 */
    public function sendEmail($from, $name, $subject, $content)
    {
    	$body = "Email : ".$from."\r\n\r\n".$content;

    	$message = \Swift_Message::newInstance()
	        ->setSubject($subject)
	        ->setFrom(array($this->email => $name))
	        ->setTo(array($this->email))
	        ->setBody($body)
		;

    	return $this->getMailer()->send($message);
    }
}