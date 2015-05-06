<?php

namespace Brosland\Chain\DI;

use Brosland\Chain\Chain;

class ChainExtension extends \Nette\DI\CompilerExtension
{
	/**
	 * @var array
	 */
	private static $DEFAULTS = [
		'account' => []
	];
	/**
	 * @var array
	 */
	private static $ACCOUNT_DEFAULTS = [
		'id' => NULL,
		'secret' => NULL,
		'blockChain' => Chain::BLOCK_CHAIN_BITCOIN
	];


	public function loadConfiguration()
	{
		parent::loadConfiguration();

		$builder = $this->getContainerBuilder();
		$config = $this->getConfig(self::$DEFAULTS);

		$accounts = $this->loadAccounts($config['account']);

		$builder->addDefinition($this->prefix('chain'))
			->setClass(\Brosland\Chain\Chain::class)
			->addSetup('injectServiceLocator')
			->addSetup('injectServiceMap', [$accounts]);
	}

	/**
	 * @param array $definitions
	 * @return array
	 */
	private function loadAccounts($definitions)
	{
		if (isset($definitions['id']))
		{
			$definitions = ['default' => $definitions];
		}

		$builder = $this->getContainerBuilder();
		$accounts = [];

		foreach ($definitions as $name => $account)
		{
			$account = $this->mergeConfig($account, self::$ACCOUNT_DEFAULTS);
			$serviceName = $this->prefix('account.' . $name);

			$service = $builder->addDefinition($serviceName);
			$service->setClass(\Brosland\Chain\Account::class)
				->setArguments([
					$account['id'],
					$account['secret'],
					$account['blockChain']
			]);

			if (!empty($accounts))
			{
				$service->setAutowired(FALSE);
			}

			$accounts[$name] = $serviceName;
		}

		return $accounts;
	}

	/**
	 * @param array $config
	 * @param array $defaults
	 * @return array
	 */
	private function mergeConfig($config, $defaults)
	{
		return \Nette\DI\Config\Helpers::merge(
				$config, $this->compiler->getContainerBuilder()->expand($defaults));
	}
}