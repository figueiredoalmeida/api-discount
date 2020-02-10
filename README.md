Discount Calculator API
=======================

This Symfony REST API calculates the discount over the orders sent via post.


Installation
------------
Please, follow these steps:
```sh
$ git clone https://github.com/figueiredoalmeida/api-discount.git
$ cd api-discount
$ composer install
```

# Database must be running

**IMPORTANT: Change DATABASE_URL in .env**

```sh
$ php bin/console doctrine:database:create --if-not-exists
$ php bin/console make:migration
```

How to use
------------
You can use Postman or any other Rest service client tool to run the API.
Tokens availables are "token1" and "token2".

Run the command bellow in order to test the API.
```sh
$ php -S localhost:8000 -t public/
```

I suggest to load some data for customers and products, where you can take from here:\

Customers - https://github.com/teamleadercrm/coding-test/blob/master/data/customers.json\
Products - https://github.com/teamleadercrm/coding-test/blob/master/data/products.json\
Orders - https://github.com/teamleadercrm/coding-test/tree/master/example-orders

### Customers
```
http://localhost:8000/api/v1/customer?token=token1
```
### Products
```
http://localhost:8000/api/v1/product?token=token1
```
### Discounts
To test the discount API, please use this endpoint:
```
http://localhost:8000/api/v1/discount?token=token1
```

For logging, please, make sure the directory var/log is writeable.

## Author
* **Rodrigo de Almeida** - *Initial work* - [figueiredoalmeida](https://github.com/figueiredoalmeida)
