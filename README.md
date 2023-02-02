## PASSO A PASSO

### Configurar server e banco de dados

1 - `composer install`
2 - `docker compose up -d`
3 - `php artisan migrate`


### Startar projeto

#### Verficar se o container `db` está criado e startado, caso contrario execute `docker compose up -d`

1 - `php artisan serve`
2 - `php artisan queue:work`

acesse: `/prices` para verificar se listou.
