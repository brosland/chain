<?php

namespace Brosland\Chain\Notifications;

class TransactionNotificationObject extends NotificationObject
{

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