# 🐾 Animal Shelter Website

This project is a web-based system for managing an animal shelter, including customer registration, pet adoption, staff management, and vaccination tracking.

## Database Overview

The system uses a relational database to store core shelter operations data (customers, animals, staff, adoptions, vaccinations, and sitting/training activities).

Tables used in the schema:

- **Customer** – Stores customer/user details such as name, email, contact info, and login credentials.
- **Shelter Organisation** – Contains information about partner/affiliated shelters and their details.
- **Cat** – Holds details about cats available in the shelter (identity, breed, and related attributes).
- **Dog** – Holds details about dogs available in the shelter (identity, breed, and related attributes).
- **Staff** – Records staff members and their roles/responsibilities.
- **Training** – Tracks training sessions (commonly for dogs) conducted by staff.
- **Cat Vaccine** – Lists available cat vaccines and their metadata (e.g., vaccine name/type).
- **Dog Vaccine** – Lists available dog vaccines and their metadata (e.g., vaccine name/type).
- **Cat Vaccination** – Logs vaccination records administered to cats (which vaccine, when, and related references).
- **Dog Vaccination** – Logs vaccination records administered to dogs (which vaccine, when, and related references).
- **Cat Sitting** – Schedules/records cat sitting sessions handled by staff.
- **Dog Sitting** – Schedules/records dog sitting sessions handled by staff.
- **Adoption Record** – Links customers to adopted pets and stores adoption event details (such as adoption date).

## Setup Instructions

1. **Create a database** in your DBMS (commonly MySQL when using XAMPP).
2. **Import the schema/data SQL file** into your database:
   - **MySQL (phpMyAdmin)**: open phpMyAdmin → create/select the database → *Import* → choose the `.sql` file → *Go*.
   - **MySQL (CLI)**:
     - `mysql -u root -p your_database_name < path\to\schema.sql`
   - **PostgreSQL (optional)**:
     - `psql -U postgres -d your_database_name -f path\to\schema.sql`
3. **Update the website’s database connection settings** in the PHP files (host, username, password, and database name) to match your environment.
4. **Run the project** under a local server (e.g., XAMPP Apache) by placing the folder in `htdocs` and opening the site in your browser.

