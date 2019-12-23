# Customer CRUD Rest API

## api specification ##
https://app.swaggerhub.com/apis/dianakuzmina/customer_crud/1.0.0#/

# Docker build command
```
make create
```
(create: up composer migrate fixtures)

# cron task example
```
curl -d "name=boo&email=boo@example.com&isActive=true" -H "Content-Type: application/x-www-form-urlencoded" -X POST http://localhost:8080/rest/customer
```