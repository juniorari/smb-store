
## SMB Store

### Sistema de Cadastro em Codeigniter com VueJS

1. Coonar o projeto
```shell
git clone git@github.com:juniorari/smb-store.git
```

2. Subir os containers
```shell
docker-compose up -d --build
```

3. Criar o banco de dados
```shell
docker-compose exec -T db mysql -u root -psmbstore smbstore < docker/db.sql
```


O projeto vai rodar na porta 8089: [http://localhost:8089](http://localhost:8089)



## Tecnologias
1. [CodeIgniter 4](https://codeigniter.com/user_guide/intro/index.html)
2. [Docker Compose](https://docs.docker.com/compose/)
3. [Docker PHP APACHE](https://hub.docker.com/_/php)
4. [Docker MySQL](https://hub.docker.com/r/mysql/mysql-server)
5. [Composer](https://getcomposer.org/doc/)
6. [VueJS](https://vuejs.org/)
7. [Materialize](https://materializecss.com/)
8. [Bulma.IO para o modal](https://github.com/jgthms/bulma/)
9. [Booststrap](https://getbootstrap.com/)
10. [Font Awesome 4.7.0](http://fontawesome.io)
