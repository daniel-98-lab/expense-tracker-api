# Expense Tracker API

API for an expense tracker application.

Challenge from [expense-tracker-api](https://roadmap.sh/projects/expense-tracker-api).

## Features

- CRUD operations for expenses
- CRUD operations for categories
- User authentication (login, get user details, token refresh)
- Middleware-protected routes
- Implements hexagonal architecture

## Prerequisites

- [Docker](https://www.docker.com/) installed on your machine.
- [Postman](https://www.postman.com/downloads/) (Optional) to test API calls.

## Installation

1. Clone the repository:
    
    ```bash
    git clone https://github.com/daniel-98-lab/expense-tracker-api.git
    cd expense-tracker-api
    ```

2. Copy the environment configuration file:
    
    ```bash
    cp .env.pro .env
    ```

3. Start the Docker Compose services:
    
    ```bash
    docker compose up -d
    ```

4. Install Laravel dependencies:
    
    ```bash
    docker exec -ti expense-tracker bash -c "cd .. && composer install"
    ```

5. Add the application domain to the hosts file:
    
    ```bash
    echo "127.0.0.1 $(grep APP_DOMAIN .env | cut -d '=' -f2)" | sudo tee -a /etc/hosts
    ```

6. Run database migrations and seed data:
    
    ```bash
    docker exec -ti expense-tracker bash -c "cd .. && php artisan migrate --seed"
    ```

7. Generate the JWT secret key:
    
    ```bash
    docker exec -ti expense-tracker bash -c " cd .. && php artisan jwt:secret"
    ```

## API Examples

Reminder! If your API call response is: 'Unauthenticated', maybe your token has expired. You need to log in again and update the token.

All API request examples are available in [this file](./docs/expense-tracker-api.postman_collection.json). If you have the Postman app, simply import this file to access all API calls.

---