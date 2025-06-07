# Magic Collection for Laravel

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

**Magic Collection** adds powerful features to Laravel Eloquent collections.  
It lets you call model relationships directly on a collection of models, and includes an Artisan command to generate
custom collection classes.

## ✨ Features

- Call relationships on a collection of models:  
  Example: `$users->blogs` (where $user is a collection)
- Automatically merges related results using `flatMap`
- Safe handling of empty collections
- Define custom collection classes per model
- Artisan command to generate collections: `php artisan make:collection`

## Uses

Insted of doing something like below:

In below example, We considerd that ```User``` model has ```blogs``` ralationship method defined.

```php
$users = User::get();
$blogs = collect();

foreach($users as $user)
{
    $blogs = $blogs->concat($user->blogs);
}
```

OR

```php
$blogs = User::get()->flatMap(fn ($user) => $user->blogs ?? []);
```

now you can do this directly on ```$users```

```php
$blogs = User::get()->blogs();
```

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

If the collection name matches your model name and path (like YourModelCollection for YourModel Model), it will be used
automatically.

You can set any other Collection::class name in your model:

```php
class YourModel extends Model
{
    
    protected function useCollection(): string
    {
        return \App\Collections\CustomYourModelCollection::class;
    }
```

Absolutely! Here's a **"Known Errors"** section in proper Markdown format for your `README.md`, including clear steps to
resolve trait method collisions (like the one with `newCollection()`):

---

## 🐞 Known Errors

### ❌ Trait method collision: `newCollection()`

You may see this error if you're using another trait or package (like `HasRecursiveRelationships`) that also defines a
`newCollection()` method:

```
Trait method Winavin\MagicCollection\Traits\UsesMagicCollections::newCollection has not been applied as App\Models\YourModel::newCollection, because of collision with Other Trait's newCollection method.
```

---

### ✅ How to Fix It

If your model needs to use both `MagicCollection` and another custom collection (like one from another package), follow
these steps:

---

#### 1. Generate a Custom Collection

```bash
php artisan make:collection YourModelCollection
```

This creates `App\Collections\YourModelCollection`.

---

#### 2. Change the Collection's Base Class

In your new collection file, replace:

```php
use Winavin\MagicCollection\Collections\BaseCollection;

class YourModelCollection extends BaseCollection
```

**with the class from the conflicting package**, for example:

```diff
- use Winavin\MagicCollection\Collections\BaseCollection;
+ use Staudenmeir\LaravelAdjacencyList\Eloquent\Collection as AdjacencyCollection;
+ use Winavin\MagicCollection\Collections\Trait\BaseCollectionTrait;

- class YourModelCollection extends BaseCollection
+ class YourModelCollection extends AdjacencyCollection
{
+    use BaseCollectionTrait;

    // MagicCollection features + AdjacencyCollection features
}
```

---

#### 3. Define `newCollection()` in Your Model and remove Trait

In your model (e.g., `App\Models\YourModel`), override the method:

```diff
- use Winavin\Collections\UsesMagicCollections;

class YourModel extends Model
{
-    use UsesMagicCollections;

+    public function newCollection(array $models = [])
+    {
+       return new \App\Collections\YourModelCollection($models);
+    }
}
```

This will use your custom collection with both features.

---

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
