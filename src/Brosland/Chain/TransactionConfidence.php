<?php

namespace Brosland\Chain;

class TransactionConfidence extends \Nette\Object
{
	/**
	 * @var array
	 */
	private static $REQUIRED = [
		'transaction_hash', 'block_hash', 'propagation_level', 'double_spend'
	];
	/**
	 * @var array
	 */
	private $transactionConfidence;


	/**
	 * @param array $transactionConfidence
	 */
	public function __construct(array $transactionConfidence)
	{
		Utils::checkRequiredFields(self::$REQUIRED, $transactionConfidence);

		$this->transactionConfidence = $transactionConfidence;
	}

	/**
	 * The hash of the transaction.
	 * 
	 * @return string
	 */
	public function getTransactionHash()
	{
		return $this->transactionConfidence['transaction_hash'];
	}

	/**
	 * The associated block's hash.
	 * 
	 * @return string
	 */
	public function getBlockHash()
	{
		return $this->transactionConfidence['block_hash'];
	}

	/**
	 * The percentage of nodes in the Bitcoin network (known by Chain) that have
	 * accepted the unconfirmed transaction, represented as a decimal from 0 to 1.
	 * Returns null once the transaction has been confirmed.
	 * 
	 * @return float
	 */
	public function getPropagationLevel()
	{
		return $this->transactionConfidence['propagation_level'];
	}

	/**
	 * TRUE if one of the inputs in the unconfirmed transaction is also used as
	 * an input for a different unconfirmed transaction. This indicates that the funds
	 * within this transaction have been "double spent" to different nodes on the network.
	 * A double_spend attempt only exists in the unconfirmed memory pool,
	 * and therefore returns null once the transaction has been confirmed.
	 * 
	 * @return bool
	 */
	public function isDoubleSpend()
	{
		return $this->transactionConfidence['double_spend'];
	}
}