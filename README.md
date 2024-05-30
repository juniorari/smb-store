```shell
git clone git@github.com:juniorari/smb-store.git
```

```shell
docker-compose up -d --build
```


```shell
docker-compose exec -T db mysql -u root -psmbstore smbstore < docker/db.sql
```
