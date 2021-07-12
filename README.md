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
- Run:
```bash
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
