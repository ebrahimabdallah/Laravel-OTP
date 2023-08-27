#  OTP Laravel

## Description
This project demonstrates the usage of OTP (One-Time Password) for user authentication and verification purposes in a Laravel application.

## Installation
1. Install Laravel by following the official Laravel documentation.
2. Install the Laravel Braze package by running the following command:
3. Add a new column named "code" to the "users" table to store the generated OTP. Also, add another column named "expire_at" to track the expiration time of the OTP.
4. Define a route in your `web.php` file to handle the OTP generation and verification process.
5. Create a controller that handles the OTP generation, sending, and verification logic.
6. Implement a middleware to protect routes that require OTP verification.
7. In the `LoginRequest` class, write code in the `authenticate` function to connect with Mailtrap or a mobile service provider to send the OTP.
8. For SMS-based OTP, integrate Twilio or another SMS service provider to send SMS messages to the user's mobile number.

## Usage
1. Configure your application to use the OTP functionality by following the installation steps mentioned above.
2. Use the provided routes and methods to generate and verify OTPs for user authentication or verification.
3. Customize the views, notifications, and messages according to your application's design and requirements.
4. Test the OTP functionality thoroughly to ensure it works as expected.
5. Consider security measures such as rate limiting, encryption, and secure storage of OTPs to protect against misuse or theft.
-----------------------

![Screenshot_2023_08_27-1](https://github.com/ebrahimabdallah/Laravel-OTP/assets/119238955/c5af8b99-0a36-493b-80e6-f0cfa99ad01e)


![photo_2023-08-27_05-26-00](https://github.com/ebrahimabdallah/Laravel-OTP/assets/119238955/aceb1a52-4f50-4cde-bdbd-5d84549d3d31)

![Screenshot_2023_08_27-2](https://github.com/ebrahimabdallah/Laravel-OTP/assets/119238955/37658bda-7579-48bd-9501-abadb4d99614)


![Screenshot_2023_08_27-3](https://github.com/ebrahimabdallah/Laravel-OTP/assets/119238955/2268a260-8978-411c-9c55-1e2a446aae89)
