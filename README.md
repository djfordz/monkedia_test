clone the repo.

run `npm install && composer install`

create database and user called monkedia_test. Can change config in `pp/Config/_config.json` if needed.

import data in _install/monkedia_test.sql.gz

`zcat _install/monkedia_test.sql.gz | mysql monkedia_test` (or whatever you named the database);

add host entry `127.0.0.1 monkedia.io` to your hosts file

tested with nginx. nginx config is as follows

```
server {
    server_name monkedia.io;
    root /home/dford/web_projects/monkedia_test;

    location / {
        index index.php;
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_pass fastcgi_backend_56;
        fastcgi_buffers 1024 4k;
        fastcgi_read_timeout 600s;
        fastcgi_connect_timeout 600s;

        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

navigate to [http://monkedia.io](http://monkedia.io) (if you added a hosts entry to your hosts file)

otherwise change base url in config. Change desired config in app/Config/_config.json


```
{
    "url": "http://monkedia.io/",
    "database": {
        "type": "mysql",
        "host": "localhost",
        "name": "monkedia_test",
        "user": "monkedia_test",
        "password": "monkedia_test"
    }
}
```

Currently Hosted at [http://mefu.ninja](http://mefu.ninja);
