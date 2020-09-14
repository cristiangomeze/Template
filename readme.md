# Template

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is a wrapper to use the [phpword template](https://phpword.readthedocs.io/en/latest/templates-processing.html), which allows you to have the final document rendered in the browser. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require thepany/template
```

## Usage

```php

use Thepany\Template\Template;

$values = [
          'firstname' => 'John',
          'lastname' => 'Doe'
];

$valuesImages = [
    'company_logo' => [
        'path' => '/home/user/wallpaper/wallpaper.png',
        'width' => 200, 
        'height' => 200, 
        'ratio' => false
    ]
];

return Template::make('/home/user/any_word_document.docx')
        ->addValues($values)
        ->addImages($valuesImages)
        ->preview();
```

```php

use Thepany\Template\Filters\Filter;

$values = [
    [
        'key' => 'fecha',
        'value' => '2019-08-08',
        'filters' => ['DateWords'] // DateWords, NumberWords, NumericFormat:2, DateFormat:LLLL
    ]
];

Filter::make($values)->toArray();

// 'fecha' => 'Ocho (8) Días del mes de Agosto del año Dos Mil Diecinueve (2019)'

```

### To enable the Dominican currency we must modify the file Locale / Es.php in kwn / number-to-words
```text
 'DOP' => [['peso dominicano', 'pesos dominicanos'], ['centavo', 'centavos']],
```
## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [author name][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/thepany/template.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/thepany/template.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/thepany/template/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/thepany/template
[link-downloads]: https://packagist.org/packages/thepany/template
[link-travis]: https://travis-ci.org/thepany/template
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/thepany
[link-contributors]: ../../contributors
