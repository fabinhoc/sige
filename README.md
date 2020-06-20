# SIGE - Sistema de gerenciamento de empresas

Sistema desenvolvido em PHP para controle de Empresas e funcionários da empresa.
  - Create, update, list e delete de empresa
  - Create, update, list e delete de usuários
  - Create, update, list e delete de funcionarios

## Tech
* [Docker] - Rodando em ambiente virtualizado do windows 64
* [Laravel] - Laravel 7.x
* [PHP Unit] - Testes automatizados
* [API] - Conceito de API RESTFulls

## Instalação

Clonar repositório a partir do link gerado do github;

Acessar pasta do repositório clonado:
```sh
$ cd sige
```
Rodar comando para configuração do ambiente docker:

Configurações de portas e requitos do docker você encontra na pasta `sige/phpdocker/
` e nas configurações do arquivo `docker-compose.yml`
```sh
$ docker-compose up -d
```
## Laravel

```sh
$ cd /sige/src
$ docker-compose exec php-fpm composer install
```
Acesse via browser a url a seguir e poderá ver a pagina inicial do laravel:
http://localhost:8000

#### Migration
```sh
$ cd /sige/src
$ docker-compose exec php-fpm php artisan migrate
```
#### Seed
```sh
$ cd /sige/src
$ docker-compose exec php-fpm php artisan db:seed
```
### Testes
```sh
$ cd /sige/src
$ docker-compose exec php-fpm php artisan tests
```
Para testar a aplicação recomendo utilizar o https://insomnia.rest/ acessar as rotas e realizar os testes. Importe as rotas para o insomnia a partir do arquivo `Insomnia_2020-06-20.json`

O frontend do projeto você encontra neste repositório https://github.com/fabinhoc/sige-frontend
