<?php
/*
 * Copyright (c) Arnaud Ligny <arnaud@ligny.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPoole\Loader;

use Symfony\Component\Finder;

class Loader
{
    protected $dir;
    protected $ext = array();

    /**
     * Constructor.
     *
     * @param $dir
     */
    public function __construct($dir)
    {
        if (!is_dir($dir)) {
            throw new \InvalidArgumentException('Expected a valid directory name');
        }
        $this->dir = $dir;
        return $this;
    }

    /**
     * Set extension file to filter.
     *
     * @param $ext
     * @return $this
     */
    public function ext($ext)
    {
        $this->ext[] = $ext;
        return $this;
    }

    /**
     * Loads a directory.
     *
     * @return ExtensionFilter|RecursiveDirectoryIterator|\RecursiveIteratorIterator
     */
    public function load()
    {
        $iterator = new RecursiveDirectoryIterator(
            $this->dir,
            \FilesystemIterator::UNIX_PATHS
            |\RecursiveIteratorIterator::SELF_FIRST
        );
        $iterator = new \RecursiveIteratorIterator($iterator);

        // Applies extension filter
        if (count($this->ext) !== 0) {
            foreach ($this->ext as $ext) {
                $iterator = new ExtensionFilter($iterator, $ext);
            }
        }

        return $iterator;
    }
}