# Helpdesk PT SKB & PT BPU
###### Services for managing assignment data for each division within the company
--------------------------------------------------------

### Requirements

<ul>
  <li> PHP >= 8.2 </li>
  <li> Composer >= 2.5.5 </li>
  <li> Laravel >= 9.0 </li>
</ul>

### Install

- clone this Repository 
``` 
git clone https://github.com/Marvelch/helpdesk.git
```
- copy and rename from .env_example to .env 
- configure .env 
```
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```
- run the following command to update
```
composer update
```
- generate app key 
``` 
php artisan key:generate 
```
- for the last stage run the command
```
php artisan serve
```
- open at the following url 
```
http://127.0.0.1:8000/
```
