### Install via Composer
`composer require thesilvacesar/dbimport`

### Install manually

* Download the project
* Import the lib folder for your project
* Import the files of class using `require_once 'lib/DBImport/class.db-import.php';`

### Sample usage
An sample of use the class.

```php
require_once 'vendor/autoload.php';
//require_once 'lib/DBImport/class.db-import.php';

// Instance the class
$DBImport   =   new DBImport([
    'host'	=>	'YOUR_HOST', // Host of database
    'user'	=>	'YOUR_USERNAME', // User of database
    'pass'	=>	'YOUR_PASSWORD', // Password of database
    'file'	=>	'YOUR_FILE', // File that be will imported
    'db'	=>	'YOUR_DATABASE', // Database for import of file
]);

$DBImport->execute(); // Execute the importation file
```
