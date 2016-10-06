# PHP Simple Curl Class 
Version 1.0.0

Php class to make simple curl request. Can use as code igniter library or as php class.

## Geting started 
### - As PHP Class
![PHP](https://github.com/geronimo794/php-simple-curl-class/blob/master/images/php-logo.png?raw=true)
**Step 1** :
Download the curl class here [here](https://raw.githubusercontent.com/geronimo794/php-simple-curl-class/master/Curl.php) 

**Step 2** : Include or require the curl class in your php file
```php
require('Curl.php');
```
**Step 3** : Create object from curl class
```php
$my_curl = new Curl();
```
**Step 4** : Set the url of curl request
```php
$my_curl->setUrl('https://api.instagram.com/v1/media/shortcode/BLLZnwjAeEm');
```
**Step 5** : Set the GET/POST parameter to send via curl
```php
$my_curl->setGetData('access_token', 'abxcsdfsdfasdasd');
$my_curl->setPostData('private_key', 'fgxftfsadfsadsad');
```
OR
```php
$var_to_send = array(
    'access_token' => 'abxcsdfsdfasdasd',
    'private_key' => 'fgxftfsadfsadsad'
);
$my_curl->setGetData($var_to_send);
$my_curl->setPostData($var_to_send);
```
**Step 6** : Set the user_agent of curl
```php
$my_curl->setUserAgent('Maybe mozilla');
```
**Step 7** : Get the curl response
```php
$curl_respon = $my_curl->getResponse();
```
### - As Code Igniter Library
![PHP](https://github.com/geronimo794/php-simple-curl-class/blob/master/images/code-igniter-logo.png?raw=true)

**Step 1** :
Download the curl class here [here](https://raw.githubusercontent.com/geronimo794/php-simple-curl-class/master/Curl.php) 

**Step 2** : Put the class file to Code Igniter library
![Getting Started 1](https://github.com/geronimo794/php-simple-curl-class/blob/master/images/getting-started-1.jpg?raw=true)
**Step 3** : Load curl library in your controller
```php
$this->load->library('curl');
```
**Step 4** : Set the url of curl request
```php
$this->curl->setUrl('https://api.instagram.com/v1/media/shortcode/BLLZnwjAeEm');
```
**Step 5** : Set the GET/POST parameter to send via curl
```php
$this->curl->setGetData('access_token', 'abxcsdfsdfasdasd');
$this->curl->setPostData('private_key', 'fgxftfsadfsadsad');
```
OR
```php
$var_to_send = array(
    'access_token' => 'abxcsdfsdfasdasd',
    'private_key' => 'fgxftfsadfsadsad'
);
$this->curl->setGetData($var_to_send);
$this->curl->setPostData($var_to_send);
```
**Step 6** : Set the user_agent of curl
```php
$this->curl->setUserAgent('Maybe mozilla');
```
**Step 7** : Get the curl response
```php
$curl_respon = $this->curl->getResponse();
```

## Avaible methods
- **clear()** : Clear all the given setting to curl object
- **setUrl( $url )** : Set the url of curl request
- **setUserAgent( $userAgent )** : Set useragent
- **setPostData( $name, $value )** : Set the post data
- **setPostData( array( $name => $value ) )** : Set the post data
- **setGetData( $name, $value )** : Set the get data
- **setGetData( array( $name => $value ) )** : Set the get data
- **getResponse()** : Get response from curl
## Changelogs
Version 1.0.0
- setData, setUrl, setUserAgent, clear, getResponse.
