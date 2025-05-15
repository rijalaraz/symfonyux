## This application is made with Symfony UX and is for educational purposes.

Start by cloning the application by running in your console:
```
git clone https://github.com/rijalaraz/symfonyux.git
```

Then run ``cd symfonyux`` to enter the application root

Install your local web server so that you have Apache, PHP 8 and PostgreSQL

Start by renaming the ``env`` file to ``.env.local``

In the application root, launch:
```
composer install
```

Configure your Postgresql database server to match what is in the ``.env.local`` file

Also install ``symfony CLI``

Run this command to create the database:
```
symfony console doctrine:database:create
```

Once the database is created, run:
```
symfony console doctrine:migrations:migrate
```

Now launch the fixtures:

```
symfony console doctrine:fixtures:load
```

Now you can start the application by running:
```
symfony server:start
```

You can start with the list of posts via this link:
```
http://127.0.0.1:8000/post
```
