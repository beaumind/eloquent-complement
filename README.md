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
    
    public function user()
    {
        return $this->belongsTo('User');
    }
    
    public function answers()
    {
        return $this->hasMany('Answer');
    }

}
```
```php
class Answer extends Model
{
    .
    .
    .
}
```
```php
class User extends Model
{
    .
    .
    .
}
```
# Save Associated models
