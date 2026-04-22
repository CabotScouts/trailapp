# Roadmap

* Get app properly built into a container (how does the UI work with this?)
* Terraform to setup a DigitalOcean droplet
* Ansible to setup server with Docker engine, mariadb, traefik, and the app
* Container registry to stick the images in
* Switch redis to valkey
* Change up websocket server => soketi to https://github.com/sockudo/sockudo

## Required containers
* Ingress: traefik
* Database: mariadb
* In memory datastore: valkey
* Websockets: sockudo
* App: trailapp (scaled)
* Queue: trailapp-cli
* Scheduler: trailapp-cli

## Ingress
Setup traefik config with three entry points (80, 443, 6001), with one domain and letsencrypt enabled

## Database
Initialise mariadb - create db from config, generate random login and save

## Valkey
Initialise some random credentials?

## Sockudo
Also just needs random credentials?

## trailapp
App built with PHP and Apache
UI built in npm container and copied across
composer copied from composer container
composer install run

## trailapp-cli
App built with PHP-cli container
