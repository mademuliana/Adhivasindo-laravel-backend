# Laravel API Project

This is a Laravel-based API that includes authentication via Laravel Passport, scheduled tasks, and database seeding.

## 📌 Prerequisites

Make sure you have the following installed before proceeding:

- [PHP](https://www.php.net/downloads.php) (≥ 8.0 recommended)
- [Composer](https://getcomposer.org/download/)
- [MySQL](https://dev.mysql.com/downloads/)
- Laravel CLI (`composer global require laravel/installer`)

## 🚀 Installation Steps

### 1️⃣ **Clone the Repository**
```sh
git clone https://github.com/mademuliana/Adhivasindo-laravel-backend.git
cd the-repository
```

### 2️⃣ Install Dependencies
``` sh
composer install
```

### 3️⃣ Set Up Environment Variables
Copy .env.example to .env:

```sh

cp .env.example .env
```
Update your .env file with your database and mail credentials:
```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```
and remember to change the value of STUDENT_DATAS_URL for the scheduler working properly, example
```sh
STUDENT_DATAS_URL=https://ogienurdiana.com/career/ecc694ce4e7f6e45a5a7912cde9fe131
```

### 4️⃣ Generate Application Key
```sh
php artisan key:generate
```
### 5️⃣ Run Database Migrations & Seeders
```sh
php artisan migrate --seed
```
### 6️⃣ Set Up Laravel Passport (Authentication)
```sh
php artisan passport:install
php artisan passport:client --personal
```
Note: Using php artisan passport:client --personal eliminates the need to re-install Passport.

### 7️⃣ Schedule Tasks (Cron Jobs)
in this project uses the scheduler to automate commands for checking the latest data in the STUDENTS_DATA_URL, to keep the data updated at realtime speed. Run this to execute scheduled tasks manually:

```sh
php artisan schedule:run
```
Run this to execute scheduled tasks periodicaly:
```sh
php artisan schedule:work
```
To automate it, set up a cron job:
```sh
* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
```
### 8️⃣ Start the Application
```sh
php artisan serve
```
and this message should appear
Your API is now running at http://127.0.0.1:8000 🚀.


🔑 Authentication (Laravel Passport)
For personal access tokens, use:
POST /api/login
```sh
{
    "email": "user@example.com",
    "password": "your_password"
}

```
Include the token in the Authorization header for protected routes:

makefile
Authorization: Bearer your_token

🛠 API Endpoints

|   Method    |   Route    |   Controller & Method    |   Middleware    |   Description    |   
|   ------    |   -----    |   -------------------    |   ----------    |   -----------    |   
|   POST    |   /api/login    |   AuthenticationController@login    |   None    |   User login (returns API token)    |   
|   GET    |   /api/student-profile    |   UserController@studentProfile    |   auth:api, RoleMiddleware:student    |   Get authenticated student's profile    |   
|   GET    |   /api/student-search    |   StudentController@search    |   auth:api, RoleMiddleware:admin    |   Search for students    |   
|   POST    |   /api/create-student    |   UserController@createStudent    |   auth:api, RoleMiddleware:admin    |   Create a new student and user account at the same time    |   
|   GET    |   /api/users    |   UserController@index    |   auth:api, RoleMiddleware:admin    |   Get all users    |   
|   POST    |   /api/users    |   UserController@store    |   auth:api, RoleMiddleware:admin    |   Create a user    |   
|   GET    |   /api/users/{id}    |   UserController@show    |   auth:api, RoleMiddleware:admin    |   Get user by ID    |   
|   PUT    |   /api/users/{id}    |   UserController@update    |   auth:api, RoleMiddleware:admin    |   Update user    |   
|   DELETE    |   /api/users/{id}    |   UserController@destroy    |   auth:api, RoleMiddleware:admin    |   Delete user    |   
|   GET    |   /api/students    |   StudentController@index    |   auth:api, RoleMiddleware:admin    |   Get all students    |   
|   POST    |   /api/students    |   StudentController@store    |   auth:api, RoleMiddleware:admin    |   Create a student    |   
|   GET    |   /api/students/{id}    |   StudentController@show    |   auth:api, RoleMiddleware:admin    |   Get student by ID    |   
|   PUT    |   /api/students/{id}    |   StudentController@update    |   auth:api, RoleMiddleware:admin    |   Update student    |   
|   DELETE    |   /api/students/{id}    |   StudentController@destroy    |   auth:api, RoleMiddleware:admin    |   Delete student    |   

🔧 Troubleshooting
If you encounter any issues, try:

```sh

php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan migrate:fresh --seed
```

📜 Notes

the included file like postman collection and database sql file is named as below
```sh
postman collection: Adhivasindo backend.postman_collection.json
database: db.sql
```
📜 License
This project is open-source and available under the MIT License.

🎯 Contribution
If you'd like to contribute, fork the repository and submit a pull request. 🙌

📩 Need Help?
If you have any questions, feel free to open an issue or reach out! 🚀

markdown


---

### **💡 Key Features Included**
✅ **Scheduling:** Instructions for `php artisan schedule:run` and setting up cron jobs  
✅ **Passport:** Using `php artisan passport:client --personal` to skip re-installation  
✅ **Seeding:** Runs migrations and seeds in one step  
✅ **Authentication & API Usage:** Shows how to log in and use API tokens  
✅ **Troubleshooting Commands**  

This README ensures **any developer** can run your Laravel API **without confusion**. 🚀 Let me know if
