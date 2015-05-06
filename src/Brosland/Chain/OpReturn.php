<?php

namespace Brosland\Chain;

class OpReturn extends \Nette\Object
{
	/**
	 * @var array
	 */
	private static $REQUIRED = [
		'transaction_hash', 'hex', 'text', 'sender_addresses', 'receiver_addresses'
	];
	/**
	 * @var array
	 */
	private $opReturn;


	/**
	 * @param array $opReturn
	 */
	public function __construct(array $opReturn)
	{
		Utils::checkRequiredFields(self::$REQUIRED, $opReturn);

		$this->opReturn = $opReturn;
	}

	/**
	 * The hash of the transaction which contains the OP_RETURN.
	 * 
	 * @return string
	 */
	public function getTransactionHash()
	{
		return $this->opReturn['transaction_hash'];
	}

	/**
	 * The raw hex value of the OP_RETURN.
	 * 
	 * @return string
	 */
	public function getHex()
	{
		return $this->opReturn['hex'];
	}

	/**
	 * The UTF8 decoded text of the OP_RETURN.
	 * 
	 * @return string
	 */
	public function getText()
	{
		return $this->opReturn['text'];
	}

	/**
	 * An array of addresses associated with the inputs of the transaction.
	 * 
	 * @return array
	 */
	public function getSenderAddresses()
	{
		return $this->opReturn['sender_addresses'];
	}

	/**
	 * An array of addresses associated with the outputs of the transaction.
	 * 
	 * @return array
	 */
	public function getReceiverAddresses()
	{
		return $this->opReturn['receiver_addresses'];
	}
}