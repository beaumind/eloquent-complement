# eloquent-complement
add some usable features to laravel eloquent for laravel 5+.
# Installation

Simply Run the Composer require comand.

```
composer require beaumind/eloquent-complement
```
```php
use Beaumind\EloquentComplement\EloquentComplement;

class Post extends \Eloquent
{
    use EloquentComplement;

    /**
     * Searchable columns.
     *
     * @var array
     */
    public $searchable_fields = [
      title,
      body,
      user.name,
      uesr.email
    ];


    public function user()
    {
        return $this->belongsTo('User');
    }

}
```
