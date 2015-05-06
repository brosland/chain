<?php

namespace Brosland\Chain;

use DateTime;

class Transaction extends \Nette\Object
{
	/**
	 * @var array
	 */
	private $transaction;


	/**
	 * @param array $transaction
	 */
	public function __construct(array $transaction)
	{
		if (!empty($transaction['block_time']))
		{
			$transaction['block_time'] = DateTime::createFromFormat(
					DateTime::ISO8601, $transaction['block_time']);
		}

		if (!empty($transaction['chain_received_at']))
		{
			$transaction['chain_received_at'] = DateTime::createFromFormat(
					'Y-m-d\TH:i:s.uO', $transaction['chain_received_at']);
		}

		$inputs = [];

		foreach ($transaction['inputs'] as $input)
		{
			$inputs[] = new TransactionInput($input);
		}

		$transaction['inputs'] = $inputs;

		$outputs = [];

		foreach ($transaction['outputs'] as $output)
		{
			$outputs[] = new TransactionOutput($output);
		}

		$transaction['outputs'] = $outputs;

		$this->transaction = $transaction;
	}

	/**
	 * The hash of the transaction.
	 * 
	 * @return string
	 */
	public function getHash()
	{
		return $this->transaction['hash'];
	}

	/**
	 * The hash of the block containing the transaction.
	 * 
	 * @return string
	 */
	public function getBlockHash()
	{
		return $this->transaction['block_hash'];
	}

	/**
	 * The height of the block containing the transaction.
	 * The height of a block is the distance from the first block in the chain (height = 0).
	 * Contains "block_height": null for unconfirmed transactions.
	 * 
	 * @return string
	 */
	public function getBlockHeight()
	{
		return $this->transaction['block_height'];
	}

	/**
	 * The UTC time (in ISO8601 format) at which the block containing the transaction was created by the miner.
	 * Contains "block_time": null for unconfirmed transactions.
	 * 
	 * @return DateTime
	 */
	public function getBlockTime()
	{
		return $this->transaction['block_time'];
	}

	/**
	 * The UTC time (in ISO8601 format) at which Chain.com indexed this transaction.
	 * Note that transactions confirmed prior to June 2014 may be null.
	 * Therefore, when sorting transactions by this time, you should fall back on "block_time".
	 * 
	 * @return DateTime
	 */
	public function getChainReceived()
	{
		return $this->transaction['chain_received_at'];
	}

	/**
	 * The number of blocks that have been processed since the transaction.
	 * This includes the block containing the transaction.
	 * Unconfirmed transactions contain "confirmations": "0".
	 * 
	 * @return int
	 */
	public function getConfirmations()
	{
		return $this->transaction['confirmations'];
	}

	/**
	 * The time (specified in either unix time or block height) before which
	 * the transaction cannot be included in a block.
	 * 
	 * @return int
	 */
	public function getLockTime()
	{
		return $this->transaction['lock_time'];
	}

	/**
	 * @return TransactionInput
	 */
	public function getInputs()
	{
		return $this->transaction['inputs'];
	}

	/**
	 * @return TransactionOutput
	 */
	public function getOutputs()
	{
		return $this->transaction['outputs'];
	}

	/**
	 * The total fees paid to the miner in satoshis. This is not included in the transaction "amount".
	 * 
	 * @return string
	 */
	public function getFees()
	{
		return $this->transaction['fees'];
	}

	/**
	 * The total amount of the transaction in satoshis.
	 * This is equal to total of all output values (or the total of all input values minus the miner fees).
	 * 
	 * @return string
	 */
	public function getAmount()
	{
		return $this->transaction['amount'];
	}
}