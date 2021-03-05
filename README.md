# TimeBreaker

[![Build Status](https://travis-ci.com/mmarkalas/timebreaker.svg?token=4yyXQczoGXxeXXg7rzhX&branch=main)](https://travis-ci.com/mmarkalas/timebreaker)

Simple REST API that provides time breakdown based on the expression and date range passed in the payload.

### Tech

I've used a number of open source projects/pacakges to build this App:

* [Lumen](https://lumen.laravel.com/) - PHP Framework from the creators of Laravel
* [Sublime Text 3](https://www.sublimetext.com/) - free text editor.
* [Composer](https://getcomposer.org/) - A Dependency Manager for PHP
* [Postman](https://www.postman.com/) - API Tool for sending any types of request
* [Swagger](https://swagger.io/) Great for API Documentation
* [Docker](https://www.docker.com/) OS-level virtualization to deliver software in packages called containers
* [Docker Compose](https://docs.docker.com/compose/) Compose is a tool for defining and running multi-container Docker applications

### Installation

This project used the following tools for development:
* [Docker](https://www.docker.com/)
* [Docker Compose](https://docs.docker.com/compose/)

Pull the repository in your local machine and run the following commands in the CLI.

```sh
$ sh setup.sh
```

The Setup automatically install everything inside the Docker Containers and we just need to wait until it's done.

Once it's ready, we can now send request on http://localhost:8080/timebreak

### API DOCUMENTATION

To view the documention and test the endpoints, please visit this link:
http://localhost:8080/api/documentation
