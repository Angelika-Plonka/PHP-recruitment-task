# < Black Company > - PHP Developer recruitment task

Your task is very simple:

1. Prepare new endpoint „/api/v1/users” in REST API, which creates the user in the database.
2. Prepare display all users (provided by endpoint) as a list "/users"


###Information about task
The user has following data:	

1. firstname
2. surname
3. country code (only PL or DE) in ISO 3166-1 alfa-2 standard - more info here: https://pl.wikipedia.org/wiki/ISO_3166-1_alfa-2
4. identification number
    1. for PL will be a PESEL (11 digits) -> description of validation  https://pl.wikipedia.org/wiki/PESEL
    2. for DE will be a die Identifikationsnummer (11 digits) -> description of validation https://de.wikipedia.org/wiki/Steuerliche_Identifikationsnummer#Aufbau_der_Identifikationsnummer


###Requirements
1. All data (firstname, surname, country code, identification number) for user are required.
2. We serve only users from Poland and Germany. If user comes from another country, we should receive an error from the response API.
3. The endpoint „/api/v1/users” before writing new user to the database should check the identification number if it's correct, i.e. it has the correct check digit and control sum.
4. If the identification number or country code is incorrect then response should return code 422 and contains an error messages. Example:
```
{
    "code": 422,
    "message": "Validation Failed";
    "errors": {
        „identificationNumber": "Invalid value for identificationNumber.",
        „country": "Invalid value for country."
    }
}
```
5. If any field is empty in request then response should return code 422 and contains an error messages. Example:
```
{
    "code": 422,
    "message": "Validation Failed";
    "errors": {
        "firstName": "This value should not be blank.",
        "country": "This value should not be blank." 
    }
}
```
6. If the creation of a user in the database succeeds, then response should return code 201 and the unique ID of the new user that will be assigned in the application. Example:
```
{
  "userId": "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx" 
}
```


###Rules

**We would like to get a working code.**

**You're welcome to improve our code**

**If something is not specified or explained please do it according to your own idea! :)**

**You should send us a GitHub/BitBucket link to repository (remember to keep commits clean) or zip file with the whole project.**


##Good luck!





## Installation

1. Run `make install`
2. Add following lines to /etc/hosts (For MacOS with docker-machine if using different system change IP):

```
192.168.99.100 backed-recruitment-task.local
```


## Usage

1. `make start`
2. Website is accessible through `backed-recruitment-task.local`
4. To down `make down`