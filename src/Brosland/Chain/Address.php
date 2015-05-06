<?php

namespace Brosland\Chain;

use DateTime;

class Address extends \Nette\Object
{
	/**
	 * @var array
	 */
	private $address;


	/**
	 * @param array $address
	 */
	public function __construct(array $address)
	{
		$this->address = $address;
	}

	/**
	 * The Bitcoin public address.
	 * 
	 * @return string
	 */
	public function getAddress()
	{
		return $this->address['address'];
	}

	/**
	 * All-time confirmed balance + current amount received in unconfirmed
	 * transactions - current amount sent in unconfirmed transactions.
	 * This is the amount available to create new transactions.
	 * 
	 * @return string
	 */
	public function getTotalBalance()
	{
		return $this->address['total']['balance'];
	}

	/**
	 * All-time confirmed amount received + current amount received in unconfirmed transactions.
	 * This does not include change received back to the address.
	 * 
	 * @return string
	 */
	public function getTotalReceived()
	{
		return $this->address['total']['received'];
	}

	/**
	 * All-time confirmed amount sent + current amount sent in unconfirmed transactions.
	 * This does not include change sent back to the address.
	 * 
	 * @return string
	 */
	public function getTotalSent()
	{
		return $this->address['total']['sent'];
	}

	/**
	 * All-time balance of confirmed transactions.
	 * 
	 * @return string
	 */
	public function getConfirmedBalance()
	{
		return $this->address['confirmed']['balance'];
	}

	/**
	 * All-time confirmed amount received. This does not include change received back to the address.
	 * 
	 * @return string
	 */
	public function getConfirmedReceived()
	{
		return $this->address['confirmed']['received'];
	}

	/**
	 * All-time confirmed amount sent. This does not include change sent back to the address.
	 * 
	 * @return string
	 */
	public function getConfirmedSent()
	{
		return $this->address['confirmed']['sent'];
	}
}