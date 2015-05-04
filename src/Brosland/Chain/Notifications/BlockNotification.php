<?php

namespace Brosland\Chain\Notifications;

use Brosland\Chain\Block;

class BlockNotification extends Notification
{
	/**
	 * @var Block
	 */
	private $block;


	/**
	 * @param array $notification
	 */
	protected function __construct(array $notification)
	{
		parent::__construct($notification);

		$this->block = new Block($notification['payload']['block']);
	}

	/**
	 * @return Block
	 */
	public function getBlock()
	{
		return $this->block;
	}
}