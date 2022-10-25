# Craft Data

Automatically convert POST data over to strongly typed data objects. Attaching an attribute to your controller method is all it takes to do the conversion.

```php
class EntryController extends Controller
{
    #[BodyParams(EntryUpdateParams::class)]
    function actionUpdate()
    {
        // Now $this->getData() will return an `EntryUpdateParams` with all the
        // data copied over from the POST in to the class
    }
}
```

The data object uses public properties and PHP type hints to map everything. See [markhuot/data](https://github.com/markhuot/data) for more detail on mapping.

```php
class EntryUpdateParams
{
    public int $elementId;
    public ?string $title;
    public ?string $slug;

    function getElement()
    {
        return \Craft::$app->elements->getElementById($this->elementId);
    }
}
```

All validation rules fromm [markhuot/data](https://github.com/markhuot/data) work as well so you can ensure specific fields match the validation rules you expect.

```php
use Symfony\Component\Validator\Constraints as Assert;

class EntryUpdateParams
{
    #[Assert\NotNull]
    public int $elementId;

    #[Assert\NotEmpty]
    public string $title;

    #[Assert\Regex('/[a-z]0-9_-/i')]
    public ?string $slug;

    function getElement()
    {
        return \Craft::$app->elements->getElementById($this->elementId);
    }
}
```