## Almas Exchange Model package

#### How to install

```bash
composer require almas-exchange/exchange-model
```

#### Register the Service Provider in bootstrap/app.php for <code>Lumen</code>:

```php
$app->register(ExchangeModel\Providers\ExchangeModelServiceProvider::class);
```

#### Publish configuration files:

```bash
php artisan vendor:publish --tag=exchange-model
```
