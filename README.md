# TimeBreaker

[![Build Status](https://travis-ci.com/mmarkalas/timebreaker.svg?token=4yyXQczoGXxeXXg7rzhX&branch=main)](https://travis-ci.com/mmarkalas/timebreaker)

Simple REST API that provides time breakdown based on the expression and date range passed in the payload.

## Features
* Accepts 2 format of Expressions: "2m,m,d" and ["2m","m","d"]
* Allows time breakdown from up to Century ("c")*, down to Seconds ("s")
* Search previous time breakdown based on the date range provided

## Tech

I've used a number of open source projects/packages to build and manage this App:

* [Lumen](https://lumen.laravel.com/) - PHP Framework from the creators of Laravel
* [Sublime Text 3](https://www.sublimetext.com/) - free text editor.
* [Composer](https://getcomposer.org/) - A Dependency Manager for PHP
* [Postman](https://www.postman.com/) - API Tool for sending any types of request
* [SwaggerLume](https://github.com/DarkaOnLine/SwaggerLume)  Wrapper of Swagger-php and swagger-ui adapted to work with Lumen Framework
* [Docker](https://www.docker.com/) OS-level virtualization to deliver software in packages called containers
* [Docker Compose](https://docs.docker.com/compose/) Compose is a tool for defining and running multi-container Docker applications
* [PHPUnit](https://phpunit.de/) Testing framework for PHP and comes with Lumen Framework
* [Travis CI](https://travis-ci.org/) Test and Deploy with Confidence
* [AWS CodePipeline](https://aws.amazon.com/codepipeline/)  Continuous Delivery Service
* [AWS CodeDeploy](https://aws.amazon.com/codedeploy/) Deployment service that automates software deployments
* [AWS EC2](https://aws.amazon.com/ec2/) Web service that provides secure, resizable compute capacity in the cloud

## Installation

The following tools or apps are required for **local installation**:
* [Docker](https://www.docker.com/)
* [Docker Compose](https://docs.docker.com/compose/)

#### Steps
**Pull** or **Clone** the repository in your local machine and run the following commands in the CLI.

```sh
$ cd timebreaker
$ sh setup.sh
```

The Setup automatically install everything inside the Docker Containers, thanks to Docker Compose, and we just need to wait until it's done.

Once it's ready, we can now send request on 

| Environment | Endpoint |
| ------ | ------ |
| LOCAL | http://localhost:8080/timebreak |
| PRODUCTION | https://ec2-18-138-249-121.ap-southeast-1.compute.amazonaws.com/timebreak |

## CI/CD

TimeBreaker was successfully integrated with [AWS CodePipeline](https://aws.amazon.com/codepipeline/) and [AWS CodeDeploy](https://aws.amazon.com/codedeploy/) 
and will trigger the **deployment** process once we merged our changes to the **main** branch.

[Travis CI](https://travis-ci.org/) was also integrated and will do the testing after creating a **Pull Request** to **main** branch.

For more info regarding this integrations, please check the following files in this repository:

```sh
$ ./appspec.yml
$ ./scripts/*
$ ./.travis.yml
```

## SWAGGER API DOCUMENTATION

To view the documention and test the endpoints, please visit this link on your browser:

| Environment | Endpoint |
| ------ | ------ |
| LOCAL | http://localhost:8080/api/documentation |
| PRODUCTION | https://ec2-18-138-249-121.ap-southeast-1.compute.amazonaws.com/api/documentation |

## Coding Standard and Design Pattern
TimeBreaker implements [PSR-12](https://www.php-fig.org/psr/psr-12/) Coding Standard and follows the **Repository Design Pattern**.

Here are some links to get you started with **Repository Design Pattern**:

https://asperbrothers.com/blog/implement-repository-pattern-in-laravel/
https://webdevetc.com/blog/the-repository-pattern-in-php-and-laravel/

## License

MIT

**Free Software**
