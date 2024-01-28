# Acme Widget Co Proof of Concept Sales System

Todo: Write about the project and notes (assumptions, etc).

## Setup & Development

Clone the project with git

```bash
git clone git@github.com:dillanjwilding/acme-widget-co.git
```

Use Docker to build the image, either with Docker Compose

```bash
docker compose up --build
```

or with Docker

```bash
docker build -t acme-widget-co .
docker run acme-widget-co
```

You can run PHPUnit tests with

```bash
docker compose run app ./vendor/bin/phpunit --configuration phpunit.xml
```

and PHPStan with

```bash
docker compose run app ./vendor/bin/phpstan analyse
```

or you can run them from inside the Docker container once it has been built and is running

```bash
docker container ls 
docker exec -it <container id> /bin/bash
./vendor/bin/phpunit --configuration phpunit.xml
./vendor/bin/phpstan analyse
```

## Structure

- Todo: Update this list with class names and descriptions
- `Basket` facilitates the organization and function of the "shopping cart".
- `Item`
- `Catalog`
- `Delivery` or `DeliveryCost` (rename, doesn't seem right)
- `Offer` (also seems like it could use a better name)
- `Product`
- `Products` (rename, it's a container or wrapper for products but not a Factory or similar; I've seen these called a lot of different things at different companies Service or Controller were the most popular but I don't want Controller to be confused with something like MVC)

## Approach

## Project Details 

Implement basket which needs to have the following:
 - Initialized with the product catalog, delivery charge rules, and offers.
 - It has an add method that takes the product code as a parameter.
 - It has a total method that returns the total cost of the basket, taking into account the delivery and offer rules.

### Products

| Product      | Code | Price  |
|--------------|------|--------|
| Red Widget   | R01  | $32.95 |
| Green Widget | G01  | $24.95 |
| Blue Widget  | B01  | $7.95  |

### Delivery

| Order Total | Delivery |
|-------------|----------|
| < $50       | $4.95    |
| < $90       | $2.95    |
| >= $90      | free     |

### Tests

| Products                | Total  |
|-------------------------|--------|
| B01, G01                | $37.85 |
| R01, R01                | $54.37 |
| R01, G01                | $60.85 |
| B01, B01, R01, R01, R01 | $98.27 |

## Future Development

The proof of concept implementation didn't require but these components are usually part of products and services:

- Database
- Multiple services and/or containers
- Managing development and production environments, dependencies, etc