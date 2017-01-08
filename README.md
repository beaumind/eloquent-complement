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
    ...
}
```
```php
class User extends Model
{
    ...
}
```
# Save Associated models
you can now save question and related models in one step. it is atomic and it will role back on failure. also it fill foreign keys automatically.
```php
$question['body'] = 'some question body';

$question['user']['name'] = 'joe';
$question['user']['username'] = 'joe_m';
...

$question['answers']['body'] = 'some answer body';
$question['answers']['is_correct'] = true;

```
now save in database.
```php
(New Question())->saveAssociated($question, ['user','answers']);
```

