# Projeto Favelax API

* Laravel10x
* Autentificão Passport
* ACL controle de niveis de acesso - Policy
* Token Bearer
* CRUD usuários individualizado por niveis.

**A parte**

* Data Tranfer Object(DTO)
* SoftDelete nos Users
* Docker

## Referência

 - [Ponte pé inicial do Guard Passport](https://www.webappfix.com/post/laravel-9-multi-authentication-guard-passport-api-example.html)
 - [Laravel Guard Passport](https://laravel.com/docs/10.x/passport#main-content)
 - [DTO](https://dev.to/emrancu/data-transfer-object-dto-in-laravel-5apa)
 - [SoftDeletes](https://laravel.com/docs/10.x/eloquent#soft-deleting)

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
    
## Explicando um pouco

Usei como ponta pé inicial o artigo linkado aqui.

Segui a lógica para criação de uma Tabela de administradores separado dos usuários padrões, onde nos administradores temos o campo role_id, onde está associado a o role que traz as devidas habilidades da role, associação N:N, a ideia é dar liberdade para criação personalidade de ambos, sendo somente obrigatório qualquer usuário administrador ter um role_id.

## Melhorias

adicionar tabela para indexar múltiplos relacionamentos entre tabela roles e Ability 
