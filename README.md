# auth_service_st

To run this application you have to have php 7.3 and rabbitmq running on your local machine.
All user files are stored in project dir in "storage" folder.
Analytic files are stored in project dir in "storage/analytic" folder.

To process ampq messages run 
```sh
bin/console messenger:consume messages
```

# Install composer dependencies
```sh
composer install
```

# Generate public and private key for JWT auth
From project root dir run
```sh
$ mkdir config/jwt
$ openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
$ openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout 
```

# Run server
e.g. 
```sh
bin/console ser:run 0.0.0.0:9088
```

# API Usage example
1. Registration
Route:
```bash
/register
```
Input Json:
```bash
{
	"username" : "elya",
	"password" : "123",
	"age" : 24,
	"firstname" : "eleonora",
	"lastname" : "korobova"
}
```
Result in case of success:
```bash
{
    "status": true,
    "userId": "5fe6172d5ed91"
}
```

2. Login
Route:
```bash
/api/login_check
```
Input Json:
```bash
{
	"username" : "elya",
	"password" : "123"
}
```
Result in case of success:
```bash
{
    "token": "somerandomtoken",
}
```

3. Track Action
You can either pass your JWT into headers as Authorization: Bearer {token}
or send request anonymously, in that case system will get user id from cookies, or
generate it
Route:
```bash
/api/track_action
```
Input Json:
```bash
{
	"source_label" : "some_label",
}
```
Result in case of success:
```bash
{
    "status": true,
}
```
