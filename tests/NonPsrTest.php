<?php

use CodeIgniter\Cache\Handlers\DummyHandler;
use CodeIgniter\I18n\Time;
use CodeIgniter\Psr\Cache\CacheArgumentException;
use CodeIgniter\Psr\Cache\Item;
use CodeIgniter\Psr\Cache\SimpleCache;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\Mock\MockCache;
use Config\Cache;
use Config\Services;

class NonPsrTest extends CIUnitTestCase
{
	public function setUp(): void
	{
		parent::setUp();

		Services::resetSingle('cache');
	}

	public function testConstructorUsesSharedInstance()
	{
		Services::injectMock('cache', new MockCache());

		$psr    = new SimpleCache();
		$result = $this->getPrivateProperty($psr, 'adapter');

		$this->assertInstanceOf(MockCache::class, $result);
	}

	public function testConstructorUsesConfig()
	{
		$config          = new Cache();
		$config->handler = 'dummy';

		$psr    = new SimpleCache($config);
		$result = $this->getPrivateProperty($psr, 'adapter');

		$this->assertInstanceOf(DummyHandler::class, $result);
	}

	public function testConstructorUsesHandler()
	{
		$psr    = new SimpleCache(new MockCache());
		$result = $this->getPrivateProperty($psr, 'adapter');

		$this->assertInstanceOf(MockCache::class, $result);
	}

	public function testConstructorThrowsException()
	{
		$this->expectException(CacheArgumentException::class);
		$this->expectExceptionMessage('CodeIgniter\Psr\Cache\SimpleCache constructor only accepts an adapter or configuration');

		$psr = new SimpleCache(42); // @phpstan-ignore-line
	}

	//--------------------------------------------------------------------

	public function testItemExpiresAtThrowsException()
	{
		$item = new Item('foo', 'bar', false);

		$this->expectException(CacheArgumentException::class);
		$this->expectExceptionMessage('Expiration date must be a DateTimeInterface or null');

		$item->expiresAt(123); // @phpstan-ignore-line
	}

	public function testItemExpiresAfterThrowsException()
	{
		$item = new Item('foo', 'bar', false);

		$this->expectException(CacheArgumentException::class);
		$this->expectExceptionMessage('Expiration date must be an integer, a DateInterval or null');

		$item->expiresAfter('tomorrow'); // @phpstan-ignore-line
	}

	public function testItemExpiresAfterAcceptsDateInterval()
	{
		$item = new Item('foo', 'bar', false);
		$item->expiresAfter(new DateInterval('P1W2D'));

		$this->assertInstanceOf(Time::class, $item->getExpiration());
	}
}
