# Shopify Orders App

This Laravel-based application integrates with Shopify to fetch order data, save it to a MySQL database, and display the orders in a user-friendly web interface. It was built as part of a coding challenge to demonstrate integration with a third-party API, backend development with Laravel, and frontend UI implementation with Vue.js.


## Overview

The application provides the following functionality:

1) Fetch orders from a Shopify store for the last year using Shopify's Admin API.
2) Save the following order details to a MySQL database:
- Customer Email
- Total Order Amount
- Shopify Order ID
- Order Date

3) Display the saved orders in a clean and responsive interface.
4) Provide a "Fetch Orders" button to manually fetch the latest orders from Shopify.
## Installation

Requirements

-	PHP (8.1 or higher)
-	Composer
-	MySQL
-	Node.js and npm
-	A Shopify store with Admin API access (requires private app setup)

Steps to Set Up
-


1. Clone the Repository
Clone the project repository and navigate to the project folder:

```bash
git clone https://github.com/tuzcuy/shopify-orders-app.git
cd shopify-orders-app
```
2. Install Dependencies
Install PHP dependencies:

```bash
composer install
```
Install JavaScript dependencies:

```bash
npm install
```
3. Configure the .env File
Copy the .env.example file to .env:

```bash
cp .env.example .env
```
Update the .env file with your local setup and Shopify credentials:

```env
Copy code
APP_NAME=ShopifyOrdersApp
APP_ENV=local
APP_KEY=base64:9u8Ne6gTX+v7QOOzNrbQyHkBcpVPGMRZ+9E91ZBUjqg=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shopify_orders_app
DB_USERNAME=root
DB_PASSWORD=insider

SHOPIFY_API_KEY=bfc3e9c3f68aeb7ced26e0d76b6e47a7
SHOPIFY_ACCESS_TOKEN=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
SHOPIFY_STORE=ygttzc.myshopify.com
```
4. Set Up the Database
Create a new MySQL database:

```bash
mysql -u root -p
CREATE DATABASE shopify_orders_app;
```
Run migrations to create the orders table:
```bash
php artisan migrate
```
5. Start the Development Servers
Start the Laravel server:

```bash
php artisan serve
```
Start the Vite server for the Vue.js frontend:

```bash
npm run dev
```
6. Access the Application
Open your browser and navigate to:
```bash
http://localhost:8000/orders
```

    
## How It Works

1)  Fetch Orders
-	Clicking the "Fetch Orders" button sends an HTTP request to the /fetch-orders endpoint.
-	This triggers a call to Shopify's Admin API to fetch orders from the last year.
-	Orders are saved to the database, ensuring no duplicates with Laravel's updateOrCreate method.
2)  Display Orders
-	Saved orders are retrieved from the database and displayed in a responsive table on the /orders page.
-	If no orders are found, a friendly "No orders found" message is displayed.
3)  Test Orders
-	Log into your Shopify store, create a test order, and use the "Fetch Orders" button to see the data update in real-time.

## File Structure
Here’s an overview of the project structure:

```bash

shopify-orders-app/
│
├── app/
│   ├── Http/Controllers/   # Controllers
│   ├── Models/             # Eloquent models
│   └── Services/           # Shopify integration logic
├── database/migrations/    # Database schema
├── resources/
│   ├── js/components/      # Vue.js components
│   └── views/orders/       # Blade templates
└── routes/web.php          # Routes

└── .env
```

## Testing

1. Database Verification
Ensure the shopify_orders_app database exists and the orders table has been populated:

```bash
mysql -u root -p
USE shopify_orders_app;
SELECT * FROM orders;

```
2. API Key Validation
Validate the Shopify Admin API key and access token with a direct curl request:
```bash
curl -X GET "https://ygttzc.myshopify.com/admin/api/2023-04/orders.json" \
-H "X-Shopify-Access-Token: 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"
```
3. UI Testing
- Open the /orders page in your browser.
- Click "Fetch Orders" and verify that data appears in the table.
- Create a test order in Shopify and confirm it appears after fetching orders again.

## Creating a Test Order as a Customer
Access the Shopify Storefront

- Open the Shopify store URL in your browser:

`https://ygttzc.myshopify.com`

- Use the storefront password to access the store:

    Password: `insider`

2. Browse Products

- Navigate through the available products on the storefront.

3. Add a Product to the Cart

- Select a product and add it to the shopping cart.

4. Proceed to Checkout

- Click the "Checkout" button and proceed to the checkout page.

5. Fill in Customer Details

 - Provide the following information:
   - Email: Use any email address (e.g., test@example.com).
   - Shipping Address: Enter a valid address (or use a dummy address for testing).

 - Choose Any Payment Method (use Shopify's test payment gateway if available).
    - Complete the Order

Finish the order process by confirming the payment (or using Shopify's test payment method).
## Next Steps

- Testing on Shopify: Add multiple test orders in Shopify and verify them.
- Potential Improvements:
    - Deploy the app to a hosting provider for public access.
    - Enhance the UI for a more modern look.

----------------------------------------------------------------

## Screenshots

### 1. Orders Page
![Create Order Page](screenshots/create_order.png)

### 2. URL
![URL](screenshots/url.png)

### 3. Orders Page
![Order Screen](screenshots/orders_screen.png)

### 4. CMD 1
![php artisan serve](screenshots/cmd_artisan.png)

### 5. CMD 2
![npm run dev](screenshots/cmd_npm_vite.png)

### 6. Fetch Orders Button
![Fetch Orders Button](screenshots/orders_after_click_button.png)
