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

### /endpoints/auth/
Result headers:
* HTTP 200: Everything worked fine!
* HTTP 400: There went something wrong. Errors will be received as JSON array
* HTTP 401: Unauthorized: Is the user logged in? Most probably not.

#### /endpoints/auth/```register.php```
Type: POST\
Body: JSON
```json
{
	"email": "",
 	"pass": ""
}
```

#### /endpoints/auth/```login.php```
Type: POST\
Body: JSON
```json
{
	"email": "",
 	"pass": ""
}
```

#### /endpoints/auth/```logout.php```
Type: GET\
Body: None

#### /endpoints/auth/```update.php```
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

#### /endpoints/auth/```updatePassword.php```
Type: POST\
Body: JSON
```json
{
    "email": "",
    "passwordOld": "",
    "passwordNew": ""
}
```

### endpoints/institutionProfile/

#### endpoints/institutionProfile/```create.php```
Type: POST\
Body: JSON
```json
{
    "name": "",
    "street": "",
    "house_number": 0,
    "postal_code": "",
    "city": "",
    "description": ""
}
```

#### endpoints/institutionProfile/```change.php```
Type: POST\
Body: JSON
```json
{
    "institution_profile_id": 0,
    "name": "",
    "street": "",
    "house_number": 0,
    "postal_code": "",
    "city": "",
    "description": ""
}
```

#### endpoints/institutionProfile/```all_by_user_id.php```
This will be changed in further version. 
There was a miscommunication while development so this returns an array of 1.

Type: POST\
Body: JSON
```json
{
    "user_id": 0
}
```

#### endpoints/institutionProfile/```by_id.php```
Type: POST\
Body: JSON
```json
{
    "id": 0
}
```

#### endpoints/institutionProfile/```is.php```
Returns a boolean as json telling if the specified user is an institution.

Type: POST\
Body: JSON
```json
{
    "user_id": 0
}
```

#### endpoints/institutionProfile/```list_nearby.php```
Returns an array of institutions nearby for the user that is logged in. Obviously, the user has to have a volunteer profile created.

Type: GET\
Body: None

### endpoints/volunteerProfile/

#### endpoints/volunteerProfile/```create.php```
Type: POST\
Body: JSON
```json
{
    "time_from": "",
    "time_to": "",
    "radius": 5,
    "drivinglicense": "",
    "medical_experience": "",
    "postal_code": "",
    "bio": "",
    "phone": ""
}
```

#### endpoints/volunteerProfile/```change.php```
Type: POST\
Body: JSON
```json
{
    "volunteer_profile_id": 0,
    "time_from": "",
    "time_to": "",
    "radius": 5,
    "drivinglicense": "",
    "medical_experience": "",
    "postal_code": "",
    "bio": "",
    "phone": ""
}
```

#### endpoints/volunteerProfile/```by_user_id.php```
Type: POST\
Body: JSON
```json
{
    "user_id": 0
}
```

#### endpoints/volunteerProfile/```by_id.php```
Type: POST\
Body: JSON
```json
{
    "id": 0
}
```

#### endpoints/volunteerProfile/```is.php```
Returns a boolean as json telling if the specified user is a volunteer.

Type: POST\
Body: JSON
```json
{
    "user_id": 0
}
```

### endpoints/confirmationKey/

#### endpoints/confirmationKey/```userConfirmation.php```
This is a temporary solution for having a user confirmation without any frontend.
Key will be used for activation and removed if correct. Correct or not, the user will be redirected immediately.

Type: GET\
```
http://api.volunteervsvirus.de/endpoints/confirmationKey/userConfirmation.php?key=<CONFIRMATION_KEY>
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
