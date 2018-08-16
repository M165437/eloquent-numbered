# Numbered Eloquent Models

This package sequentially numbers your Eloquent model instances, constrained by a [scope](https://laravel.com/docs/master/eloquent#local-scopes) `numbered` that you customize.

On every `created`, `deleted`, `updated` and `restored` event, the models in the scope get renumbered.

When the numbering happens, the model that raised the event is injected into the method and can be used to further limit the scope.

Retrieved models will include a `number` attribute (customizable).

What is this good for? Rankings, positioning, row numbers, the fifth of something – when calculating the number ”on-the-fly“ is not an option.

## Installation

Install the package via composer:

```bash
composer require m165437/eloquent-numbered
```

## Usage

Add the trait `M165437\EloquentNumbered\Numbered` to your model:

```php
use Illuminate\Database\Eloquent\Model;
use M165437\EloquentNumbered\Numbered;

class MyModel extends Model
{
    use Numbered;
    ...
}
```

Add a `number` field to your model migration:

```php
Schema::create('my_model', function (Blueprint $table) {
    $table->integer('number')->nullable();
    ...
});
```

If you would like to name this field / attribute differently, set the constant `NUMBER` on the model accordingly, e.g.

```php
const NUMBER = 'rank';
```

## Configuration

The default numbering scope (included with the trait) sorts the model instances by date in ascending order:

```php
public function scopeNumbered($query, $model = null)
{
    return $query->oldest();
}
```

If you want to customize the scope, add it to your model.

When the numbering happens, the model that raised the event is injected into the method and can be used to further limit the scope, e.g. numbering the model instances for each user individually:

```php
public function scopeNumbered($query, $model = null)
{
    return $query->oldest()
        ->when($model, function ($query, $model) {
            return $query->where('user_id', $model->user_id)
        });
}
```

## Tests

The package contains some integration/smoke tests, set up with Orchestra. The tests can be run via phpunit.

```bash
vendor/bin/phpunit
```

## Contributing

Thank you for considering contributing to this package! Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License

This package is licensed under the MIT License (MIT). Please see the [LICENSE](LICENSE.md) file for more information.
