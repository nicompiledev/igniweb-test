# Book Reservation App

## Overview

The **Book Reservation App** is a web application developed using Laravel and MySQL. It allows authenticated users to manage their book reservations, providing a seamless user experience for discovering and reserving books.

## Requirements Analysis

This project was developed as part of a technical assessment for a web developer position at **Igniweb SAS**. Below is a breakdown of the requirements and objectives:

### 1. General Objective
- Develop a book reservation system in PHP and MySQL that allows users to manage their reservations.

### 2. Allowed Technologies
- Frameworks: CodeIgniter, Laravel, Symfony, WordPress, Ionic.

### 3. Evaluation Criteria and Weight
- Requirements Analysis: 15%
- MySQL Query Design: 15%
- Code Documentation: 10%
- Session Management: 10%
- HTML and CSS Layout: 20%
- Asynchronous Requests with Javascript (Ajax): 20%
- Error Validation: 10%

### 4. Functional Requirements

#### 4.1 User Authentication
- The system should allow access only to authenticated users via a username/password authentication system.
- If the user is not authenticated, they should not be able to view any sections.
- Upon authentication, the user should see their account information, including their name and total active reservations.

#### 4.2 Reservation Management
- **List Active Reservations**: Users should see a list of all their active reservations with the option to delete a reservation at any time.
- **Reserve Books**: Users should see a list of available books for reservation. A book should not be listed for reservation again until the current reservation expires.
- **Category Filtering**: Implement an asynchronous (AJAX) filter to show related books based on selected categories.
- **Reserve a Book**: When selecting a book, users should see a modal with book details (title, author, description, image) and an option to choose the number of days for the reservation.

#### 4.3 Validation and Messages
- Validate all processes for reservations, authentication, and deletion to ensure business rules are met.
- Display success, warning, or error messages based on user actions (e.g., success when reserving, error when trying to reserve an already reserved book).

### 5. Non-Functional Requirements
- **Code Documentation**: Proper documentation in English is preferred.
- **User Interface (UI)**: Use HTML and CSS to improve the layout of the reservation system.
- **Code Quality**: Clean and well-organized code is valued for maintainability.
- **Estimated Development Time**: 7 hours, plus 1 hour for organizing and presenting the work.

### 6. Final Delivery
- **Video Explanation**: A video of at least 5 minutes explaining the system's functionality and development approach.
- **Quality of Delivery**: The final delivery should be as professional as possible, with a well-structured presentation.

## Getting Started

To run this project locally, follow these steps:

### Prerequisites
- PHP >= 8.0
- Composer
- MySQL
- Node.js and npm (for front-end assets)

### Environment Configuration
1. Clone the repository to your local machine:
    ```bash
    git clone https://github.com/yourusername/book-reservation-app.git
    cd book-reservation-app
    ```

2. Copy the `.env.example` file to `.env`:
    ```bash
    cp .env.example .env
    ```

3. Update the `.env` file with your database credentials:
    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=book_reservation_app
    DB_USERNAME=laravel_user
    DB_PASSWORD=admin123
    ```

4. Run the following commands to set up your application:
    ```bash
    composer install
    php artisan key:generate
    php artisan migrate
    php artisan db:seed  # Optional: If you have seed data
    ```

5. Install front-end dependencies and compile assets:
    ```bash
    npm install
    npm run dev
    ```

### Running the Application
1. Start the Laravel development server:
    ```bash
    php artisan serve
    ```
2. Visit `http://localhost:8000` in your browser to access the application.

### Testing the Application
- Use the provided user credentials to log in:
    - Username: `testuser`
    - Password: `password`
  
- Explore the functionalities such as reserving books, viewing active reservations, and using the AJAX filtering feature.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.


