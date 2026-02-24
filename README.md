## Formulaire

### Lancer le projet

```bash
docker compose up -d
```

### Migrer la base de données

(variables a éditer dans migrate.php si besoin)
```bash
php migrate.php
```

### Lancer les tests

```bash
php vendor/bin/phpunit tests/
```

### Lancer le linter

```bash
php vendor/bin/phpstan analyse tests *.php
```