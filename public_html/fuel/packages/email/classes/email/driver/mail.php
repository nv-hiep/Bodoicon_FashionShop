<?php
/**
 * Fuel
 *
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2015 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Email;

class Email_Driver_Mail extends \Email_Driver
{
	/**
	 * Send the email using php's mail function.
	 *
	 * @throws \EmailSendingFailedException Failed sending email
	 *
	 * @return  bool    success boolean.
	 */
	protected function _send()
	{
		$message = $this->build_message();
		$return_path = ($this->config['return_path'] !== false) ? $this->config['return_path'] : $this->config['from']['email'];
		if ( ! @mail(static::format_addresses($this->to), $this->subject, $message['body'], $message['header'], '-oi -f '.$return_path))
		{
			throw new \EmailSendingFailedException('Failed sending email');
		}
		return true;
	}

}
