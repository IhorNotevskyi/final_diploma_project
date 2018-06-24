В api/.env нужно выставить свои данные для доступа к БД<br>
в api/.env.dist пример заполнения: DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name<br>
я сбросил свои данные, если у тебя там пароль есть к БД или БД будет по-другому называться, то нужно исправить<br>

потом:<br>
cd api<br>
composer install<br>

cd client<br>
npm install<br>

в одной консоли:<br>
cd api<br>
bin/console server:start<br>

в другой консоли:<br>
cd client<br>
npm start<br>

должно работь<br>

на http://localhost:8000/api все данные<br>
на http://localhost:8000/api/products можно посмотреть в каком виде данные приходят<br>
