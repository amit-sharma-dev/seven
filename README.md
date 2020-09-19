## Incident Management

An incident is an event that could lead to loss of, or disruption to, an organization's operations, services or functions. Incident management is a term describing the activities of an organization to identify, analyze, and correct hazards to prevent a future re-occurrence.

##Routes
- GET /api/incidents - Retrieve Data
- POST /api/incidents - Store JSON Data

## Requirements

- [php 7.4](https://www.php.net/)
- MySql Database: [MySql](https://www.mysql.com)

## Installation

- Clone the repo
- Run command `composer install`
- Copy the .env.example to your own file: `cp .env.example .env`
- Set the config like `DB_HOST`, `DB_DATABASE` etc. in `.env`
- Start the server: `php artisan serve`
- Open the url: <http://127.0.0.1:8000>
- Use Postman or any other REST client to run api

##API payload example
- POST /api/incidents

`{
   "location": {
     "latitude": 12.9231501,
     "longitude": 74.781851
   },
   "title": "incident title",
   "category": "",
   "people": [
     {
       "name": "Name of person",
       "type": "staff"
     },
     {
       "name": "Name of person",
       "type": "witness"
     },
     {
       "name": "Name of person",
       "type": "staff"
     }
   ],
   "comments": "This is a string of comments",
   "incidentDate": "2020-09-01T13:26:00+00:00",
   "createDate": "2020-09-01T13:32:59+01:00",
   "modifyDate": "2020-09-01T13:32:59+01:00"
 }`
