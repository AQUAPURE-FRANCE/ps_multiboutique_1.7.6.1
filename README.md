# MULTIBOUTIQUE

On project
---
- Download prestashop files from the live server
- Copy files in `htdocs` or `wwww` folder depending on server being used: `wamp`,`mamp`, `xampp`. You can create
a subfolder for the project
- Delete `.htaccess`
- Delete `var/cache/dev` and `var/cache/prod`

#### In `app/config/parameters.php`
- Update `database_host` to your local database server
- Update `database_name` if you have changed default database name
- Update `database_password` if any

On database
---
- Export live database with default settings
- Import live database in local database

#### In `ps_configuration`
- Set `PS_SHOP_DOMAIN` to `localhost`
- Set `PS_SHOP_DOMAIN_SSL` to `localhost`
- Set `PS_SSL_ENABLED` to `0`

#### In `ps_shop_url`
- Set `domain` to `localhost`
- Set `domain_ssl` to `localhost`
- Set `physical_uri` to `subfolder(s) created for the project` (if any)

On backoffice
---
- Disable `URL simplifiée` in `CONFIGURER|Trafic et SEO`. Then Save.
- Enable `URL simplifiée` in `CONFIGURER|Trafic et SEO`. Then Save.