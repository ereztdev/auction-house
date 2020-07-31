# AuctionHouse V1.0.0
![](https://github.com/ereztdev/auction-house/blob/master/splash.png)

---

## Instalation For Local Environment
- Assuming you will run in a webserver either on windows (XAMPP/WAMPP/etc) or on Linux where you already have a 
webserver installed there (Apache2/NGINX/etc). 
#### pre-requisites
- **PHP** - via your webserver
- **Mysql** - via your webserver 
- **Composer** - PHP Dependency Manager, if you don't have it, you can [download it right here](https://getcomposer.org/download/).

#### Installation Procedure
- clone this repo (`git clone https://github.com/ereztdev/sia.git`) into your webserver
- switch into the repo directory where you pulled the repo: (`cd sia`)
- Install PHP dependencies (`composer install`)
- environment:
  - In the project root, you will have to create an `.env` environment file: `cp .env.example .env`
  - in MySQL create a database and fill out that DB name here (`DB_DATABASE`), do the same for the DB username and password
  - Now our environment is set. Let's go ahead and seed our database, run `php artisan migrate`.
  - Now let's seed our DB `php artisan db:seed --class=DatabaseSeeder`.
 
#### Test
- All tests are centralized into one central test for:
  - Add item
  - Different bids
  - fetching an item with a custom JSON


Thanks,
Erez
