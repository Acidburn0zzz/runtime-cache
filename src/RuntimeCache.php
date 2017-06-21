<?php

namespace elementary\cache\Runtime;

use elementary\core\Singleton\SingletonTrait;
use Psr\SimpleCache\CacheInterface;

/**
 * @package elementary\cache\Runtime
 */
class RuntimeCache implements CacheInterface
{
    use SingletonTrait;

    /**
     * @var array
     */
    protected $cache = [];

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->cache);
    }

    /**
     * Set data in the cache if key do not exist
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return bool
     */
    public function add($key, $value)
    {
        $retunValue = false;

        if (!$this->has($key)) {
            $this->set($key, $value);
            $retunValue = true;
        }

        return $retunValue;
    }

    /**
     * @inheritdoc
     */
    public function set($key, $value, $ttl=null)
    {
        $this->cache[$key] = $value;

        return true;
    }

    /**
     * @inheritdoc
     */
    public function setMultiple($values, $ttl = null)
    {
        foreach ($values as $key=>$value) {
            $this->set($key, $value);
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function get($key, $default = null)
    {
        if ($this->has($key)) {
            return $this->cache[$key];
        } else {
            return $default;
        }
    }

    /**
     * @inheritdoc
     */
    public function getMultiple($keys, $default = null)
    {
        $returnValue = [];

        foreach ($keys as $key) {
            $returnValue[$key] = $this->get($key, $default);
        }

        return $returnValue;
    }

    /**
     * @inheritdoc
     */
    public function delete($key)
    {
        $retunValue = false;

        if ($this->has($key)) {
            unset($this->cache[$key]);
            $retunValue = true;
        }

        return $retunValue;
    }

    /**
     * @inheritdoc
     */
    public function deleteMultiple($keys)
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }

        return true;

    }

    /**
     * @inheritdoc
     */
    public function clear()
    {
        $this->cache = [];
    }
}