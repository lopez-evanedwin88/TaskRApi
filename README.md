# CodeIgniter 3 on Docker

This repository provides a Dockerized environment for running CodeIgniter 3 applications. It utilizes the official PHP Docker image and includes the latest version of CodeIgniter 3.

## How to Run

To get started, follow these steps:

1. Clone this repository:
    ```bash
    git clone https://github.com/lopez-evanedwin88/TaskRApi.git
    ```

2. Navigate to the cloned directory:
    ```bash
    cd codeigniter-docker
    ```

3. Run the following command to start the Docker containers:
    ```bash
    docker-compose up -d
    ```

## Accessing the Containers

Once the containers are up and running, you can access the following services:

- **PHPMyAdmin:** Available at [http://localhost:8081](http://localhost:8081)
  - Use this interface to manage your MySQL databases.
  
- **CodeIgniter Application:** Available at [http://localhost:8080](http://localhost:8080)
  - This is where your CodeIgniter application will be accessible.

  ### Test Account
  - You can log in to the application using the following test account:
    - **Username:** `test@gmail.com`
    - **Password:** `test`
  
- **MySQL:** Accessible at port `3306`
  - Use this port to connect to your MySQL database from your applications.

## Running Migrations

To run migrations for your CodeIgniter application, you can use the following command within the CodeIgniter container:

```bash
docker-compose exec php-apache-environment php index.php migrate
```