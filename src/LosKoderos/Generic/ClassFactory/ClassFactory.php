<?php

namespace LosKoderos\Generic\ClassFactory;

require_once __DIR__ . '/functions.php';

final class ClassFactory {
  private static ?ClassFactory $factory = null;
  private array $classMap = [];

  private function __construct()
  {
  }

  /**
   * Add overrides to class map.
   * Basic function used to override class created with cf_new helper function.
   * @param array $overrides
   * @return ClassFactory
   */
  public function override(array $overrides): ClassFactory
  {
      foreach ($overrides as $key => $className) {
          $this->set($key, $className);
      }
      return $this;
  }

  /**
   * Clear class map.
   * @return ClassFactory
   */
  public function clear(): ClassFactory
  {
      $this->classMap = [];
      return $this;
  }

  /**
   * Set class map override.
   * @param string $key
   * @param string $className
   * @return ClassFactory
   */
  public function set(string $key, string $className): ClassFactory
  {
      $this->classMap[$key] = $className;
      return $this;
  }

  /**
   * Get className by key.
   * @param string $key
   * @return string
   */
  public function get(string $key): string
  {
      if (!isset($this->classMap[$key])) {
          return $key;
      }
      return $this->classMap[$key];
  }

  /**
   * Check if class map has an override.
   * @param string $key
   * @return bool
   */
  public function has(string $key): bool
  {
      return isset($this->classMap[$key]);
  }

  /**
   * Remove class map override.
   * @param string $key
   * @return ClassFactory
   */
  public function remove(string $key): ClassFactory
  {
      unset($this->classMap[$key]);
      return $this;
  }

  /**
   * Create a new instance of an object, use the override as class name.
   * In case when there is no override, the $key is used as the fallback class name.
   * @param string $key
   * @return mixed
   */
  public function create(string $key, ...$args)
  {
      $className = $this->get($key);
      return new $className(...$args);
  }

  /**
   * Get instance of the ClassFactory
   * @return ClassFactory
   */
  public static function getInstance(): ClassFactory
  {
      if (!isset(self::$factory)) {
          self::$factory = new self();
      }
      return self::$factory;
  }
}
