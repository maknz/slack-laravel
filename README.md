# Slack for Laravel

This package allows you to use [Slack for PHP](https://github.com/razorpay/slack) easily and elegantly in your Laravel 4 or 5 app. Read the instructions below to get setup, and then head on over to [Slack for PHP](https://github.com/razorpay/slack) for usage details.

## Requirements

Laravel 4 or 5.

## Installation

You can install the package using the [Composer](https://getcomposer.org/) package manager. You can install it by running this command in your project root:

```sh
composer require razorpay/slack-laravel
```

Then [create an incoming webhook](https://my.slack.com/services/new/incoming-webhook) for each Slack team you'd like to send messages to. You'll need the webhook URL(s) in order to configure this package.

## Laravel 5

Add the `Razorpay\Slack\Laravel\ServiceProvider` provider to the `providers` array in `config/app.php`:

```php
'providers' => [
  Razorpay\Slack\Laravel\ServiceProvider::class,
],
```

Then add the facade to your `aliases` array:

```php
'aliases' => [
  ...
  'Slack' => Razorpay\Slack\Laravel\Facade::class,
],
```

Finally, publish the config file with `php artisan vendor:publish`. You'll find it at `config/slack.php`.

## Laravel 4

Add the `Razorpay\Slack\Laravel\ServiceProvider` provider to the `providers` array in `app/config.php`:

```php
'providers' => [
  ...
  'Razorpay\Slack\Laravel\ServiceProvider',
],
```

Then add the facade to your `aliases` array:

```php
'aliases' => [
  ...
  'Slack' => 'Razorpay\Slack\Laravel\Facade',
],
```

Finally, publish the config file with `php artisan config:publish razorpay/slack`. You'll find the config file at `app/config/packages/razorpay/slack-laravel/config.php`.

## Configuration

The config file comes with defaults and placeholders. Configure at least one team and any defaults you'd like to change.

## Usage

The Slack facade is now your interface to the library. Any method you see being called an instance of `Razorpay\Slack\Client` is available on the `Slack` facade for easy use.

Note that if you're using the facade in a namespace (e.g. `App\Http\Controllers` in Laravel 5) you'll need to either `use Slack` at the top of your class to import it, or append a backslash to access the root namespace directly when calling methods, e.g. `\Slack::method()`.

```php
// Send a message to the default channel
Slack::send('Hello world!');

// Send a message to a different channel
Slack::to('#accounting')->send('Are we rich yet?');

// Send a private message
Slack::to('@username')->send('psst!');
```

Now head on over to [Slack for PHP](https://github.com/razorpay/slack) for more examples, including attachments and message buttons.

# Migrating to 2.0
Version 2.0 adds support for multiple slack clients. For migrating 1.X to 2.0, nest all the configuration properties inside `defaults` key in the configuration file. Configuration for additional clients can be specified in the `clients` property.

```
[
    'is_slack_enabled'  =>  true,
    'defaults'    =>  [
        // default slack client configuration.
    ],
    
    clients =>  [
        // Additional slack clients configuration
        'client1'   =>  [
            
        ]
    ]
]
```

