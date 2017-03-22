# Opencounter api core

contains the OpenCounter classes.



[![build status](https://gitlab.acolono.net/Rosenstrauch/OpenCounter_api_core/badges/develop/build.svg)](https://gitlab.acolono.net/Rosenstrauch/OpenCounter_api_core/commits/master)

[![coverage report](https://gitlab.acolono.net/Rosenstrauch/OpenCounter_api_core/badges/develop/coverage.svg)](https://gitlab.acolono.net/Rosenstrauch/OpenCounter_api_core/commits/master)


# usage

require via composer, then check tests (./behat/features/bootstrap and ./spec) for what classes we bring along and usage examples

# contribute

if you want to develop, you first need to install its dependencies:
$ composer install

if you dont have composer installed on your host but have docker then you can use
https://github.com/RobLoach/docker-composer

now you can run our test suite with these commands

```
$ bin/behat
$ bin/phpspec
```

debugging tests
```

$ php -dxdebug.remote_autostart=1 -dxdebug.remote_enable=1 -dxdebug.remote_mode=req -dxdebug.remote_port=9000 -dxdebug.remote_connect_back=1 ./bin/behat
```

probably you will want to use the continuous testing setup which automatically reruns the handy bash script at ./bin/run-tests.sh on filesave
with immediate feedback in terminal and browser, for this you will need to run
```
$ npm install
```
if you dont have node/npm on your host but have docker running then you can use
https://serversforhackers.com/docker-for-gulp-build-tasks
(sorry, did put this together into a repo but couldnt share it yet and neither did the OP, feel free to pass me a link to something like this that is ready to use)

this should allow you to run
```
$ gulp
```
