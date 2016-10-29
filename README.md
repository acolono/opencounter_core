# Opencounter api core

contains the OpenCounter classes.


<img src="./img/opencounter-logo.png" alt="OpenCounter Logo" width="150">
<img src="http://acolono.gitlab.net/opencounter_core/project/badges/master/build.svg" alt="OpenCounter master Build status" width="150">
<img src="http://acolono.gitlab.net/opencounter_core/project/badges/master/coverage.svg" alt="OpenCounter master Coverage" width="150">

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

probably you will want to use the continuous testing setup which automatically reruns the handy bash script at ./bin/run-tests.sh on filesave
with immediate feedback in terminal and browser, for this you will need to run

$ npm install
if you dont have node/npm on your host but have docker running then you can use
https://serversforhackers.com/docker-for-gulp-build-tasks
(sorry, did put this together into a repo but couldnt share it yet and neither did the OP, feel free to pass me a link to something like this that is ready to use)

this should allow you to run
$ gulp

# todo

- include phpspec in continuous tests
- make sure we can xdebug during test runs (also in spec and behat context) and document
- look into https://github.com/nicolopignatelli/valueobjects/blob/master/src/Identity/UUID.php