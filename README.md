A flashcard application wich you can create and practice.

- Run these commands:
```
docker compose up --build -d
docker ps
docker exec -it container_id /bin/bash
```

- to access the app enter following command:
```
php artisan flashcard:interactive
```