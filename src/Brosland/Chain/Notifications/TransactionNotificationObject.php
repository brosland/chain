<?php

namespace Brosland\Chain\Notifications;

class TransactionNotificationObject extends NotificationObject
{
	/**
	 * @var array
	 */
	private static $REQUIRED = ['transaction_hash'];


	/**
	 * @param array $data
	 */
	protected function __construct(array $data)
	{
		parent::__construct($data);

		\Brosland\Chain\Utils::checkRequiredFields(self::$REQUIRED, $data);
	}

	/**
	 * The transaction Chain will monitor for new confirmations.
	 * 
	 * @return string
	 */
	public function getTransaction()
	{
		return $this->data['transaction_hash'];
	}
}