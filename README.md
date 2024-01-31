# Acme Widget Co Proof of Concept Sales System

## Setup & Development

Clone the project with git

```bash
git clone git@github.com:dillanjwilding/acme-widget-co.git
cd acme-widget-co
```

Use Docker to build the image, either with Docker Compose

```bash
docker compose up --build -d
```

and when you're done

```bash
docker compose down
```

You can run PHPUnit tests and PHPStan with these commands

```bash
docker compose run app ./vendor/bin/phpunit --configuration phpunit.xml
docker compose run app ./vendor/bin/phpstan analyse -c phpstan.neon --memory-limit 512M
```

Here are some alternative commands

```bash
docker build -t acme-widget-co .
docker run acme-widget-co
```

```bash
docker container ls 
docker exec -it <container id> /bin/sh
```

```bash
composer install
./vendor/bin/phpunit --configuration phpunit.xml
./vendor/bin/phpstan analyse -c phpstan.neon
```

Notes:
 - I started off trying to have more of an ideal approach but when things started breaking I sacrificed a bit of best practices to get it working.
 - If you're not familiar with alpine images, I was using an image that we could use `/bin/bash` but now that I'm using an `alpine` image, you need to use `/bin/sh`.

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

## Notes

- Normally working in a professional setting, the region the team is based in dictates the vernacular or terms you use. I tried to stick to the terminology from the specifications/requirements document with minimal changes.
  - I was debating renaming `Basket` to `Cart` or `ShoppingCart`, `Offers` to `Deals` or `Promotions`, and `DeliveryCost` to `ShippingCost` but for the most part decided against it, with the exception of `Catalog` vs `Catalogue`.

## Approach

I tried to take small iterations and explain my thoughts in comments along the way. At first my thoughts were around how I could create interfaces and a hierarchy of classes but then I thought how often that's used to scale software and I found that often the best approach for building software that scales is to build something that works for the most cases and tools for non-developers to maintain it, thus I removed my classes for different delivery options and offers and opted for a solution that could be easily stored in the database and expanded upon for more functionality.

Notes:
 - Coming up with applicable names was tough, I'm still not happy with them but at some point I have to call this project done and submit it.

## Structure

 - `Basket` Facilitates the organization and function of the "shopping cart". Manages a collection of `Item` objects, each having their own cost, and calculates the total cost based on delivery costs and applying applicable offers.
 - `Item` `Product` and quantity of that `Product` in a `Basket` or shopping cart.
 - `Catalog` Manages a collection of products.
 - `DeliveryCost` Calculate delivery costs based on total order price.
 - `Offer` These are special promotions. There is a condition in which if met, the discount is applied. The example given is "buy one get one half price" but only for Red Widgets.
 - `OfferService` Manages `Offer` that are available.
 - `Product` This is a digital or physical product with a name, code, and price.
 - `ProductService` Manages `Product` that are available.

Notes:

 - I think that `Offer` should have a start date and end date, possibly a display ID or name, etc but it seems overly complicated for a proof of concept so I kept it on the simple side.
 - To make it so that we wouldn't need a new class for every new offer as that has more developer overhead than adding a record to a database, my implementation geared more toward that type of reuse but it has limitations.
   - One of my previous iterations I was thinking about the concept of `$condition` and `$discount` being functions. While that was very flexible, I imagined needing to write code for every new offer and thought that was going to be a burden on developers whereas building a system based off the database and administration tools for an internal user to manage the deals would be less overhead.
 - If there is an `Offer` "record", it is active. Normally we'd want to have a duration which they are valid and possibly have a way to deactivate an offer, with this implementation you'd have to delete the record.

## Future Development

The proof of concept implementation didn't require these components but they are usually part of products and services:

 - Add the mechanism to have `ProductService` be able to contain a subset of available `Product` rather than all of them so that you could have multiple Catalogs with different lists of `Product` options.
 - Database and connections
 - Multiple services and/or containers
 - Managing development and production environments, dependencies, etc
   - I may dig into the dependencies a bit to exclude development dependencies like PHPUnit and PHPStan from a production build