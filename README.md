# eloquent-complement
add some usable features to laravel eloquent for laravel 5+.
# Installation

Simply Run the Composer require comand.

```
composer require beaumind/eloquent-complement
```
```php
use Beaumind\EloquentComplement\EloquentComplement;

class Question extends Model
{
    use EloquentComplement;

    public function answers()
    {
        return $this->hasMany('Answer');
    }

}
```
```php
class Answer extends Model
{
    public function question()
    {
        return $this->belongsTo('Question');
    }

}
```
# Save Associated models
