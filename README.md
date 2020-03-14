# ozioma-laminas

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

A Laminas PHP framework/Zend Framework 3 module for [Ozioma](https://ozioma.net/) API.

[![Ozioma](img/ozioma.png?raw=true "Ozioma")](https://ozioma.net/)

## Requirements
- Curl 7.34.0 or more recent (Unless using Guzzle)
- PHP 5.4.0 or more recent
- OpenSSL v1.0.1 or more recent

## Installation

Installation of OziomaLaminas uses composer. For composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

```bash
    $ composer require chibex/ozioma-laminas
```

Then add `Chibex\Ozioma` to your `config/modules.config.php`

Installation without composer is not officially supported, and requires you to install and autoload
the dependencies specified in the `composer.json`.

## IMPORTANT
This Laminas PHP framework/Zend Framework 3 module is a wrapper for [Ozioma PHP Library](https://github.com/chibex-tech/ozioma-php)

## Usage

Create `config/autoload/ozioma.global.php` then copy and paste below code into the file, replace your access key. See guide on how to generate project's access key and fund it [click here](https://ozioma.net/api/docs)

```php
    return [
        'ozioma' => [
            'third-party' => [
                'access-key' => 'YOUR ACCESS KEY HERE',
            ],
        ],
    ];
```

### 0. Prerequisites
Confirm that your server can conclude a TLSv1.2 connection to Ozioma's servers. Most up-to-date software have this capability. Contact your service provider for guidance if you have any SSL errors.

This module has `oziomaClient` controller plugin which can be access like this `$this->oziomaClient()` in your controllers. This controller plugin will return instance of `Chibex\Ozioma\Service\OziomaClientManager` service which implements all methods for invoking Ozioma API resources.

### 1. Checking your project units balance
Note that you can fund each of your projects with units separately and when project units exhausted it will not eat into your main balance. This method returns units balance for project access key suplied.

```php
    try {
        $response =  $this->oziomaClient()->getBalance();
        var_dump($response);

    } catch(\Chibex\Ozioma\Exception\ApiException $e){
        print_r($e->getResponseObject());
        die($e->getMessage());
    }
```

### 2. Initiate sending message
When you submit message for sending our server queue's the message for delivery and after delivery your callback url is called to notify your system/website that your message has been sent.

```php
    try {
        $response = $this->oziomaClient()->send(['sender' => 'php lib',
                                        'message' => 'it is awesome',
                                        'recipients' => '23470xxxxxxxx',
                                        'use_corporate_route' => true, // [true or false]
                                        'callback_url' => 'http://your-website/your-callback-url',  
                                        ]);
        var_dump($response);

    } catch(\Chibex\Ozioma\Exception\ApiException $e){
        print_r($e->getResponseObject());
        die($e->getMessage());
    }
```
#### send method parameters
- `sender` is your custom name/title for your message and is should not exceed 11 characters (space is also counted as character)
- `recipients` is the phone number(s) you are sending message to
- `message` is the content you want to send to your recipient(s)
- `use_corporate_route` cant either be true or false. Value 'true' means that you want your message delivers to Do-Not-disturb (DND) numbers for countries that has dnd policy
- `callback_url` When you submit message for sending our server queue's the message for delivery and after delivery your callback url is called to notify your system/website that your message has been sent. Then you can use the message id passed as query string to retrieve delivery details. This parameter is optional in case you don't want to receive callback

### 3. Fetching sent message details
When you submit message for sending an id is returned, you can use the returned id to pull the message details.

```php
    try {
        $response =  $this->oziomaClient()->fetchSentMessage($id);
        var_dump($response);

    } catch(\Chibex\Ozioma\Exception\ApiException $e){
        print_r($e->getResponseObject());
        die($e->getMessage());
    }
```

### 4. Fetching sent message extras
To get the recipients, units charged and delivery status of send a sent message, use this method the sent message id.

```php
    try {
        $response =  $this->oziomaClient()->fetchSentMessageExtras($id);
        var_dump($response);

    } catch(\Chibex\Ozioma\Exception\ApiException $e){
        print_r($e->getResponseObject());
        die($e->getMessage());
    }
```

### 5. Scheduling message
Most of the parameter are the same with `send` method above. Before scheduling message you need to include `time_zone_id`, call `$this->oziomaClient()->listTimeZones()` for the list of time zones and their ids.

```php
    try {
        $response = $this->oziomaClient()->schedule(['sender' => 'php lib',
                                    'message' => 'it is awesome',
                                    'recipients' => '23470xxxxxxxx',
                                    'use_corporate_route' => true,
                                    'callback_url' => 'http://your-website/your-callback-url',
                                    'extras' => [[
                                        'deliver_at' => '2019-07-23 10:10',
                                        'time_zone_id' => 2,
                                    ]]]);
        var_dump($response);

    } catch(\Chibex\Ozioma\Exception\ApiException $e){
        print_r($e->getResponseObject());
        die($e->getMessage());
    }
```

- `extras` accepts arrays of delivery times, in case you want your scheduled message to deliver at different times.
- `time_zone_id` You can call our time zone endpoint to get list of timezones and their ids. It's used to set at what timezone you want your scheduled message to delivery to your recipient(s)

### 7. Add Subscriber to your Newsletter list
To add subscriber from your system/website to your Newsletter list, first login to your Ozioma dashboard and create the newsletter list. Next call Newsletter `$this->oziomaClient()->newsletterList();` to pull your list with their ids

```php
    try {
        $response =  $this->oziomaClient()->addSubscriber([
                                    'id' => 2, //sms newsletter id
                                    'name' => 'Chibuike Mba',
                                    'phone_no' => '23470xxxxxxxx']);
        var_dump($response);

    } catch(\Chibex\Ozioma\Exception\ApiException $e){
        print_r($e->getResponseObject());
        die($e->getMessage());
    }
```

### 9. Add Subscribers to your Newsletter list
This is same as adding single subscriber but in this case you add multiple subscribers at once

```php
    try {
        $response =  $this->oziomaClient()->addBulkSubscribers([
                                        'id' => 2, //sms newsletter id
                                        'subscribers' => [[
                                            'name' => 'Izuchukwugeme Okafor',
                                            'phone_no' => '23470xxxxxxxx'
                                        ],[
                                            'name' => 'Franklin Nnakwe',
                                            'phone_no' => '23480xxxxxxxx'
                                        ]]]);
        var_dump($response);

    } catch(\Chibex\Ozioma\Exception\ApiException $e){
        print_r($e->getResponseObject());
        die($e->getMessage());
    }
```

### 10. Add Birthday Contact to your Birthday group
To add contact from your system/website to your birthday group, first login to your Ozioma dashboard and create the birthday group. Next call Birthday `$this->oziomaClient()->birthdayGroupList();` to pull your groups with their ids

```php
    try {
        $response =  $this->oziomaClient()->addBirthdayContactToGroup([
                                        'group_id' => 7, //birthday group id
                                        'name' => 'Dennis Okonnachi',
                                        'phone_no' => '23470xxxxxxxx',
                                        'day' => 9,
                                        'month_id' => 1,
                                    ]);
        var_dump($response);

    } catch(\Chibex\Ozioma\Exception\ApiException $e){
        print_r($e->getResponseObject());
        die($e->getMessage());
    }
```

### 12. Add Birthday Contacts to your Birthday group
This is same as adding single contact but in this case you add multiple contacts at once

```php
    try {
        $response =  $this->oziomaClient()->addBulkBirthdayContactsToGroup([
                                        'group_id' => 7, //birthday group id
                                        'contacts' => [[
                                            'name' => 'Caleb',
                                            'phone_no' => '23470xxxxxxxx',
                                            'day' => 9,
                                            'month_id' => 1,
                                        ]]]);
        var_dump($response);

    } catch(\Chibex\Ozioma\Exception\ApiException $e){
        print_r($e->getResponseObject());
        die($e->getMessage());
    }
```

## . Closing Notes

Currently, we support: 'message', 'newsletter', 'birthday', 'month', 'balance' and 'timezones'. Check
our API reference([link-ozioma-api-reference][link-ozioma-api-reference]) for the methods supported. To specify parameters, send as an array.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) and [CONDUCT](.github/CONDUCT.md) for details. Check our [todo list](TODO.md) for features already intended.

## Security

If you discover any security related issues, please email chibexme@gmail.com instead of using the issue tracker.

## Credits

- [Chibex Technologies][link-author]
- [Chibuike Mba](https://github.com/chibexme)
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/chibex/ozioma-laminas.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/chibex/ozioma-laminas.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/chibex/ozioma-laminas
[link-downloads]: https://packagist.org/packages/chibex/ozioma-laminas
[link-author]: https://github.com/chibex-tech
[link-contributors]: ../../contributors
[link-ozioma-api-reference]: https://ozioma.net/api/docs
