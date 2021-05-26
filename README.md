## Spis treści
* [Opis projektu](#opis-projektu)
* [Wykorzystane technologie](#wykorzystane-technologie)
* [ENV Laravelowy](#env-laravelowy)
* [Start projektu](#start-projektu)

## Opis projektu
Projekt przedstawia podstawowe REST API z autentyfikacją JWT, z którego można skorzystać po uprzednim zarejestrowaniu się.
W projekcie można swobotnie dodawać, usuwać oraz edytować wprowadzone samochody, korzystająć z aplikacji POSTMAN.

Projekt powstał na życzenie osoby rekrutującej.

### Wykorzystane technologie  

- Php v. 7.4.9
- Laravel v. 8.0+

#### ENV Laravelowy
    Wymagane jest połączenie do podstawowej baz danych.
    Standardowy plik env.
    
    Przykładowe polączenie do bazy wapteki lokalnie: 
    DB_HOST=localhost
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=
    
#### Start projektu
 Po otworzeniu projektu i zalogowaniu się do aplikacji POSTMAN wykorzystujemy jej możliwości poprzez odpoweiednie url.
 (Pamiętaj o migracji) 
 Aplikacja zaiwera CarsFactory.php oraz UserFactory.php, które pomogą zapełnić bazę danych.
 
POST   api/auth/register
POST   api/auth/login
POST   api/auth/logout
POST   api/auth/refresh
GET    api/auth/profile

oraz (należy pamiętać o wykorzystaniu bearer Token)

GET    api/cars   - wyświetli samochody stworzone przez wybranego usera
POST   api/cars   - utworzy nowy obiekt
PUT    api/cars/{id}  - zmodyfikuje wybrany obiekt
DELETE   api/cars/{id}  - usuwa wybrany obiekt z bazy danych




    Readme created 2021-05-26
