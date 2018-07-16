In api/.env you need to set up your data:<br>
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name<br>
And if you want to send a message on email when creating a new administrator (in api/.env):<br>
MAILER_URL=gmail://username:password@localhost<br>

Then:<br>
cd api<br>
composer install<br>

cd client<br>
npm install<br>

In one console:<br>
cd api<br>
bin/console server:start<br>

In another console:<br>
cd client<br>
npm start<br>

Should work<br>

On http://localhost:8000/api are all the data<br>
On http://localhost:8000/api/products you can see what kind of data comes in<br>
