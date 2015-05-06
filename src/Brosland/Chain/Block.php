<?php

namespace Brosland\Chain;

use DateTime;

class Block extends \Nette\Object
{
	/**
	 * @var array
	 */
	private $block;


	/**
	 * @param array $block
	 */
	public function __construct(array $block)
	{
		$block['time'] = DateTime::createFromFormat('Y-m-d\TH:i:s.uO', $block['time']);

		$this->block = $block;
	}

	/**
	 * The block hash.
	 * 
	 * @return string
	 */
	public function getHash()
	{
		return $this->block['hash'];
	}

	/**
	 * The hash of the previous block in the chain.
	 * 
	 * @return string
	 */
	public function getPreviousBlockHash()
	{
		return $this->block['previous_block_hash'];
	}

	/**
	 * The distance from the first block in the chain (height = 0).
	 * 
	 * @return int
	 */
	public function getHeight()
	{
		return $this->block['height'];
	}

	/**
	 * The number of blocks that have been processed since the previous block (including the block itself).
	 * 
	 * @return int
	 */
	public function getConfirmations()
	{
		return $this->block['confirmations'];
	}

	/**
	 * The top of the Merkle tree, which can be used to verify that a given transaction was included in the block.
	 * 
	 * @return string
	 */
	public function getMerkleRoot()
	{
		return $this->block['merkle_root'];
	}

	/**
	 * The time at which the block was created by the miner.
	 * 
	 * @return DateTime
	 */
	public function getTime()
	{
		return $this->block['time'];
	}

	/**
	 * The value that constituted the proof of work for the block.
	 * 
	 * @return DateTime
	 */
	public function getNonce()
	{
		return $this->block['nonce'];
	}

	/**
	 * The network-imposed difficulty for finding the block hash.
	 * 
	 * @return float
	 */
	public function getDifficulty()
	{
		return $this->block['difficulty'];
	}

	/**
	 * An array of transaction hashes included in the block.
	 * 
	 * @return string[]
	 */
	public function getTransactionHashes()
	{
		return $this->block['transaction_hashes'];
	}
}