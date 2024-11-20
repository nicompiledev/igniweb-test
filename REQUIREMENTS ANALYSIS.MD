### 1. **General Objective**
- Develop a book reservation system in PHP and MySQL, which allows managing reservations for authenticated users.

### 2. **Allowed Technologies**
- Frameworks: CodeIgniter, Laravel, Symfony, WordPress, Ionic.

### 3. **Evaluation Axes and Weight**
- **Requirements Analysis:** 15%
- **MySQL Query Design:** 15%
- **Code Documentation:** 10%
- **Session Management:** 10%
- **HTML and CSS Markup:** 20%
- **Asynchronous JavaScript Requests (Ajax):** 20%
- **Error Validation:** 10%

### 4. **Functional Requirements**

#### 4.1 **User Authentication**
- **Description:** The system should only allow access to authenticated users through a `username/password` authentication system.
- **Conditions:**
  - If the user is not authenticated, they should not be able to see any sections.
  - After authentication, the user will initially see their account information, including their name and the total number of active reservations.

#### 4.2 **Reservation Management**
- **Functionality to List Reservations:**
  - Show the user all their active reservations in a list.
  - Allow the user to delete a reservation at any time.
- **Functionality to Reserve Books:**
  - Show a list of available books for reservation.
  - Prevent a reserved book from being listed again until the reservation expires.
  - Implement a category filter to display related books based on the selected category. This filtering should be done asynchronously using **AJAX**.
- **Process of Reserving a Book:**
  - When selecting a book, the user will see a screen or modal window with book details (title, author, description, image).
  - Include an option to choose the number of days the book should be reserved.
  - **Optional:** Implement this functionality in a modal window instead of a new screen.

#### 4.3 **Validation and Messages**
- **Process Validation:**
  - Validate each reservation, authentication, and reservation deletion process to ensure compliance with established business rules.
- **Confirmation and Error Messages:**
  - Display success, warning, or error messages based on user actions (e.g., success when reserving, error when trying to reserve an already reserved book, etc.).

### 5. **Non-Functional Requirements**
- **Code Documentation:** Properly document the code. It is preferable to use the English language in the documentation.
- **User Interface (UI):**
  - Markup the sections of the reservation system using HTML and CSS, improving the basic design of the provided images.
- **Code Quality:**
  - The organization and cleanliness of the code will be valued to ensure that the system is maintainable and easy to understand.


