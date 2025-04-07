# Magic Collection for Laravel

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

**Magic Collection** adds powerful features to Laravel Eloquent collections.  
It lets you call relationships directly on a collection of models, and includes an Artisan command to generate custom collection classes.

## ✨ Features

- Call relationships on a collection of models:  
  Example: `$users->blogs` (where $user is a collection)
- Automatically merges related results using `flatMap`
- Safe handling of empty collections
- Define custom collection classes per model
- Artisan command to generate collections: `php artisan make:collection`

---
## Installation

Via Composer

```bash
composer require winavin/magic-collection
```

## Usage

1. **Use the Trait on your models**
```php
use Winavin\Collections\UsesMagicCollections;

class User extends Model
{
    use UsesMagicCollections;
}
```
2. **(Optional) Create a custom collection for a model**

```php artisan make:collection```

This command creates a collection class in the App\Collections folder.
It will automatically extend the base collection and follow naming rules.

If the collection name matches your model name and path (like UserCollection for User Model), it will be used automatically.

But if you want to manually set it, you can do that in your model:
```php
class User extends Model
{
  ...
    protected function useCollection(): string
    {
        return MyCustomUserCollection::class;
    }
```

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/winavin/magic-collection.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/winavin/magic-collection.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/winavin/magic-collection/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/winavin/magic-collection
[link-downloads]: https://packagist.org/packages/winavin/magic-collection
[link-travis]: https://travis-ci.org/winavin/magic-collection
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/winavin
[link-contributors]: ../../contributors
