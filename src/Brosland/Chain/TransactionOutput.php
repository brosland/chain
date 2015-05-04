<?php

namespace Brosland\Chain;

class TransactionOutput extends \Nette\Object
{
	/**
	 * @var array
	 */
	private $transactionOutput;


	/**
	 * @param array $transactionOutput
	 */
	public function __construct(array $transactionOutput)
	{
		$this->transactionOutput = $transactionOutput;
	}

	/**
	 * The hash of the transaction within which the output is contained (the queried transaction).
	 * 
	 * @return string
	 */
	public function getTransactionHash()
	{
		return $this->transactionOutput['transaction_hash'];
	}

	/**
	 * The specific position in the transaction within which the output is contained.
	 * 
	 * @return int
	 */
	public function getOutputIndex()
	{
		return $this->transactionOutput['output_index'];
	}

	/**
	 * The unspent amount of the output in satoshis.
	 * 
	 * @return string
	 */
	public function getValue()
	{
		return $this->transactionOutput['value'];
	}

	/**
	 * The address (or addresses in the case of multi-sig) to which the value was transferred.
	 * 
	 * @return string[]
	 */
	public function getAddresses()
	{
		return $this->transactionOutput['addresses'];
	}

	/**
	 * The script of the output.
	 * 
	 * @return string
	 */
	public function getScript()
	{
		return $this->transactionOutput['script'];
	}

	/**
	 * The hex-encoded script of the output.
	 * 
	 * @return string
	 */
	public function getScriptHex()
	{
		return $this->transactionOutput['script_hex'];
	}

	/**
	 * The type of output (for example, multi-sig).
	 * 
	 * @return string
	 */
	public function getScriptType()
	{
		return $this->transactionOutput['script_type'];
	}

	/**
	 * The number of signatures required to spend the output.
	 * This can be > 1 in the case of multi-sig.
	 * 
	 * @return int
	 */
	public function getRequiredSignatures()
	{
		return $this->transactionOutput['required_signatures'];
	}

	/**
	 * True if the output has been spent. False if the output is unspent.
	 * 
	 * @return bool
	 */
	public function isSpent()
	{
		return $this->transactionOutput['spent'];
	}

	/**
	 * If spent: true, the hash of the subsequent transaction in which the output was spent.
	 * If spent: false, returns null.
	 * 
	 * @return string
	 */
	public function getSpendingTransaction()
	{
		return $this->isSpent() ? $this->transactionOutput['spending_transaction'] : NULL;
	}
}