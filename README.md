# phpers-demo

Application dedicated to be a presentation complement.
It provides a very simple Blog with just few basic functionalities.
It was designed to simply present how an event sourced application works.


## Setting up environment

PHPers Demo environment is based on docker containers,
so make sure your environment supports docker and the docker-machine is up.

Then start the machines with command:

```
$ docker-compose up -d
```

Check if all containers started:

```
$ docker ps -a
```

The output should look similar to that like:

Status should be "Up ..." on 4 containers:

```
phpersdemo_nginx_1
phpersdemo_php_1
phpersdemo_db_1
```

You can log into *php* machine:

```
$ docker exec -it phpersdemo_php_1 bash
```

Go to ```/var/www/blog``` directory and install application with composer:

```
$ composer install -n
```

## Running tests

### Behat

To run Behat scenarios login to *php* container,
go to ```/var/www/blog``` directory and run:

```
$ bin/behat
```

### PHPSpec

To run PHPSpec and/or see classes specs login to *php* container,
go to  ```/var/www/blog``` directory and run:

```
$ bin/phpspec run -fpretty
```

## Application commands

When logged into *php* container, you can run one of created commandline tools:

### Loading fixtures

```
$ php app/console ulff:fixtures:load
```

This command fills event storage and projection storage with some sample data.
Command looks similar to the one avaiable with *DoctrineFixturesBundle* but operates
on PHPers Demo use cases.

### Cleaning projection

```
$ php app/console ulff:projection:clear --name=projection-name
```

This command removes all data from projection defined in parameter *name*.
Just fill in correct projection name, e.g. *post-list*.

### Replaying projection

```
$ php app/console ulff:projection:populate --name=projection-name
```

This command cleans and replays projection defined in parameter *name*.
Just fill in correct projection name, e.g. *post-list*. Your projection data will be then
recreated from event storage.


## Browsing MongoDB data

Log into *db* machine:

```
$ docker exec -it phpersdemo_db_1 bash
```

Then run MongoDB:

```
$ mongo
```

And switch to ```phpersdemo``` database:

```
> use phpersdemo
```
