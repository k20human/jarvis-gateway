Jarvis gateway
========================

[![Build Status](https://travis-ci.org/k20human/jarvis-gateway.svg)](https://travis-ci.org/k20human/jarvis-gateway)

Current version: **0.1.0**

## Description ##

This project is a (mandatory) gateway between [Jarvis](<https://github.com/k20human/jarvis>) and [Domoticz](<https://domoticz.com/>)

## Requirements

 - PHP >= 7.1
 - MySQL >= 5.6
 - Composer
 - [Domoticz](<https://domoticz.com/>)

## Installation

Download projet from Github.

Run this command:

    make install

That's it !

## Development

This project uses make as runner for common tasks

### Updates develop branch

You can update the develop branch to start a new feature or fix branch, using the `update` recipe :

    make update

This task keeps your current changes, updates the develop branch and the database structure.

Many other recipes are availables, have a look at the `Makefile` for more information.

## Tests

Use the `tests` to execute all the project tests has they will be executed during merge requests :

    make tests

2 recipes are also availables for executing unit or functional tests :

Executes functional tests only using [LiipFunctionalTestBundle](https://github.com/liip/LiipFunctionalTestBundle#basic-usage) :

    make functional-tests

Executes unit tests only using phpunit :

    make unit-tests

## Commands
 
### Create user

	make create-user
    
## Connection

In order to connect you must first get a token. Launch this HTTP (POST) request:

	/login_check
	
With this JSON payload :

	{
		"_username":"test",
		"_password":"test"
	}
	
 - username: `username` from `user` table
 - password: your password (if it's the first user created by the fixture: `parameter jarvis_admin_name`-@dm1n)
 
 Get `token` and add to your HTTP request a new `Authorization` header with `Bearer` in prefix
  
## Credits

* [k20human](<https://github.com/k20human>)

## License

This bundle is under the MIT license.  
For the whole copyright, see the [LICENSE](LICENSE) file distributed with this source code.