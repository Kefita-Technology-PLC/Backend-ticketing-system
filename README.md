

## Installation Instructions

To get started with the kefita ticketing system, follow these steps:

## 1. Clone the repository

     git clone https://github.com/kefita/ticketing-system.git
     cd ticketing-system
## 2.Install Depedencies
Make sure you have [Composer](https://getcomposer.org/download/) installed. Then, run the following
    
    composer install

## 3. Set up environment variables 
Copy the example environment file and update your environment settings.
    
    cp .env.example .env

Edit ```.env``` to set up your database and other configurations

    DB_DATABASE=sqlite
    # DB_USERNAME=root
    # DB_PASSWORD=yourpassword


## 4. Optional: Configure OAuth for Google Authentication
If you want to enable Google OAuth for authenticating admins and ticket sellers in the Kefita Ticketing System, follow these steps. This is optional, and you can use regular email authentication if you prefer.
 -  Set up Google OAuth Credentials:
       - You will need to configure the following environment variables in your ```.env``` file:

         Admin OAuth Credentials

             GOOGLE_ADMIN_CLIENT_ID=your-admin-client-id
             GOOGLE_ADMIN_CLIENT_SECRET=your-admin-client-secret
             GOOGLE_REDIRECT_URI_ADMIN=http://127.0.0.1:8000/auth/google/callback

         Ticket Seller OAuth Credentials

             GOOGLE_TICKET_SELLER_CLIENT_ID=your-ticket-seller-client-id
             GOOGLE_TICKET_SELLER_CLIENT_SECRET=your-ticket-seller-client-secret
             GOOGLE_REDIRECT_URI_TICKET_SELLER=http://127.0.0.1:8000/auth/google/ticket-seller/callback

 
## 5. Run Migrations
This will set up the database schema and tables.
        
    php artisan migrate

## 6. Seed the database
To populate the database with essential roles and permissions, run the seeder:

    php artisan db:seed

## 7. Serve the application
To start the application, use:

    php artisan serve

Now your can visit the application at ```https://localhost:8000```

## Learning Kefita Ticketing System
If you're new to the project or Laravel, here are some resources to help you get started
    - [Kefita Backend API Documentation](https://docs.google.com/document/d/1DY4T70uRvGI_dEKYJ_uWvzvyAZlL6o8troJE96CrT4A/edit?usp=sharing)

