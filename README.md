## PASSO A PASSO

### Configurar server e banco de dados

 - `composer install`
 - `docker compose up -d`
 - `php artisan migrate`


### Inicializar o projeto

#### Verficar se o container `db` está criado e startado, caso contrario execute `docker compose up -d`

 - `php artisan serve`
 - `php artisan queue:work`

acesse: `/prices` para verificar se listou.
