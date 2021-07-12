## Getting Started

### Requirements
- Docker

<hr>

### How to begin?
- Clone this repository:
```bash
git clone https://github.com/luispaulotoniettefranca/short.git
```

<hr>

- Access project folder
```bash
cd short/
```

<hr>

- Rename ``` .env.example ``` file to ``` .env ```
- Adjust ``` .env ``` file as you want
  
<hr>

- Run:
```bash
docker run --rm \ -u "$(id -u):$(id -g)" \ -v $(pwd):/opt \ -w /opt \ laravelsail/php80-composer:latest \ composer install --ignore-platform-reqs
alias sail='bash vendor/bin/sail'
sail up -d
sail composer install
sail artisan key:generate
sail artisan migrate
```
<hr>

- Access the endpoints through this base URL:
```bash
http://localhost/api/
```
