<?php

namespace Brosland\Chain\Notifications;

class AddressNotification extends Notification
{

	/**
	 * The address for which the Result occurred.
	 * 
	 * @return string
	 */
	public function getAddress()
	{
		return $this->notification['payload']['address'];
	}

	/**
	 * The total amount (in satoshis) sent by the address in the new transaction.
	 * This does not include change sent back to the address.
	 * 
	 * @return string
	 */
	public function getSent()
	{
		return $this->notification['payload']['sent'];
	}

	/**
	 * The total amount (in satoshis) received by the address in the new transaction.
	 * This does not include change received back to the address.
	 * 
	 * @return string
	 */
	public function getReceived()
	{
		return $this->notification['payload']['received'];
	}

	/**
	 * The address(es) sending funds in the transaction.
	 * 
	 * @return string[]
	 */
	public function getInputAddresses()
	{
		return $this->notification['payload']['input_addresses'];
	}

	/**
	 * The address(es) receiving funds in the transaction.
	 * 
	 * @return string[]
	 */
	public function getOutputAddresses()
	{
		return $this->notification['payload']['output_addresses'];
	}

	/**
	 * The hash of the new transaction.
	 * 
	 * @return string
	 */
	public function getTransactionHash()
	{
		return $this->notification['payload']['transaction_hash'];
	}

	/**
	 * The hash of the block containing the new transaction. If confirmations = 0, returns null.
	 * 
	 * @return string
	 */
	public function getBlockHash()
	{
		return $this->notification['payload']['block_hash'];
	}

	/**
	 * The number of confirmations on the new transaction.
	 * 
	 * @return int
	 */
	public function getConfirmations()
	{
		return $this->notification['payload']['confirmations'];
	}
}