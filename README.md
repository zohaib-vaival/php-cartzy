# PHP Cartzy SDK


PHPCartzy is a simple SDK implementation of Cartzy API. It helps accessing the API in an object oriented way. 

## Installation
Install with Composer
```shell
composer require zohaib-vaival/php-cartzy
```

### Requirements
PHPCartzy uses curl extension for handling http calls. So you need to have the curl extension installed and enabled with PHP.
>However if you prefer to use any other available package library for handling HTTP calls, you can easily do so by modifying 1 line in each of the `get()`, `post()`, `put()`, `delete()` methods in `PHPCartzy\HttpRequestJson` class.

## Usage

You can use PHPCartzy in a pretty simple object oriented way. 

#### Configure CartzySDK
If you are using your own private API, provide the ApiKey and Password. 

```php
$config = array(
    'ShopUrl' => 'yourshop.cartzy.com',
    'ApiKey' => '***YOUR-PRIVATE-API-KEY***',
    'Password' => '***YOUR-PRIVATE-API-PASSWORD***',
);

PHPCartzy\CartzySDK::config($config);
```

For Third party apps, use the permanent access token.

```php
$config = array(
    'ShopUrl' => 'yourshop.cartzy.com',
    'AccessToken' => '***ACCESS-TOKEN-FOR-THIRD-PARTY-APP***',
);

PHPCartzy\CartzySDK::config($config);
```
##### How to get the permanent access token for a shop?
There is a AuthHelper class to help you getting the permanent access token from the shop using oAuth. 

1) First, you need to configure the SDK with additional parameter SharedSecret

```php
$config = array(
    'ShopUrl' => 'yourshop.cartzy.com',
    'ApiKey' => '***YOUR-PRIVATE-API-KEY***',
    'SharedSecret' => '***YOUR-SHARED-SECRET***',
);

PHPCartzy\CartzySDK::config($config);
```

2) Create the authentication request 

> The redirect url must be white listed from your app admin as one of **Application Redirect URLs**.

```php
//your_authorize_url.php
$scopes = 'read_products,write_products,read_script_tags,write_script_tags';
//This is also valid
//$scopes = array('read_products','write_products','read_script_tags', 'write_script_tags'); 
$redirectUrl = 'https://yourappurl.com/your_redirect_url.php';

\PHPCartzy\AuthHelper::createAuthRequest($scopes, $redirectUrl);
```

> If you want the function to return the authentication url instead of auto-redirecting, you can set the argument `$return` (5th argument) to `true`.

```php
\PHPCartzy\AuthHelper::createAuthRequest($scopes, $redirectUrl, null, null, true);
```

3) Get the access token when redirected back to the `$redirectUrl` after app authorization. 

```php
//your_redirect_url.php
PHPCartzy\CartzySDK::config($config);
$accessToken = \PHPCartzy\AuthHelper::getAccessToken();
//Now store it in database or somewhere else
```

> You can use the same page for creating the request and getting the access token (redirect url). In that case just skip the 2nd parameter `$redirectUrl` while calling `createAuthRequest()` method. The AuthHelper class will do the rest for you.

```php
//your_authorize_and_redirect_url.php
PHPCartzy\CartzySDK::config($config);
$accessToken = \PHPCartzy\AuthHelper::createAuthRequest($scopes);
//Now store it in database or somewhere else
```

#### Get the CartzySDK Object

```php
$Cartzy = new PHPCartzy\CartzySDK;
```

You can provide the configuration as a parameter while instantiating the object (if you didn't configure already by calling `config()` method)

```php
$Cartzy = new PHPCartzy\CartzySDK($config);
```

#### Discount Code
You can get list of discount codes created in store admin.
```php
$config = array(
    'ClientID' => '***CLIENT-ID-FOR-THIRD-PARTY-APP***',
    'ShopUrl' => 'yourshop.cartzy.com',
    'AccessToken' => '***ACCESS-TOKEN-FOR-THIRD-PARTY-APP***',
);

PHPCartzy\CartzySDK::config($config);
$discountCode = new PHPCartzy\Discount\DiscountCode();
$resp = $discountCode->get();
```

## Reference
- [Cartzy API Reference](https://help.cartzy.com/api/reference/)