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

## Approach

Immediately I knew I needed `Basket`, `Catalog`, and `Product` classes and a way to calculate delivery charge rules and apply applicable offers. I tried to stick to the terminology from the specifications/requirements document with minimal changes (i.e. I was debating renaming `Basket` to `Cart` or `ShoppingCart`, `Offers` to `Deals`, and `Delivery` or `DeliveryCost` to `Shipping` but decided against it).

When I dug deeper into how these pieces would work together, such as adding `Product` objects to a `Basket`, it became clear we need a quantity so I decided that we needed `Item`. From there, everything seemed to work together but I knew I needed a more long term solution for calculating delivery costs and applying applicable offers without over-engineering a complicated and overly complex solution.

## Structure

 - `Basket` Facilitates the organization and function of the "shopping cart". Manages a collection of `Item` objects which total cost calculation, delivery costs, and apply applicable offers.
 - `Item` This is a `Product` in a `Basket` or shopping cart and includes a quantity.
 - `Catalog` Manages a collection of products.
 - `Delivery` or `DeliveryCost` (rename, doesn't seem right) Calculate delivery costs based on total order price.
 - `Offer` (also seems like it could use a better name) These are special promotions. There is a condition in which if not met, the discount is not applied. The example given is "buy one get one half price" but only for Red Widgets but my solution should be able to work for other deals as well such as "buy one get one free".
 - `Product` This is a digital or physical product with a name, code, and price.
 - `Products` (rename, it's a container or wrapper for products but not a Factory or similar; I've seen these called a lot of different things at different companies Service or Controller were the most popular but I don't want Controller to be confused with something like MVC)

Notes:

 - I'm still not completely sold on the sub-directories inside the `src` directory (i.e. `Basket`, `Catalog`, `Delivery`, etc) as most of them seem redundant with some exceptions.
   - It makes sense for `Basket` where there not only is a `Basket` class but also a `BasketFactory` convenience class and an `Item` class which probably could have been called `BasketItem` but I thought since it's namespace was `AcmeWidgetCo\Basket\Item` that it was already contextualized.
   - My rationalization for this structure was that I want to make `Interfaces`, `Factory` classes, and other files when they make sense but I also don't want to over-engineer this and make it overly complicated because the instructions said to "demonstrate how your program could grow and why it's a foundation that would help less experienced developers write good code" and part of that is for the code to be legible to someone with less experience with not only some of the more niche aspects of PHP but also complicated logic and project structure (I want to construct guardrails not handcuffs that don't make sense and cause headaches).

## Future Development

The proof of concept implementation didn't require these components but they are usually part of products and services:

 - Database
 - Multiple services and/or containers
 - Managing development and production environments, dependencies, etc
   - I may dig into the dependencies a bit to exclude development dependencies like PHPUnit and PHPStan from a production build