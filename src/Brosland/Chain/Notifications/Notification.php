<?php

namespace Brosland\Chain\Notifications;

use DateTime;

abstract class Notification extends \Nette\Object
{
	const TYPE_ADDRESS = 'address',
		TYPE_TRANSACTION = 'transaction',
		TYPE_NEW_BLOCK = 'new-block',
		TYPE_NEW_TRANSACTION = 'new-transaction';


	/**
	 * @var array
	 */
	protected $notification;


	/**
	 * @param array $notification
	 * @return Notification
	 */
	public static function createFromArray(array $notification)
	{
		if ($notification['type'] == self::TYPE_ADDRESS)
		{
			return new AddressNotification($notification);
		}
		else if ($notification['type'] == self::TYPE_NEW_BLOCK)
		{
			return new BlockNotification($notification);
		}
		else // transaction or new-transaction
		{
			return new TransactionNotification($notification);
		}
	}

	/**
	 * @param array $notification
	 */
	protected function __construct(array $notification)
	{
		$this->notification = $notification;
		$this->notification['created_at'] = DateTime::createFromFormat(
				DateTime::ISO8601, $this->notification['created_at']);
	}

	/**
	 * The Notification Result type.
	 * 
	 * @return string
	 */
	public function getType()
	{
		return $this->notification['payload']['type'];
	}

	/**
	 * The block chain on which the Result occurred.
	 * 
	 * @return string
	 */
	public function getBlockChain()
	{
		return $this->notification['payload']['block_chain'];
	}

	/**
	 * The unique identifier of the Notification Result.
	 * 
	 * @return string
	 */
	public function getId()
	{
		return $this->notification['id'];
	}

	/**
	 * The UTC time (in ISO8601 format) that the result was created.
	 * 
	 * @return DateTime
	 */
	public function getCreated()
	{
		return $this->notification['created_at'];
	}

	/**
	 * The unique identifier of the Delivery Attempt for the Notification Result.
	 * 
	 * @return int
	 */
	public function getDeliveryAttempt()
	{
		return $this->notification['delivery_attempt'];
	}

	/**
	 * The unique identifier of Notification for which the result occurred.
	 * 
	 * @return string
	 */
	public function getNotificationId()
	{
		return $this->notification['notification_id'];
	}

	/**
	 * @param string $type
	 * @return bool
	 */
	public static function validateType($type)
	{
		return $type == self::TYPE_ADDRESS || $type == self::TYPE_TRANSACTION ||
			$type == self::TYPE_NEW_BLOCK || $type == self::TYPE_NEW_TRANSACTION;
	}
}