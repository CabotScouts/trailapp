# TrailApp
A web app to run a wide game/scavenger hunt type event, featuring questions and photo challenges.

[Jump to installation instructions](#getting-started)

## Answer questions and complete challenges
Submit answers & photos directly from the app

| [![Question view](docs/questions.png)](docs/questions.png) | [![Challenge view](docs/challenges.png)](docs/challenges.png) |
| --- | --- |
| [![Question submission](docs/question-submission.png)](docs/question-submission.png) | [![Challenge submission](docs/challenge-submission.jpg)](docs/challenge-submission.jpg) |

## Realtime feedback on submission being accepted/rejected
Control team able to accept/reject submissions that have been sent in - feedback given to teams in realtime.

| [![Dashboard submission view](docs/submission-received.jpg)](docs/submission-received.jpg) | [![Accepted notification](docs/submission-accepted.png)](docs/submission-accepted.png) |
| --- | --- |

## Realtime messaging from control to teams
Ability to broadcast messages out to teams (both to individual teams, and to all teams).

| [![Broadcast](docs/broadcast.png)](docs/broadcast.png) | [![Broadcast received](docs/broadcast-received.png)](docs/broadcast-received.png) |
| --- | --- |

## Supports multiple teams members working collaboratively
QR code allows other teams members to join the team and be submitting at the same time - realtime feedback to teams keeps all members in sync as they go.

[![Join with QR](docs/join-qr2.png)](docs/join-qr2.png)

## Simple dashboard interface
[![Dashboard](docs/dashboard.png)](docs/dashboard.png)

# Getting Started
Want to jump straight into testing the app? Try running *quickstart*:

- [Check prerequisites are installed](#prerequisites)
- Clone the repository: `git clone https://github.com/CabotExplorers/trailapp.git`
- Run *quickstart*: `./trail quickstart`
- [Open the app in your browser and login with username *root*, password *password*](http://127.0.0.1:8000)

## Custom installation
- Clone the repository: `git clone https://github.com/CabotExplorers/trailapp.git`
- Generate initial environment variables file: `./trail init`
- [Fill out environment variables depending on your setup](#environment-variables)
- Build app: `./trail build-all`
- Run database migrations: `./trail migrate`
- Create an initial user: `./trail add-user`
- [Setup your container ingress method](#ingress-method)
- Add your groups, questions, challenges, and other users via the dashboard.
- Start your trail!

### Prerequisites
The app makes use of containers to minimise the need for installing/configuring software, but still requires some essentials to get to that stage:

- Linux (either native or using Windows Subsystem for Linux) or macOS
- [git](https://github.com/git-guides/install-git) - for cloning this repository (comes with most Distros already)
- [docker](https://docs.docker.com/engine/install/) - for running containers
- openssl - for generating random strings (comes with most Distros already)

### Environment Variables

### Ingress Methods
