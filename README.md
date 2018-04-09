# Spur PHP SDK

This package provides a PHP SDK for the [Spur](https://spurjobs.com/) API.

## Laravel Example

This package uses Laravel's auto discovery feature. To install it, simply add it to your `composer.json` file. You will also need to set two configuration settings in `config/services.php`:

```php
'spur' => [
    'url' => env('SPUR_URL'),
    'secret' => env('SPUR_SECRET'),
],
```

Once that is setup, you can use the `Spur` facade:

```php
use Spur\Vendor\Laravel\Spur;
use Spur\SpurValidationException;

try {
    $place = Spur::createPlace([
        'name' => 'Montgomery Public Schools',
        'address' => '307 South Decatur Street',
        'city' => 'Montgomery',
        'region' => 'AL',
        'postal_code' => '36104',
        'latitude' => '32.373982',
        'longitude' => '-86.3041642',
    ]);
} catch (SpurValidationException $e) {
    // Handle errors using $e->getErrors()
}
```
