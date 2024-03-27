Symfony Blog
Welcome to Symfony Blog, a web application for managing blog posts, categories, and user profiles.

Overview
Symfony Blog is built using the Symfony PHP framework, providing a robust and scalable architecture for handling various aspects of a blogging platform. The application is organized into several controllers, each responsible for different functionalities:

AdminsController: Manages administrative tasks such as viewing statistics, managing administrators, categories, and posts.
CategoriesController: Handles operations related to categories, including displaying posts within specific categories.
PostsController: Controls the creation, deletion, and editing of blog posts, as well as displaying single posts and managing comments.
UsersController: Manages user profiles, including updating user information and viewing user profiles.
LoginController: Handles user authentication and logout functionality.
RegistrationController: Manages user registration, including form submission and password hashing.

Features
Symfony Blog offers the following features:

Admin Dashboard: Provides an overview of post counts, category counts, and administrator counts.
User Management: Allows administrators to create, view, edit, and delete user accounts with different roles.
Category Management: Enables administrators to manage blog post categories, including creation, deletion, and updating.
Post Management: Facilitates the creation, editing, and deletion of blog posts, as well as displaying posts and managing comments.
User Profile Management: Users can update their profiles, including their name, email, biography, and profile picture.
Authentication and Authorization: Implements secure login and logout functionality, with password hashing for user security.
Registration: Allows new users to register on the platform, with form validation and secure password storage.

Getting Started
To get started with Symfony Blog, follow these steps:

Clone the repository to your local machine.
Install dependencies using Composer: composer install.
Set up your database configuration in .env file.
Run database migrations: php bin/console doctrine:migrations:migrate.
Start the Symfony server: symfony serve.
Access the application in your web browser.

License
Symfony Blog is open-source software released under the MIT license.

Support
For any questions or issues, please open an issue on GitHub.

Happy blogging with Maher'sSymfony Blog! 🚀
