Sensio Event
============

## Install

```console
$ git clone https://github.com/Tiriel/training-07-04-26.git
$ cd ./training-07-04-26
$ symfony composer install
$ symfony console doctrine:migration:migrate --allow-no-migration --no-interaction
$ symfony console doctrine:fixtures:load --no-interaction
$ symfony serve
```

## Log in

You can register your own account using the dedicated link on the website or use one of the existing users :

| email                 | password  | roles          |
|-----------------------|-----------|----------------|
| nobody@example.com    | nobody    |                |
| user@example.com      | user      | ROLE_USER      |
| website@example.com   | website   | ROLE_WEBSITE   |
| organizer@example.com | organizer | ROLE_ORGANIZER |
| admin@example.com     | admin     | ROLE_ADMIN     |
