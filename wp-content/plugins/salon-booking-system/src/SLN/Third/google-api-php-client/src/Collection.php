<?php

namespace Google;

/**
 * Extension to the regular Google\Model that automatically
 * exposes the items array for iteration, so you can just
 * iterate over the object rather than a reference inside.
 */
class Collection extends Model implements \Iterator, \Countable
{
  protected $collection_key = 'items';

  public function rewind(): void
  {
    if (isset($this->{$this->collection_key})
        && is_array($this->{$this->collection_key})) {
      reset($this->{$this->collection_key});
    }
  }

  public function current(): mixed
  {
    $this->coerceType($this->key());
    if (is_array($this->{$this->collection_key})) {
      return current($this->{$this->collection_key});
    }
  }

  public function key(): mixed
  {
    if (isset($this->{$this->collection_key})
        && is_array($this->{$this->collection_key})) {
      return key($this->{$this->collection_key});
    }
  }

  #[\ReturnTypeWillChange]
  public function next()
  {
    return next($this->{$this->collection_key});
  }

  #[\ReturnTypeWillChange]
  public function valid()
  {
    $key = $this->key();
    return $key !== null && $key !== false;
  }

  public function count(): int
  {
    if (!isset($this->{$this->collection_key})) {
      return 0;
    }
    return count($this->{$this->collection_key});
  }

  #[\ReturnTypeWillChange]
  public function offsetExists($offset)
  {
    if (!is_numeric($offset)) {
      return parent::offsetExists($offset);
    }
    return isset($this->{$this->collection_key}[$offset]);
  }

  #[\ReturnTypeWillChange]
  public function offsetGet($offset)
  {
    if (!is_numeric($offset)) {
      return parent::offsetGet($offset);
    }
    $this->coerceType($offset);
    return $this->{$this->collection_key}[$offset];
  }

  public function offsetSet($offset, $value): void
  {
    if (!is_numeric($offset)) {
      parent::offsetSet($offset, $value);
      return;
    }
    $this->{$this->collection_key}[$offset] = $value;
  }

  public function offsetUnset($offset): void
  {
    if (!is_numeric($offset)) {
      parent::offsetUnset($offset);
      return;
    }
    unset($this->{$this->collection_key}[$offset]);
  }

  private function coerceType($offset)
  {
    $keyType = $this->keyType($this->collection_key);
    if ($keyType && !is_object($this->{$this->collection_key}[$offset])) {
      $this->{$this->collection_key}[$offset] =
          new $keyType($this->{$this->collection_key}[$offset]);
    }
  }
}
