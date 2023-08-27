# Hostelia

![A screenshot of the Home page][Home-Screenshot]

Hostelia is a small-basic Hostel Management System. I built the system usig my old PDO Database Connector. The system follows a slightly different MVC Pattern and makes use of Bootstrap CSS Framework.

---

**NB**: The system is not production ready and may need to be evaluated further.

## System Configuration

The first thing you should do is install the `0001.sql` migration file from your phpmyadmin. Neglecting that will cause errors. The file will create all the necessary tables.

### Managing Admin Accounts

As I was working on another project, I did not add a feature to manage the Admin Accounts. You can easily do so though from PHPMyAdmin. Simply change the `is_admin` column to 1 for the user you want to make an admin. If they were already logged in, they may have to log out first to see changes as the status is stored in their session.

By default, I use the common database connection usernames and no password. You can change these in the `config.php` file in the backend folder.

In this file, you can also change the name of the School.

## Concept

Before I continue, do note that the system does not use any type of autoloading, therefore all files must be included manually.

### Routing

The system does not use any type of special routing. However, it is important to note that all files in the **frontend** directory will be available for access from the browser.

### Controllers

Each (php) file in this folder can run without a Controller but I chose to use one as a standard. If you do want to use Controllers, just create a Class File in the **backend/Controllers** directory and extend the `Controller.php` class.

### Models

All database models are in the backend folder under Models. Theyall extend the base `Model.php` file in the directory. These basically communicate with the database providing errors as they occur.

### Views

While generally the Views are stored in this folder, it wasn't necessary with this system as it uses file routing. Therefore, I chose to add View Components into this folder.

To make it more interesting & fun, I added the function `render_component($name, $params = [])` to make is easier to include these parts and even pass parameters.

### System

This is where I keep some system functions. You could add as many as you'd like of course.

### Farewell

I hope I left the project at a better position for modifications. I know there's a lot that can be added, modified and removed so take this as a starting point.

[Home-Screenshot]: ./Hostelia%20Home.png