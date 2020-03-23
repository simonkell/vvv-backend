# VolunteerVsVirus Backend

Wir verbinden freiwillige Helfer und medizinische Einrichtungen
* [Project overview](https://devpost.com/software/1_024_a_krankenhauser-if-schleife)
* [Frontend git](https://github.com/noelelias/vvv-frontend)
* [Frontend](https://app.volunteervsvirus.de)

## Try it youself... locally!
Clone the project and get it running on a local http hosting such as XAMPP. 
Everything is included except the following config.php which has to be placed into the project directory:

```php
<?php
// This is for your mysql database
$servername = ''; // E.g. when you run locally, this will be 'localhost'
$username = ''; // Username for your database
$password = ''; // Password for your database
// This is for your smtp server.
$mailPw = ''; // TODO: This is not fully configurizable yet, sorry guys! :-(
```

To talk to our backend, you could need some help by SoapUi or any other REST application of your choice.
Using SoapUi, we have created [THIS](VolunteersVsVirus-SOAPUI-REST_backend_calls.xml) project to work with the backend.

## Backend's functions and what they require
The backend is communicating using json requests and responses. Following functions are implemented so far:

**(this documentation will be extended in the next days *- last state: 23.03.2020*)**
- [x] endpoints/auth/
- [ ] endpoints/institutionProfile/
- [ ] endpoints/volunteerProfile/
- [ ] endpoints/confirmationKey/

#### /endpoints/auth/
Result headers:
* HTTP 200: Everything worked fine!
* HTTP 400: There went something wrong. Errors will be received as JSON array
* HTTP 401: Unauthorized: Is the user logged in? Most probably not.

##### register.php
Type: POST\
Body: JSON
```json
{
	"email": "",
 	"pass": ""
}
```

##### login.php
Type: POST\
Body: JSON
```json
{
	"email": "",
 	"pass": ""
}
```

##### logout.php
Type: GET\
Body: None

##### change.php
Type: POST\
Body: JSON
```json
{
    "id":  "",
    "email": "",
    "forename": "",
    "surname": ""
}
```

##### changePassword.php
Type: POST\
Body: JSON
```json
{
    "email": "",
    "passwordOld": "",
    "passwordNew": ""
}
```

## How-Tos

These instructions will get you a copy of the backend up and running on your local machine or server for development and testing purposes.

### Docker

1. Start docker
2. Open shell/cmd in the root folder
3. Enter docker-compose up
	
Now you can access the backend on port 8001 and phpmyadmin on port 8000. You can login into phpmyadmin with the following login: 'user' and password: 'test'. 

### API-Endpoints

The following API-Endpoints are available through this backend: https://docs.google.com/document/d/1W5YEYDJ3H4pCuPrSsXS0OftaG_0oMlIJ037p7Ys7-xw/edit#

### Deployment

Deployment of master-branch to production is ensured through pipeline
