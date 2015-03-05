<?php
/*
 * Copyright (c) Arnaud Ligny <arnaud@ligny.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPoole\Loader;

Use Symfony\Component\Finder;

class SplFileInfo extends Finder\SplFileInfo
{
    protected $frontmatter;
    protected $body;

    /**
     * Constructor.
     *
     * @param string $file             The file name
     * @param string $relativePath     The relative path
     * @param string $relativePathname The relative path name
     */
    public function __construct($file, $relativePath, $relativePathname)
    {
        parent::__construct($file, $relativePath, $relativePathname);
        $this->parse();
    }

    /**
     * Returns the front matter of the contents of the file.
     *
     * @return array
     */
    public function getFrontmatter()
    {
        return $this->frontmatter;
    }

    /**
     * Returns the body of the contents of the file.
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Parse the contents of the file.
     *
     * Example:
     * <!--
     * title = Title
     * -->
     * Lorem Ipsum.
     *
     * @return $this
     * @throws \Exception
     */
    private function parse()
    {
        if ($this->isFile()) {
            if (!$this->isReadable()) {
                throw new \Exception('Cannot read file');
            }
            // parse front matter
            preg_match(
                '/^'
                . '(<!--|---|\+++){1}[\r\n|\n]*' // $matches[1] = front matter open
                . '(.*)[\r\n|\n]+'               // $matches[2] = front matter
                . '(-->|---|\+++){1}[\r\n|\n]*'  // $matches[3] = front matter close
                . '(.+)'                         // $matches[4] = body
                . '/s',
                $this->getContents(),
                $matches
            );
            // if not front matter, set body only
            if (!$matches) {
                $this->body = $this->getContents();
                return $this;
            }
            $this->frontmatter  = $matches[2];
            $this->body         = $matches[4];
        }
        return $this;
    }
}