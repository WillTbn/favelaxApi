# Projeto Favelax API

* Laravel10x
* Autentificão Passport
* ACL para controler de acesso, utilizado o Bouncer para esse controler
* Token Bearer

**A parte**

* Data Tranfer Object(DTO)
* SoftDelete nos Users

## Referência

 - [Laravel Passport](https://laravel.com/docs/10.x/passport#main-content)
 - [Bouncer eloquent authorization](https://github.com/JosephSilber/bouncer#customizing-bouncers-scope)
 - [DTO](https://dev.to/emrancu/data-transfer-object-dto-in-laravel-5apa)
 - [SoftDeletes](https://laravel.com/docs/10.x/eloquent#soft-deleting)

 _*ChatGPT logico ajudou muito*_



## Instalação
1. Apos clona o projeto e rode no terminal na pasta do projeto:

    ```
    composer install
    ```
2. Poderá utilizar o docker para cria o containeres do laravel,ele ira cria o projeto laravel e o banco mysql
configuração esta no docker-compose.yml
rode: 

```
docker composer up 
```

3. Lembre de copia o env.example dentro do tem 2 variaveis que é opcional mas aconselhaveu e colocar um valor de email no formado valido(obvio não precisa ser real) na USER_ADMIN_EMAIL e coloque uma senha de acesso na USER_ADMIN_PASSWORD.

4. rode as migrate mais as seed's

```
php artisan migrate --seed
````

5. Antes de roda o projeto rode passport para credencias 

``` 
php artisan passport:install  
```

Pronto basta acessa como administardo com o email e senha do .env que você colocou, se não consulte o DatabaSeeder.php para ver as credencias do mesmo e os demais usuários criado com comando `` --seed``.
    
## Autores

- [@willTbn](https://github.com/WillTbn)

