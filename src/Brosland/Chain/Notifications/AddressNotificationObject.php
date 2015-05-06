<?php

namespace Brosland\Chain\Notifications;

class AddressNotificationObject extends NotificationObject
{
	/**
	 * @var array
	 */
	private static $REQUIRED = ['address'];


	/**
	 * @param array $data
	 */
	protected function __construct(array $data)
	{
		parent::__construct($data);

		\Brosland\Chain\Utils::checkRequiredFields(self::$REQUIRED, $data);
	}

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