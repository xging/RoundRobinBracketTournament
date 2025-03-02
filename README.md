
# Project Documentation

## Table of Contents
1. [Introduction](#introduction)
2. [Installation](#installation)
3. [Usage with Symfony PHP](#usage-with-symfony-php)


---

## Introduction
Round Robin and Bracket tournament. 

**PLANS**
- Implement Redis for better perfomance.
- Implement Frontend, NextJS.
- PHPUnit tests
  

Project structure:
- backend (Symfony PHP, RabbitMQ, Redis)
- frontend (next.js, typescript)
  - docker (next.js)
- docker (mysql, nginx, php-fpm)
---

## Installation
Follow these steps to install the project:
- Necessary to Install Docker and Composer
1. Clone the repository:
   ```bash
   git clone https://github.com/xging/RoundRobinBracketTournament.git
   
2. Build and start containers with Docker Compose
   ```bash
   docker-compose up --build

## Usage with Symfony PHP
### * In order to run the async process, you need to run the consumer
### * Execute commands in Docker PHP container
    docker exec -it symfony-php-container bash
    
0. Run RabbitMQ сonsumer
   ```bash
   php bin/console messenger:consume -vv
   
1. Build Tournament, it will prepare divisions, teams, teams results, matches for match start. (Async)
   ```bash
   php bin/console app:build
   
2. Start match
   ```bash
   --Execute one time
   php bin/console app:start-match "Division_A"
   --Execute one time
   php bin/console app:start-match "Division_B"
   --Execute three times
   php bin/console app:start-match "Playoff"

## HTTP Request
0. Build tournament:
   ```bash
   http://localhost:8080/api/tournament

1. Start match for all teams in division:
   ```bash
   http://localhost:8080/api/tournament/start-match/Division_A
   http://localhost:8080/api/tournament/start-match/Division_B
   http://localhost:8080/api/tournament/start-match/Playoff

2. Check mactches list:
   ```bash
   http://localhost:8080/api/matches/all

3. Check results:
   ```bash
   http://localhost:8080/api/matches/results_20


