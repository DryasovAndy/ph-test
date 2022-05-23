## Environment
 - Docker
 - Symfony 6.0
 - php 8.1
 - API Platform for generating API and documentation
 - lexik/jwt for authentication
 - phpUnit for tests

## Installation
To set up a project open terminal in the root of project and execute: ```make install```

For preparing test environment: ```make prepare_test_env```

To run tests: ```make test```

## Describing of API opportunities
You could find API docs on: http://127.0.0.1:8888/api/docs

For creating user in app you need POST http://127.0.0.1:8888/api/register with body { "username": "username", "password": "123456"} (example). It creates user for app. 

For auth (login) you need token by api POST http://127.0.0.1:8888/api/login with body { "username": "username", "password": "123456"} (example). It returns jwt token for auth.

Method for search countries by code or name: GET http://127.0.0.1:8888/api/countries/search. In params could be code, name. Or combination of them. Should be at least one parameter in request.

Method for update country code: PATCH http://127.0.0.1:8888/api/countries/{id}. In body could be code, name, prefix. Or combination of them. Should be at least one parameter in request.
It needs auth.

## Frontend part
You can find frontend part on folder public/frontend/. Example http://127.0.0.1:8888/frontend/index.html. Unfortunately, it's not finished. Just templates and some js code.