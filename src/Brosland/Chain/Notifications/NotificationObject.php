<?php

namespace Brosland\Chain\Notifications;

use Brosland\Chain\Notifications\Notification;

class NotificationObject extends \Nette\Object
{
	const STATE_ENABLED = 'enabled',
		STATE_DISABLED = 'disabled',
		STATE_DELETED = 'deleted';


	/**
	 * @var array
	 */
	protected $data;


	/**
	 * @param array $data
	 * @return NotificationObject
	 */
	public static function createFromArray(array $data)
	{
		if ($data['type'] == Notification::TYPE_ADDRESS)
		{
			return new AddressNotificationObject($data);
		}
		else if ($data['type'] == Notification::TYPE_TRANSACTION)
		{
			return new TransactionNotificationObject($data);
		}
		else
		{
			return new NotificationObject($data);
		}
	}

	/**
	 * @param array $data
	 */
	private function __construct(array $data)
	{
		$this->data = $data;
	}

	/**
	 * The unique identifier of the Notification.
	 * 
	 * @return string
	 */
	public function getId()
	{
		return $this->data['id'];
	}

	/**
	 * The Notification type.
	 * 
	 * @return string
	 */
	public function getType()
	{
		return $this->data['type'];
	}

	/**
	 * @return string
	 */
	public function getURL()
	{
		return $this->data['url'];
	}

	/**
	 * The block chain to monitor. For example: bitcoin or testnet3.
	 * 
	 * @return string
	 */
	public function getBlockChain()
	{
		return $this->data['block_chain'];
	}

	/**
	 * "enabled" or "disabled". A Notification will be automatically disabled if your application fails
	 * to respond within 5 seconds with a 2xx status code to four consecutive Notification Results.
	 * You can re-enable all disabled Notifications in your Dashboard.
	 * 
	 * @return string
	 */
	public function getState()
	{
		return $this->data['state'];
	}

	/**
	 * @return bool
	 */
	public function isEnabled()
	{
		return $this->getState() == self::STATE_ENABLED;
	}
}