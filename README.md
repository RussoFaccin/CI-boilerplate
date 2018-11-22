# CodeIgniter - Boilerplate
---
CodeIgniter boilerplate project
* Authentication
* Routes protection
* Login (route)
* Auth (route)
* Register (route)
* Logout (route)

#### Installation
* Clone the repository
* Copy files to a fresh CodeIgniter installation

#### Configuration
```sh
// application/config/config.php

$config['base_url'] = '<SITE URL>';

/*
|==================================================
| Authentication
|==================================================
*/

$config['authentication'] = array(
    'timeOut' => 300,
    'redirectTo' => 'users/login'
);
```
#### Usage
To register a user access the following route:
```sh
<SITE_URL>/users/register
```
To protect a route add the following code to route controller class
```sh
// Load Auth Library
$this->load->library('Auth');
// Check
$this->auth->check();
```
To authenticate the user
```sh
// Load Auth Library
$this->load->library('Auth');
// Authenticate
$this->auth->authenticate($user);
```
To logout the user:
```sh
// Load Auth Library
$this->load->library('Auth');
// Logout
$this->auth->logout();
```