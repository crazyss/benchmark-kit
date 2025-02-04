<?php

declare(strict_types=1);

namespace App\PhpVersion;

use steevanb\PhpTypedArray\ObjectArray\ObjectArray;

class PhpVersionArray extends ObjectArray
{
    /** @param iterable<PhpVersion> $phpVersions */
    public function __construct(iterable $phpVersions = [])
    {
        parent::__construct($phpVersions, PhpVersion::class);
    }

    public function current(): ?PhpVersion
    {
        return parent::current();
    }

    /** @param mixed $offset */
    public function offsetGet($offset): PhpVersion
    {
        return parent::offsetGet($offset);
    }

    public function exists(PhpVersion $phpVersion): bool
    {
        foreach ($this->values as $value) {
            if ($value->getMajor() === $phpVersion->getMajor() && $value->getMinor() === $phpVersion->getMinor()) {
                return true;
            }
        }

        return false;
    }

    public function toString(): string
    {
        $versions = [];
        foreach ($this->values as $value) {
            $versions[] = $value->toString();
        }

        return implode(', ', $versions);
    }
}
