<?php namespace Illuminate\Cache;

class ApcStore implements StoreInterface {

	/**
	 * The APC wrapper instance.
	 *
	 * @var \Illuminate\Cache\ApcWrapper
	 */
	protected $apc;

	/**
	 * A string that should be prepended to keys.
	 *
	 * @var string
	 */
	protected $prefix;

	/**
	 * Create a new APC store.
	 *
	 * @param  \Illuminate\Cache\ApcWrapper  $apc
	 * @param  string                       $prefix
	 * @return void
	 */
	public function __construct(ApcWrapper $apc, $prefix = '')
	{
		$this->apc = $apc;
		$this->prefix = $prefix;
	}

	/**
	 * Retrieve an item from the cache by key.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	public function get($key)
	{
		$value = $this->apc->get($this->prefix.$key);

		if ($value !== false)
		{
			return $value;
		}
	}

	/**
	 * Store an item in the cache for a given number of minutes.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @param  int     $minutes
	 * @return void
	 */
	public function put($key, $value, $minutes)
	{
		$this->apc->put($this->prefix.$key, $value, $minutes * 60);
	}

	/**
	 * Increment the value of an item in the cache.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function increment($key, $value = 1)
	{
		return $this->apc->increment($this->prefix.$key, $value);
	}

	/**
	 * Increment the value of an item in the cache.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function decrement($key, $value = 1)
	{
		return $this->apc->decrement($this->prefix.$key, $value);
	}

	/**
	 * Store an item in the cache indefinitely.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function forever($key, $value)
	{
		return $this->put($key, $value, 0);
	}

	/**
	 * Remove an item from the cache.
	 *
	 * @param  string  $key
	 * @return void
	 */
	public function forget($key)
	{
		$this->apc->delete($this->prefix.$key);
	}

	/**
	 * Remove all items from the cache.
	 *
	 * @return void
	 */
	public function flush()
	{
		$this->apc->flush();
	}

	/**
	 * Begin executing a new section operation.
	 *
	 * @param  string  $name
	 * @return \Illuminate\Cache\Section
	 */
	public function section($name)
	{
		return new Section($this, $name);
	}

}