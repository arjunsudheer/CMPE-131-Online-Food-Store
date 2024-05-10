# CMPE-131-Online-Food-Store

Our GitHub repository can be accessed at this link: https://github.com/arjunsudheer/CMPE-131-Online-Food-Store

## Setup Instructions

To use our website, you will need to use XAMPP. You will then need to create a database and some tables.

Create a new database called "ofs" (no quotes). You will need to create 4 tables within the OFS database. We have provided guides in the docs directory to help with creating these tables.

* [docs/Item-Database-Creation.pdf](docs/Item-Database-Creation.pdf) provides instructions on how to create the Item database which contains product-related information. Use the [itemDB.csv](docs/item_database/itemDB.csv) file.
* [docs/Steps-to-add-the-productSales-table.pdf](docs/Steps-to-add-the-productSales-table.pdf) provides instructions on how to create the productSales database which contains sales related information used for generating sales reports. Use the [Item-Sales-Database-w_preset-values-5_5-to-5_9.csv](docs/productSales_database/Item-Sales-Database-w_preset-values-5_5-to-5_9.csv) file.
* [docs/accountSQLStatements.txt](docs/accountSQLStatements.txt) provides information on how to create the customer and employee tables which contain user information both both customers and employees.

We have also provided a guide on installing PHPUnit and explaining how we setup integration tests using GitHub actions. This guide is optional and is not required to view our website.

* [testing-setup](docs/Testing-Setup.pdf) provides instructions on setting up PHPUnit to run our unit tests.