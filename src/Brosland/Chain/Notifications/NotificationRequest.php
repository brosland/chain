<?php

namespace Brosland\Chain\Notifications;

use Brosland\Chain\Chain;

class NotificationRequest extends \Nette\Object
{
	/**
	 * @var array
	 */
	private $parameters = [];


	/**
	 * @param string $address
	 * @param string $url
	 * @param string $blockChain
	 * @return NotificationRequest
	 */
	public function createAddressNotificationRequest($address, $url, $blockChain)
	{
		$request = new NotificationRequest(Notification::TYPE_ADDRESS, $url, $blockChain);
		$request->parameters['address'] = $address;

		return $request;
	}

	/**
	 * @param string $txHash
	 * @param string $url
	 * @param string $blockChain
	 * @return NotificationRequest
	 */
	public function createTransactionNotificationRequest($txHash, $url, $blockChain)
	{
		$request = new NotificationRequest(Notification::TYPE_TRANSACTION, $url, $blockChain);
		$request->parameters['transaction_hash'] = $txHash;

		return $request;
	}

	/**
	 * @param string $type
	 * @param string $url
	 * @param string $blockChain
	 */
	public function __construct($type, $url,
		$blockChain = Chain::BLOCK_CHAIN_BITCOIN)
	{
		if (!Notification::validateType($type))
		{
			throw new \Nette\InvalidArgumentException("Unknown type {$type}.");
		}

		if (!Chain::validateBlockChain($blockChain))
		{
			throw new \Nette\InvalidArgumentException("Unknown block chain {$blockChain}.");
		}

		$this->parameters['type'] = $type;
		$this->parameters['url'] = $url;
		$this->parameters['block_chain'] = $blockChain;
	}

	/**
	 * @return array
	 */
	public function getParameters()
	{
		return $this->parameters;
	}
}