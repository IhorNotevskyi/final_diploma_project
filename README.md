В api/.env нужно выставить свои данные для доступа к БД
в api/.env.dist пример заполнения: DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
я сбросил свои данные, если у тебя там пароль есть к БД или БД будет по-другому называться, то нужно исправить

потом:
cd api
composer install

cd client
npm install

в одной консоли:
cd api
bin/console server:start

в другой консоли:
cd client
npm start

должно работь

на http://localhost:8000/api все данные
на http://localhost:8000/api/products можно посмотреть в каком виде данные приходят
