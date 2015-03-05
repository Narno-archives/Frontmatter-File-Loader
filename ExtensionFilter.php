<?php
/*
 * Copyright (c) Arnaud Ligny <arnaud@ligny.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPoole\Loader;

class ExtensionFilter extends \FilterIterator
{
    protected $extFilter = null;

    /**
     * Constructor.
     *
     * @param \Iterator $iterator
     * @param string $extFilter
     */
    public function __construct(\Iterator $iterator, $extFilter='md')
    {
        parent::__construct($iterator);
        $this->extFilter = $extFilter;
    }

    /**
     * Validator.
     *
     * @return bool
     */
    public function accept()
    {
        $fileInfo = $this->getInnerIterator()->current();

        if (!$fileInfo instanceof SplFileInfo) {
            return false;
        }
        if (!$fileInfo->isFile()) {
            return false;
        }
        if (!is_null($this->extFilter)) {
            if ($fileInfo->getExtension() == $this->extFilter) {
                return true;
            }
        }
        return false;
    }
}