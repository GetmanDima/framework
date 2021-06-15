# Framework
## Simple php framework

Framework is an opensource project. You can freely create projects based on it

- Simple development
- Uses PHP 7.4
- Uses [Webpack](https://webpack.js.org/)

## Features

- MVC
- Router
- Middleware
- Work with database (migrations and seeders)
- Work with email
- Validation
- Caching
- Testing

## Tech

Framework uses a number of open source projects to work properly:

- [Composer](https://getcomposer.org/) - A Dependency Manager for PHP
- [nikic/fast-route](https://github.com/nikic/FastRoute) - Fast request router for PHP
- [rakit/validation](https://github.com/rakit/validation) - PHP Standalone Validation Library
- [Phinx](https://phinx.org/) - Simple PHP Database Migrations
- [PHPMailer](https://github.com/PHPMailer/PHPMailer) - A full-featured email creation and transfer class for PHP
- [illuminate/database](https://github.com/illuminate/database) - Database toolkit for PHP
- [PHPUnit](https://phpunit.de/) - Testing framework for PHP to Markdown converter
- [fzaninotto/faker](https://github.com/fzaninotto/Faker) - PHP library that generates fake data for you
- [Npm](https://www.npmjs.com/) - A package manager for JavaScript
- [Webpack](https://webpack.js.org/) - A module bundler for JavaScript
- [css-loader](https://github.com/webpack-contrib/css-loader) - Css loader plugin
- [mini-css-extract-plugin](https://github.com/webpack-contrib/mini-css-extract-plugin) - This plugin extracts CSS into separate files
- [@popperjs/core](https://github.com/popperjs/popper-core) - Tooltip and Popover Positioning Engine
- [Bootstrap](https://getbootstrap.com/) - CSS framework
- [JQuery](https://jquery.com/) - A JavaScript library designed to simplify HTML DOM tree
- [popper.js](https://popper.js.org/) - Tooltip and Popover Positioning Engine

## Installation

Framework requires [Composer](https://getcomposer.org/) to run.

Download this project. Run:
```sh
composer install
```
If you want basic css and js run (required [Npm](https://www.npmjs.com/)):

```sh
npm install
npm run build
```

Fill APP_NAME and APP_URL with the appropriate values in config/constants.php

## Database

The database connection configuration - config/db.php
Create new database with charset='utf8' and collation='utf8_unicode_ci'

If you want basic user table for registration and login run:
```sh
php vendor/bin/phinx migrate
```

If you want to fill user table with data run:
```sh
php vendor/bin/phinx seed:run
```

#### Migrations

Use [Phinx](https://phinx.org/).
[Documentation](https://book.cakephp.org/phinx/0/en/index.html)

Migrations folder - database/migrations
Basic commands:

Create new migration (NewMyMigration):
```sh
php vendor/bin/phinx create CreateNewTable
```

Migrate:
```sh
php vendor/bin/phinx migrate
```

Rollback:
```sh
php vendor/bin/phinx rollback
```

Example migration:

```php
<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateNewTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('new');

        $table->addColumn('field', 'string');
        
        $table->create();
    }
}

```
#### Seeders

Use [Phinx](https://phinx.org/) for seeders.
Use [fzaninotto/faker](https://github.com/fzaninotto/Faker) for data.
[Phinx Documentation](https://book.cakephp.org/phinx/0/en/index.html)

Seeders folder - database/seeders
Basic commands:

Create new seeder (NewSeeder):
```sh
php vendor/bin/phinx seed:create NewSeeder
```

Run seeders:
```sh
php vendor/bin/phinx seed:run
```

Example seeder:

```php
<?php


use Phinx\Seed\AbstractSeed;

class NewSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $data[] = ['field' => $faker->sentence];
        $this->table('new')->insert($data)->save();
    }
}
```

## Models

Use [illuminate/database](https://github.com/illuminate/database). For models - Eloquent.
[Documentation](https://laravel.com/docs/8.x/eloquent)

Models folder - App/Models

## Controllers

Controllers folder - App/Controllers

Example Controller:

```php
<?php


namespace App\Controllers;


class ExampleController extends AppController
{

}
```

#### Render view

In Controller action use render method. Example:

```php
<?php


namespace App\Controllers;


class ExampleController extends AppController
{
    public function index()
    {
        $title = 'Example Index';

        $this->render(
            'index',
            'templates/example',
            compact('title')
        );
    }
}
```

Render view "index" with template "example". Passes the variable title.
Method render in Controller is a wrapper for View::render.
Views folder - public/views.
Template "example":

```html
<html>
<head>
    <title><?=$title?></title>
</head>
<body>
    <?=$view?>
</body>
</html>
```
#### Validation
Use [rakit/validation](https://github.com/rakit/validation).

Example controller validation:

```php
<?php


namespace App\Controllers;


use Rakit\Validation\Validation;

class ExampleController extends AppController
{
    protected string $failRedirectTo = '/';
    
    /**
     * @return Validation
     */
    protected function validation(): Validation
    {
        return $this->request->validation(['post'], [
            'field' => ['required', 'min:8', 'max:255'],
        ]);
    }

    public function index()
    {
        $this->validate();
        $title = 'Example Index';

        $this->render(
            'home',
            'templates/default',
            compact('title')
        );
    }

    public function anotherActionWithValidation()
    {
        $validation = $this->request->validation(['post'], [
            'anotherField' => ['required', 'min:8', 'max:255'],
        ]);
        
        $this->validate($validation, '/another');
    }
}
```

$this->validate() is wrapper for Rakit\Validation\Validation::validate
$failRedirectTo - link to redirect if validation fail
Method validation() - Basic validation for validate()
Action anotherActionWithValidation() use own validation and validation fail redirect link.
##### Validation rules
The validation rules configuration - config/validation_rules.php.

Example Validation rule:
```php
'equalRule' => \App\ValidationRules\EqualRule::class
```
```php
<?php


namespace App\ValidationRules;


use Rakit\Validation\Rule;


/**
 * Rule: 'equalRule:field'.
 * True if field === value
 * 
 * Class ExampleRule
 * @package App\ValidationRules
 */
class EqualRule extends Rule
{
    protected $message = ":attribute :value error";

    protected $fillableParams = ['field'];

    /**
     * @throws \Rakit\Validation\MissingRequiredParameterException
     */
    public function check($value): bool
    {
        // make sure required parameters exists
        $this->requireParameters(['field']);

        // getting parameters
        $field = $this->parameter('field');
        
        return $field === $value;
    }
}
```
#### Middleware

The middleware configuration - config/middleware.php.
Middleware folder - app/Middleware
Example Middleware:
```php
'example' => \App\Middleware\ExampleMiddleware::class
```
```php
<?php


namespace App\Middleware;


use Core\Middleware\Middleware;
use Core\Request;

class ExampleMiddleware extends Middleware
{
    public function handle(Request $request)
    {
        if ($request->session()->get('example')) {
            redirect('/example');
        }

        $this->next();
    }
}
```

Use in controller:

```php
<?php


namespace App\Controllers;


class ExampleController extends AppController
{
    public function __construct()
    {
        $this->middleware(['example'], 'index');
    }
    
    public function index()
    {
        echo 'Index use middleware';
    }
    
    public function notUseMiddlewareAction()
    {
        echo 'No middleware for this action';
    }
}
```

## Caching

Core\Cache - Work with cache.
Core\Request contains cache instance.

Example of using cache in controller:

```php
<?php


namespace App\Controllers;


use App\Models\DataModel;

class ExampleController extends AppController
{
    public function index()
    {
        $title = 'Data';
        $cache = $this->request->cache();
        $data = $cache->get(1, 'ExampleController', 'index');

        if ($data === null) {
            $data = DataModel::all();
            $cache->set(1, 'UserController', 'index', $data);
        }

        $this->render(
            'users',
            'templates/default',
            compact('title', 'data')
        );
    }
}
```

## Session and Cookie
Core\Session - Work with session.
Core\Cookie - Work with cookie.
Core\Request contains Session and Cookie instance.

Example of using Session and Cookie methods in controller:

```php
<?php


namespace App\Controllers;


use Core\SessionMessage;

class ExampleController extends AppController
{
    use SessionMessage;

    public function useSession()
    {
        $session = $this->request->session();

        $session->set('varName', 'value');

        if ($session->has('varName')) {
            $var = $session->get('varName');
        }

        $session->setFlash('flashName', 'value');

        if ($session->hasFlash('flashNmae')) {
            $flash = $session->getFlash('flashName');
        }

        $session->remove('var');

        //session message
        $this->setAlertMessage('success', 'success message');
        $alertMessage = $this->getAlertMessage();
        $formErrors = $this->getFormErrors();
    }

    public function useCookie()
    {
        $cookie = $this->request->cookie();

        $cookie->set('varName', 'value');

        if ($cookie->has('varName')) {
            $var = $cookie->get('varName');
        }

        $cookie->remove('varName');
        $allCookies = $cookie->all();
    }
}
```

## Router
\Core\Router\Router is a wrapper for [nikic/fast-route](https://github.com/nikic/FastRoute)
Route list - routes/routes.php.

Example of routes declaration:

```php
$router->get('/get', 'ExampleController@getAction');
$router->post('/post', 'ExampleController@postAction');
$router->add('GET', '/add', 'ExampleController@addGetAction');
$router->add('POST', '/add', 'ExampleController@addPostAction');
```

## Exceptions
Exception handlers list - config/exception_handlers.php

Example of exception handler:
```php
<?php

return [
    'production' => [
        400 => 'App\\Exceptions\\ExceptionHandler@productionError400'
    ],
    'development' => [
        400 => 'App\\Exceptions\\ExceptionHandler@developmentError400'
    ]
];
```
```php
<?php


namespace App\Exceptions;


use Core\View;

class ExceptionHandler
{
    public function __construct()
    {
        http_response_code(400);
    }

    public function production()
    {
        $title = "Error 400";

        View::render(
            'exceptions/production/error400',
            'templates/error',
            ['title' => $title]
        );
    }

    /**
     * @param array $error
     */
    public function development(array $error)
    {
        $title = "Error 400";

        View::render(
            'exceptions/development/error400',
            'templates/error',
            ['title' => $title, 'error' => $error]
        );
    }
}
```
Using:
```php
throw new \Exception('Error 400. Something wrong', 400);
```

## Email

Use [PHPMailer](https://github.com/PHPMailer/PHPMailer).
Core\Mailer is wrapper for PHPMailer\PHPMailer\PHPMailer;
Mail configuration - config/mail.php.


Example controller action that sending email:

```php
<?php


namespace App\Controllers;


use Core\Mailer;

class ExampleController extends AppController
{
    public function index()
    {
        $recipientEmail = 'email@example.loc';
        $isHtml = false;
        $subject = 'subject';
        $body = 'text';
        
        $mail = new Mailer();
        $mail->setMessageData($isHtml, $subject, $body);
        $mail->send($recipientEmail);
    }
}
```

## Testing

Use [PHPUnit](https://phpunit.de/).
[Documentation](https://phpunit.readthedocs.io/en/9.5/)
Tests folder - tests.

Test run example.
```sh
php vendor/bin/phpunit tests
```

## Css and Js
Ready css and js contains in public folder. 
You can skip using [npm](https://www.npmjs.com/) and save the files in a public directory.

If you want to use [npm](https://www.npmjs.com/) and [webpack](https://webpack.js.org/):
Css and js contains in resources. 
New css and js files need to be included in app.js.

Framework supports the following commands:
```sh
npm run build
```
To compile.
```sh
npm run watch
```
To watch changes and compile.

## License

MIT


