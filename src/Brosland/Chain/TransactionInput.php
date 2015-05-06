<?php

namespace Brosland\Chain;

class TransactionInput extends \Nette\Object
{
	/**
	 * @var array
	 */
	private static $REQUIRED = [
		'transaction_hash', 'output_hash', 'output_index', 'value', 'addresses',
		'script_signature'
	];
	/**
	 * @var array
	 */
	private $transactionInput;


	/**
	 * @param array $transactionInput
	 */
	public function __construct(array $transactionInput)
	{
		Utils::checkRequiredFields(self::$REQUIRED, $transactionInput);

		$this->transactionInput = $transactionInput;
	}

	/**
	 * The hash of the transaction in which the input is contained.
	 * Does not exist for coinbase transactions (when new coins are mined).
	 * 
	 * @return string
	 */
	public function getTransactionHash()
	{
		return $this->transactionInput['transaction_hash'];
	}

	/**
	 * The hash of the transaction whose output was used to create the input.
	 * Does not exist for coinbase transactions (when new coins are mined).
	 * 
	 * @return string
	 */
	public function getOutputHash()
	{
		return $this->transactionInput['output_hash'];
	}

	/**
	 * The position of the output in the transaction from which the input was created.
	 * Does not exist for coinbase transactions (when new coins are mined).
	 * 
	 * @return int
	 */
	public function getOutputIndex()
	{
		return $this->transactionInput['output_index'];
	}

	/**
	 * The value of the input in satoshis.
	 * 
	 * @return string
	 */
	public function getValue()
	{
		return $this->transactionInput['value'];
	}

	/**
	 * The address (or addresses in the case of multi-sig) from which the value was transferred.
	 * 
	 * @return string[]
	 */
	public function getAddresses()
	{
		return $this->transactionInput['addresses'];
	}

	/**
	 * Bitcoin assembly script used to authorize the input for use in the transaction.
	 * 
	 * @return string
	 */
	public function getScriptSignature()
	{
		return $this->transactionInput['script_signature'];
	}
}