<?php

namespace Brosland\Chain\Notifications;

use Brosland\Chain\Transaction;

class TransactionNotification extends Notification
{
	/**
	 * @var Transaction
	 */
	private $transaction;


	/**
	 * @param array $notification
	 */
	protected function __construct(array $notification)
	{
		parent::__construct($notification);

		$this->transaction = new Transaction($notification['payload']['transaction']);
	}

	/**
	 * @return Transaction
	 */
	public function getTransaction()
	{
		return $this->transaction;
	}
}