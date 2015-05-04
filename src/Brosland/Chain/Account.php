<?php

namespace Brosland\Chain;

use Brosland\Notifications\NotificationRequest;

class Account extends \Nette\Object
{

	/**
	 * @var string
	 */
	private $id;
	/**
	 * @var string
	 */
	private $secret;
	/**
	 * @var string
	 */
	private $blockChain;


	/**
	 * @param string $id
	 * @param string $secret
	 * @param string $blockChain
	 */
	public function __construct($id, $secret, $blockChain)
	{
		if (!Chain::validateBlockChain($blockChain))
		{
			throw new \Nette\InvalidArgumentException("Unknown block chain {$blockChain}.");
		}

		$this->id = $id;
		$this->secret = $secret;
		$this->blockChain = $blockChain;
	}

	//****************************** DATA API ********************************//

	/**
	 * Returns basic balance details for one or more Bitcoin addresses.
	 * 
	 * @link https://chain.com/docs#bitcoin-address
	 * @param string|array $address
	 */
	public function getAddress($address)
	{
		
	}

	/**
	 * Returns details about a Bitcoin transaction, including inputs and outputs.
	 * 
	 * @link https://chain.com/docs#bitcoin-transaction
	 * @param string $hash
	 * @return Transaction
	 */
	public function getTransaction($hash)
	{
		
	}

	/**
	 * Returns a set of transactions for one or more Bitcoin addresses. Pagination is not supported yet.
	 * 
	 * @link https://chain.com/docs#bitcoin-address-transactions
	 * @param string|array $address
	 * @param int $limit The number of transactions to return, starting with most recent (default=50, max=500).
	 * @return Address[]
	 */
	public function getTransactionsByAddress($address, $limit = NULL)
	{
		
	}

	/**
	 * Returns network propagation level and double spend information for a given Bitcoin transaction hash.
	 * 
	 * @link https://chain.com/docs#bitcoin-transaction-confidence
	 * @param string $hash
	 * @return TransactionConfidence
	 */
	public function getTransactionConfidence($hash)
	{
		
	}

	/**
	 * Returns the raw transaction hex data for a given Bitcoin transaction hash.
	 * 
	 * @link https://chain.com/docs#bitcoin-transaction-hex
	 * @param string $hash
	 * @return string
	 */
	public function getTransactionHex()
	{
		
	}

	/**
	 * Returns details about a Bitcoin block, including all transaction hashes.
	 * 
	 * @link https://chain.com/docs#bitcoin-block
	 * @param string $hash
	 * @return Block
	 */
	public function getBlock($hash)
	{
		
	}

	/**
	 * Returns a collection of unspent outputs for a Bitcoin address. These outputs
	 * can be used as inputs for a new transaction. See our blog post for information
	 * on creating a new transaction with unspent outputs.
	 * 
	 * @link https://chain.com/docs#bitcoin-address-unspents
	 * @param string|array $address
	 * @return array
	 */
	public function getUnspentsByAddress($address)
	{
		
	}

	/**
	 * Returns any OP_RETURN values sent and received by a Bitcoin Address.
	 * 
	 * @link https://chain.com/docs#bitcoin-address-op-returns
	 * @param string $address
	 * @return OpReturn[]
	 */
	public function getOpReturnsByAddress($address)
	{
		
	}

	/**
	 * Returns the OP_RETURN value and associated addresses for any transaction
	 * containing an OP_RETURN script.
	 * 
	 * @link https://chain.com/docs#bitcoin-transaction-op-return
	 * @param string $hash
	 * @return OpReturn[]
	 */
	public function getOpReturnsByTransaction($hash)
	{
		
	}

	/**
	 * Returns the OP_RETURN value and associated addresses for all transactions
	 * in the block which contain an OP_RETURN output script.
	 * 
	 * @link https://chain.com/docs#bitcoin-block-op-returns
	 * @param string $hash
	 * @return OpReturn[]
	 */
	public function getOpReturnsByBlock($hash)
	{
		
	}

	
	//**************************** NOTIFICATIONS *****************************//

	/**
	 * 
	 * @param NotificationRequest $request
	 * @return \Brosland\Chain\NotificationResponse
	 */
	public function createNotification(NotificationRequest $request)
	{
		$response = $this->sendRequest('notifications', $request->getParameters());

		return new NotificationResponse($response);
	}
	
	
	
	//************************************************************************//

	
}