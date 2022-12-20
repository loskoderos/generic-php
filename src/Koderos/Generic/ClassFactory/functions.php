<?php

namespace Koderos\Generic\ClassFactory;

/**
 * Helper functions for ClassFactory.
 */

function cf_override(array $overrides)
{
    ClassFactory::getInstance()->override($overrides);
}

function cf_clear()
{
    ClassFactory::getInstance()->clear();
}

function cf_set(string $key, string $className)
{
    ClassFactory::getInstance()->set($key, $className);
}

function cf_get(string $key): string
{
    return ClassFactory::getInstance()->get($key);
}

function cf_has(string $key): bool
{
    return ClassFactory::getInstance()->has($key);
}

function cf_remove(string $key)
{
    ClassFactory::getInstance()->remove($key);
}

function cf_new(string $className, ...$args)
{
    return ClassFactory::getInstance()->create($className, ...$args);
}
