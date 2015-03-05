Locates ```md``` files, parses contents to exposes the front matter (and the body) in the SplFileInfo object.

```php
require_once 'vendor/autoload.php';

$loader = new \PHPoole\Loader\Loader('./test/content');
$files = $loader
    ->ext('md')
    ->load();

foreach ($files as $file) {
    /* @var $file \PHPoole\Loader\SplFileInfo */
    echo $file->getFrontmatter() . "\n";
    echo $file->getBody() . "\n";
}
```
