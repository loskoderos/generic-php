<?php

namespace LosKoderos\Generic\ClassFactory;

class ClassFactory {
  private static array $classMap = [];

  private function __construct() {}

  /**
   * Add overrides to class map.
   * Basic function used to override class created with cf_new helper function.
   * @param array $override
   */
  public static function override(array $override)
  {
      foreach ($override as $key => $classname) {
          self::set($key, $classname);
      }
  }

  /**
   * Clear class map.
   */
  public static function clear()
  {
      self::$classMap = [];
  }

  /**
   * Set class map override.
   * @param string $key
   * @param string $classname
   */
  public static function set(string $key, string $classname)
  {
      self::$classMap[$key] = $classname;
  }

  /**
   * Get classname by key.
   * @param string $key
   * @return string
   */
  public static function get(string $key): string
  {
      if (!isset(self::$classMap[$key])) {
          return $key;
      }
      return self::$classMap[$key];
  }

  /**
   * Check if class map has an override.
   * @param string $key
   * @return bool
   */
  public static function has(string $key): bool
  {
      return isset(self::$classMap[$key]);
  }

  /**
   * Remove class map override.
   * @param string $key
   */
  public static function remove(string $key)
  {
      unset(self::$classMap[$key]);
  }

  /**
   * Create a new instance of an object, use the override as class name.
   * In case when there is no override, the $key is used as the fallback class name.
   * @param string $key
   * @return mixed
   */
  public static function new(string $key, ...$args)
  {
      $classname = self::get($key);
      return new $classname(...$args);
  }
}
