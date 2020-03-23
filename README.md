# Quotation

Quotation API: ABI Quotation API developed using Symfony 4.3

## Motivation

### User History

This project is based in this user history:

```
AS an User
I WANT TO be send a request using verb POST to /quotes endpoint with the body: age, postcode, regNo.
So that i can receive a response with: id, policyNumber, age, postcode, regNo, abiCode, premium.

Notes:
- The vehicle registration number should be checked in a third API to receive a valid ABI Code.
- After receive the hit, the API should look up the base premium to find the rating factors to apply for age, postcode area and ABI code(assume a rating factor of 1 if the value is not in the database)
- The value of premium must be multiplied by each rating factor in turn to obtain a premuim.
- All the quotes details should be saved in the database.
```

## OAS

This api use OAS and it spec can be visualized here: [OAS](https://github.com/jmsilvadev/quotation-api/blob/master/app/public/openapi.json).


## Development

### Setup project

To set up an API container you should download the source code from
github and install it.

The `make install` should be only used once. It will install all the
dependences and insert the fake data to the database.
After this, you should only use the `make up` & `make down` to controll your
container.

You are now ready to use the system. Type `make up` to start the container
and `make down` to stop it.

### Build tools

Build the image

```bash
make build
```

### Composer

To install / update or add composer dependencies:

```bash
make composer.install
make composer.update
```

Add composer dependencies:

```bash
make composer.require pac=name-package
```

### Code Quality

Last Metrics:
![PHP Metrics](https://github.com/jmsilvadev/person_notification/blob/master/metrics.png)

PHP Metrics:

```bash
make php.metrics
```

PHP CS:

```bash
make php.cs
```

PHP CBF:

```bash
make php.cbf
```

PHP MD:

```bash
make php.md
```

### Tests

Last Coverage: 
![Coverage](https://github.com/jmsilvadev/person_notification/blob/master/coverage.png) 

Run all tests suite

```bash
make test
```

Run specifit test suits

```bash
make test.unit ## unit tests suite
make test.feature ## feature tests suite
```

### Migrations (DB)

To create DB Structure (Migrations):

```bash
make createdb
```


```bash
make db.migrate
```

### MakeFile

To make our tools abstract to the intentions we use simple make commands to
perform tasks like: launch a test suite.
Example:.

```bash
make test
```

To learn all the commands the MakeFile can do just use the command
`make` or `make help`
