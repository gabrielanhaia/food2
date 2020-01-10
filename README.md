# Laravel/AngularJS practical test

This repo has code to be used on practical tests using a platform that is close
to the production platform currently in use.

## Running the code

You need to have Docker (linux, windows or macos) and run the setup script located
at /dev_env from a bash compatible terminal (on windows we suggest you use
Ubuntu Linux Subsystem).

- cd dev_env
- ./setup.sh

Helpful video of the codebase layout and setup process from Pablo:
https://youtu.be/hsmQVdodzVE

## Accessing the Docker to run Artisan commands

If you need to run artisan commands (like migrations) the docker containers
have all the required tools for that. All you need to do is run docker exec
bash from the terminal as follows and you will be inside the docker container.

    docker exec -it test_platform_1 bash

Now you can just run 

    php artisan migrate

## Available logins

- Admin area: admin@test.acme / password
- Web area: user@test.acme / password

## Objectives

- Implement the migrations for the Data model stablished at 
database/database.png diagram
- Implement the routes and the controller required by the frontend for
get Collection, get, post, patch/put and delete
- Implement backend validations to create/edit forms and questions
- Implement the persistence of the data from the frontend to forms 
and questions (create and edit forms)
- Report any bugs found on the current structure

## The Problem

The full problem is exposed [here](/docs/Developer%20Intermission%20-%20Technical%20Test.pdf).
Please refer to this document for a complete view of what's the system 
supposed to implement and business rules.

## Sample data sent from frontend for persistence.

```json

{
  "id": null,
  "start_date": "15/01/2020",
  "end_date": "16/01/2020",
  "name": "Name of the Form",
  "description": "Description of the form",
  "introduction": "Introduction of the form",
  "questions": [
    {
      "id": null,
      "form_id": null,
      "description": "Question 1 description",
      "mandatory": 0,
      "type": "radio",
      "answers": [
        {
          "id": null,
          "valid_value": "Radio Answer 1"
        },
        {
          "id": null,
          "valid_value": "Radio Answer 2"
        },
        {
          "id": null,
          "valid_value": "Radio Answer 3"
        }
      ]
    }
  ],
  "start_publish": "2020-01-15",
  "end_publish": "2020-01-16",
  "deleted": {
    "questions": [],
    "answers": []
  }
}

```