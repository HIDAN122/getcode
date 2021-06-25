# Інструкція
1. Запустити
```
git clone git@github.com:oleksiiu/getcode_import.git
```
2. Перейти на https://github.com/settings/tokens та створити персональний токен
3. У папці проекту запустити ```composer config github-oauth.github.com <token>```
4. Запустити ```composer install```
5. Запустити команду ```php artisan getcode:generate-test```
