# Property Decider

Property Decider helps you making a decision about your next property move by sharing property details between your housemates/partners, voting, and commenting the property.

## Usage

**Please note:** Only UK property sites are supported.

Register to Property Decider, grab a [Zoopla](https://www.zoopla.co.uk/), [Rightmove](https://rightmove.co.uk/), or [On The Market](https://www.onthemarket.com/) link to a property, paste it into Property Decider, and we will fetch the property details for you.

You can then invite your partners or housemates to a group to property decider, and you can then start voting whether or not you like the property, and start the discussion with comments.

## Development

### Requirements

- PHP 8.0: on macOS you can install it via Homebrew with `brew install php@8.0`
- Composer v2: check the Composer website for [instructions](https://getcomposer.org/download/)
- Postgres v13: on macOS you can install it via Homebrew with `brew install postgres@13`
- Node v14: you can install it using nvm via `nvm install 14.17.1`
- Yarn: you can install it via `npm i -g yarn`

### Setup

```bash
composer install
yarn
php artisan migrate --seed
```

### Server

```bash
php artisan serve
```

### CI

Some handy composer scripts are available to help with code quality:

- `composer run-script check-style`: lint PHP files using [PHP CS Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer), and blade files using [TLint](https://github.com/tighten/tlint)
- `composer run-script stan`: runs static analysis on PHP files using [Psalm](https://github.com/vimeo/psalm/) and its [Laravel plugin](https://github.com/psalm/psalm-plugin-laravel)
- `composer run-script test`: runs unit and feature tests using PHPUnit and Laravel parallel testing feature via Paratest
- `composer run-script fix-style`: fix PHP files style via PHP CS Fixer
- `composer run-script ci`: runs the `check-style`, `stan`, and `test` scripts sequentially

Additionally CI is run using GitHub Actions
