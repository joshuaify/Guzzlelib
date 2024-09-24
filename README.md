# Guzzlelib

Guzzlelib is a PHP wrapper library for Guzzle HTTP client, providing a simplified interface for making HTTP requests. It offers an easy-to-use API for GET, POST, PUT, PATCH, and DELETE requests, with built-in error handling and response parsing.

This library can be used with PHP 7.2+ and is compatible with popular PHP frameworks, including Laravel, Symfony, CodeIgniter, Zend, Yii, CakePHP, and Slim. It's ideal for any PHP application that requires streamlined API communication. 

## Requirements

- PHP 7.2 or higher
- Composer (for dependency management)
- Guzzle HTTP client

## Installation

You can install Guzzlelib using Composer. Run the following command in your project directory:

```
composer require joshuaify/guzzlelib
```

## Usage

### Initialization

First, include the Guzzlelib class in your PHP file:

```php
use joshuaify\Guzzlelib\Guzzlelib;
```
or

```php
require 'path/to/your/vendor/joshuaify/guzzlelib/src/Guzzlelib.php';
```

Then, create an instance of Guzzlelib:

```php
$guzzlelib = new Guzzlelib([
    'base_uri' => 'https://api.example.com',
    'timeout' => 30.0,
    'headers' => [
        'Authorization' => 'Bearer your-token-here'
    ]
]);
```

### Making Requests

#### GET Request

```php
$response = $guzzlelib->getRequest('/users', ['page' => 1]);
```

#### POST Request

```php
$response = $guzzlelib->postRequest('/users', [
    'name' => 'John Doe',
    'email' => 'john@example.com'
]);
```

#### PUT Request

```php
$response = $guzzlelib->putRequest('/users/1', [
    'name' => 'Jane Doe'
]);
```

#### PATCH Request

```php
$response = $guzzlelib->patchRequest('/users/1', [
    'email' => 'jane@example.com'
]);
```

#### DELETE Request

```php
$response = $guzzlelib->deleteRequest('/users/1');
```

### Handling Responses

All request methods return an array with two keys: `code` and `body`.

- `code`: The HTTP status code of the response.
- `body`: The decoded JSON body of the response.

Example:

```php
$response = $guzzlelib->getRequest('/users');

if ($response['code'] === 200) {
    $users = $response['body'];
    // Process $users data
} else {
    // Handle error
    echo "Error: " . json_encode($response['body']);
}
```

### Error Handling

If a request fails, Guzzlelib will return an array with an `error` key set to `true` and a `message` describing the error.

```php
$response = $guzzlelib->getRequest('/non-existent-endpoint');

if (isset($response['error']) && $response['error'] === true) {
    echo "Error occurred: " . $response['message'];
}
```

## Configuration Options

When initializing Guzzlelib, you can pass an array of configuration options:

- `base_uri`: The base URL for all requests.
- `timeout`: The timeout for requests in seconds.
- `headers`: An array of default headers to be sent with each request.
- `auth`: Authentication method (e.g., ['username', 'password'] for Basic Auth).
- `proxy`: Proxy settings.
- `verify`: SSL certificate verification (set to `false` to disable).
- `connect_timeout`: The number of seconds to wait while trying to connect to a server.
- `cookies`: Set to `true` to use a shared cookie session, or provide an instance of `GuzzleHttp\Cookie\CookieJarInterface`.
- `allow_redirects`: Set to `false` to disable redirects.
- `debug`: Set to `true` to enable debug output.
- `http_errors`: Set to `false` to disable throwing exceptions on HTTP protocol errors (4xx and 5xx responses).

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This library is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
