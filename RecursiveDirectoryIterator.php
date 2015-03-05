<?php
/*
 * Copyright (c) Arnaud Ligny <arnaud@ligny.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPoole\Loader;

use Symfony\Component\Finder;

class RecursiveDirectoryIterator extends Finder\Iterator\RecursiveDirectoryIterator
{
    /**
     * Return an instance of SplFileInfo with support for relative paths.
     *
     * @return SplFileInfo File information
     */
    public function current()
    {
        return new SplFileInfo(parent::current()->getPathname(), $this->getSubPath(), $this->getSubPathname());
    }
}