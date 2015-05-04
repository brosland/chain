<?php

namespace Brosland\Chain;

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
		$address['time'] = DateTime::createFromFormat(DateTime::ISO8601, $address['time']);

		$this->address = $address;
	}

	/**
	 * 
	 * @return string
	 */
	public function getAddress()
	{
		return $this->address['address'];
	}

	/**
	 * 
	 * @return string
	 */
	public function getTotalBalance()
	{
		return $this->address['total']['balance'];
	}

	/**
	 * 
	 * @return string
	 */
	public function getTotalReceived()
	{
		return $this->address['total']['received'];
	}

	/**
	 * 
	 * @return string
	 */
	public function getTotalSent()
	{
		return $this->address['total']['sent'];
	}

	/**
	 * 
	 * @return string
	 */
	public function getConfirmedBalance()
	{
		return $this->address['confirmed']['balance'];
	}

	/**
	 * 
	 * @return string
	 */
	public function getConfirmedReceived()
	{
		return $this->address['confirmed']['received'];
	}

	/**
	 * 
	 * @return string
	 */
	public function getConfirmedSent()
	{
		return $this->address['confirmed']['sent'];
	}
}