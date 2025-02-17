# Simple PHP form submission script with frontend validation


## Project Overview

This is a simple form submission with frontend validation that allows users to create, and view orders. The system is built using **PHP** for the backend, ensuring a smooth user experience and robust functionality.

## Installation Instructions

### Prerequisites

Ensure you have the following installed on your system:

- PHP (>= 8.1)
- Composer
- Apache/Nginx
- MySQL Database

### Backend Setup (Laravel)

```sh
# Clone the repository
git clone https://github.com/aminprodhan/ord_raw_php.git
cd ord_raw_php

#import database
import orders.sql file

# Install dependencies
composer dump-autoload

# Configure database in .env file
DB_CONNECTION=mysql  
DB_HOST=127.0.0.1  
DB_PORT=3306  
DB_DATABASE=event_management  
DB_USERNAME=root  
DB_PASSWORD=
APP_TIMEZONE=Asia/Dhaka

- test link
- https://test.ord.infoagectg.com
