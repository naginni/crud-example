# CRUD Example
This is an example how to use PHP managing an API. This small APP creates, reads, updates and deletes items from the [Swagger](https://petstore.swagger.io/#/pet/addPet) end point. This app is running in Docker container for an easy life.

## Prerequisites
This small app requires that you have nginx or something similar to run it in you localhost. However, you can use this container that already has configured [nginx-proxy](https://github.com/studionone/docker-nginx-proxy).

- Docker

## Run
1. If you want to run it with `nginx-proxy` just download or clone the project and run the container.
    ```
        cd docker-nginx-proxy/
        docker-compose up -d
    ```
2. Clone **CRUD Example** and build it with docker-compose
    ```
        cd crud-example/
        docker-compose build && docker-compose up -d
    ```
3. Save the virtual host `crudexample.docker` into your `/etc/hosts`
4. Now open your browser and go to [crudexample.docker](crudexample.docker/)


## Test
You can start listing, creating, updating and deleting pets just by clicking in the links and filling up the form.
Furthermore, if you want to practice you can continue with the other end-points and practice if it works.

## Code
This code is pretty simple and you can follow through. However, the main logic and the core of this APP is located in two files.
- `code/src/classes/Pet.php`
- `code/src/helpers/Helpers.php`
These two classes have the main logic that is connecting to the end-points with `CURL` and the different calls necessary to work with `POST, PUT, GET & DELETE`.


#### NOTE:
There is not major validation and it is saving the element ids into a file instead of doing it into the database but for this example it is not necessary to use a full database. However, the end-point should have one api to list all records but at the moment I don't see it available.


