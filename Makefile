test: # run tests and check code rules.
	- php bin/phpunit
	- vendor\bin\phpstan analyse src --level 6
	- vendor\bin\phpstan analyse tests --level 6