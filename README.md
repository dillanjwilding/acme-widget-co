# Acme Widget Co Proof of Concept Sales System

Todo: Write about the project and notes (assumptions, etc).

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

Note:
 - To support auto-updates / "hot reloads" (i.e. changes are reflected in Docker container), I rely on the Docker Compose watch with develop keyword which is was released in Docker Compose 2.22.0.
   - If you use Docker Desktop, this comes bundled with Docker Desktop 4.24.
 - I was using an image that we could use `/bin/bash` but now that I'm using an `alpine` image, you need to use `/bin/sh`.

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

Delivering products and services in a professional software setting is a tradeoff between the best/ideal approach that takes more time and effort and a minimal viable version that provides the functionality, thus I find it often a good practice to start with a solid foundation by getting something working that is generally based on sound logic with good practices, then iterate to make incremental improvements. Thus, I started by coming up with a plan, then I got the basics working, then I iterated on my implementation to make improvements. As a side note, it's often easier to show progress and what needs more focus and attention when you get something functional and working first.

Immediately I knew I needed `Basket`, `Catalog`, and `Product` classes and a way to calculate delivery charge rules and apply applicable offers. I tried to stick to the terminology from the specifications/requirements document with minimal changes (i.e. I was debating renaming `Basket` to `Cart` or `ShoppingCart`, `Offers` to `Deals` or `Promotions`, and `Delivery` to `Shipping` but for the most part decided against it, with the exception of `Catalog` vs `Catalogue`).

When I dug deeper into how these pieces would work together, such as adding `Product` objects to a `Basket`, it became clear I needed a quantity associated to each `Product` so I decided that it was necessary to create an `Item` class. I created `Offerings` (need to rename) and `Products` (need to rename) as convenient ways to manage dependencies, `Offer` and `Product` respectively.

And that is where I got stuck. I had thought about different ways to structure and organize delivery cost calculation and handling offers and they each seem to come with advantages and disadvantages but none seemed ideal. I tried to start simple, then think of how to make it a more long term, scalable solution. I think I figured out delivery cost calculation to some extent, there are definitely ways to improve it, but I'm not happy with my solution/implementation for applying applicable offers. I'm trying to not over-engineer a complicated and overly complex solution but there just seems like there should be a better way. 

Decided against changing `DeliveryCost` to an interface or parent class and implementing `StandardDelivery` and `ExpeditedDelivery` because it created code overhead with no upside (didn't add functionality, didn't help with scaling or usability). Besides naming, I think I'm fine with this implementation.

I'm still not happy with `Offer`.

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
 - I think that `Offer` should have a start date and end date, possibly a display ID or name, etc but it seems overly complicated for a proof of concept so I kept it on the simple side.

## Assumptions

 - To make it so that we wouldn't need a new class for every new offer as that has more overhead than adding a record to a database, my implementation geared more toward that type of reuse but it has limitations.
   - One of my previous iterations I was thinking about the concept of `$condition` and `$discount` being functions. While that was very flexible, I imagined needing to write code for every new offer and thought that was going to be a burden on developers whereas building a system based off the database and administration tools for an internal user to manage the deals would be less overhead.
 - If there is an `Offer` "record", it is active. Normally we'd want to have a way to deactivate an offer, with this implementation you'd have to delete the record.

## Future Development

The proof of concept implementation didn't require these components but they are usually part of products and services:

 - Database and connections
 - Multiple services and/or containers
 - Managing development and production environments, dependencies, etc
   - I may dig into the dependencies a bit to exclude development dependencies like PHPUnit and PHPStan from a production build