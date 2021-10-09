# Slack Voter

## Table of Contents

- [About](#about)
- [Getting Started](#getting_started)
- [Usage](#usage)

## About <a name = "about"></a>

Simple project that allows creating Events and Items. Then voting on those items per event.
   

## Getting Started <a name = "getting_started"></a>


### Prerequisites



1. Ensure [Docker](https://docs.docker.com/get-docker/) is installed
    - Optional: ensure you have Docker v20 or above installed to avoid DNS resolving issue.
2. Ensure [Docker-Compose](https://docs.docker.com/compose/install/) is installed

3. Optionally: ensure adding Docker and compose in the user group do you don't need to run `sudo` each docker command

### Installing

A step by step series of examples that tell you how to get a development env running.

using Docker Compose

1. Copy the env sample
```
cp .env.sample .env
```
2. Create docker network, for the containers to connect
```
docker network create slack-voter-network
```
3. Run the following command
```
docker-compose up -d
```
 - note: add flag `-d` to run it in daemon mode, remove it to see the build log
 - it might take a while for composer install

4. Optionally, if you want to seed some data run the command:
```
docker exec -it lets-vote-api bash -c "cd api/ && php artisan db:seed"
```


## Usage <a name = "usage"></a>

### How it works
In order to vote you need to create the following:
1. Event.
2. Item(s) to be voted one.

Then you will need to update the Event to add the desired Item(s) for voting.

After that you may vote (or remove vote) per Item per Event.


### APIs

#### Events
https://documenter.getpostman.com/view/17574897/UUxujAGV

#### Items
https://documenter.getpostman.com/view/17574897/UUxujAGY
