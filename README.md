# index-repo

This is a simple `index.php` for repo-like websites

In your subfolders just add index.php like : 

```php
<?php

$ROOT_DIR = $_SERVER["DOCUMENT_ROOT"];
require_once "$ROOT_DIR/index.php";
```
