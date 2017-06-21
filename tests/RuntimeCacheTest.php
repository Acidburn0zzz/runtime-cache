<?php

namespace elementary\cache\Runtime\Test;

use PHPUnit_Framework_TestCase;
use elementary\cache\Runtime\RuntimeCache;

/**
 * @coversDefaultClass \elementary\cache\Runtime\RuntimeCache
 */
class RuntimeCacheTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var RuntimeCache
     */
    protected $memory = null;

    /**
     * @test
     * @covers ::me()
     */
    public function me()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        $me1 = RuntimeCache::me();
        $me2 = RuntimeCache::me();

        $this->assertInstanceOf('\elementary\cache\Runtime\RuntimeCache', $me1);
        $this->assertInstanceOf('\elementary\cache\Runtime\RuntimeCache', $me2);

        $me1->set('test', 1234);
        $this->assertEquals($me1->get('test'), $me2->get('test'));
    }

    /**
     * @test
     * @covers ::add()
     */
    public function add()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        $this->assertTrue($this->getMemory()->add('test', 1234));
        $this->assertFalse($this->getMemory()->add('test', 1234));
    }

    /**
     * @test
     * @covers ::set()
     */
    public function set()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        $this->getMemory()->set('test2', 1234);
        $this->assertEquals(1234, $this->getMemory()->get('test2'));
    }

    /**
     * @test
     * @covers ::get()
     */
    public function get()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        $this->assertEquals(1234, $this->getMemory()->get('test', 1234));
    }

    /**
     * @test
     * @covers ::has()
     */
    public function has()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        $this->getMemory()->set('test', 1234);
        $this->assertTrue($this->getMemory()->has('test'));
        $this->assertFalse($this->getMemory()->has('test2'));
    }

    /**
     * @test
     * @covers ::delete()
     */
    public function delete()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        $this->getMemory()->set('test', 1234);
        $this->assertTrue($this->getMemory()->delete('test'));
        $this->assertFalse($this->getMemory()->has('test'));
    }

    /**
     * @test
     * @covers ::setMultiple()
     * @covers ::getMultiple()
     * @covers ::deleteMultiple()
     */
    public function multiple()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        $this->getMemory()->setMultiple(['test' => 123, 'test2' => 1234, 'test3' => 12345]);

        $this->assertEquals(['test' => 123, 'test3' => 12345], $this->getMemory()->getMultiple(['test', 'test3']));
        $this->assertTrue($this->getMemory()->deleteMultiple(['test', 'test3']));
        $this->assertFalse($this->getMemory()->has('test'));
        $this->assertFalse($this->getMemory()->has('test3'));
        $this->assertTrue($this->getMemory()->has('test2'));
    }

    protected function setUp()
    {
        $this->setMemory(new RuntimeCache());
    }

    /**
     * @return RuntimeCache
     */
    public function getMemory()
    {
        return $this->memory;
    }

    /**
     * @param RuntimeCache $memory
     *
     * @return $this
     */
    public function setMemory($memory)
    {
        $this->memory = $memory;

        return $this;
    }

}
