<?php

namespace Brosland\Chain\Notifications;

class AddressNotificationObject extends NotificationObject
{

	/**
	 * The address Chain will monitor for new transactions.
	 * 
	 * @return string
	 */
	public function getAddress()
	{
		return $this->data['address'];
	}
}