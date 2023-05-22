# Project Description

Our team, SaaS Accounting Software, is working to create a product that will be used as a more manageable accounting software for small to medium sized companies than what is currently on the market. Through our software, they will be able to, in the end, enter bills, pay bills, create invoices, receive payments, and record deposits.

# Coding Standards

[Working Agreement](https://gitlab.csi.miamioh.edu/2023-capstone/SaaS_Accounting/saas-accounting-project/-/wikis/Working-Agreement)

# Branches


| **Name**   | **Description** |
| ------ | ------ |
| Master         | Protected branch.  You cannot push directly to master.  This branch should be what you push to your test server (ceclnx for example) or other devices for your client to review. |
| Sprint[sprint number]          | We create a new branch for each sprint. For example: sprint1, sprint2, etc. This will be what all of the different issues branch off of and then merge into when completed. This branch will be merged into master after the sprint is completed. 

# Page Map

| **Page**   | **Description** |
| ------ | ------ |
| login.php         | Page that users land on when first opening the web application. Using verified login credentials they will be able to log on and access the application. If not, an error message appears letting the user know that they have an incorrect username or password. |
| index.php         | This is the landing page after a user successfully logs on. Here, they can choose which action they would like to take: enter bills, pay bills, create invoices, receive payments, or record deposits. |
| reports.php         | Users will utilize this page to obtain a report from their account. The paramter that they fill out include: start date, end date, and type of report that they want. |
| statementInput.php         | This page is used for book keeping for the user. Here, they input the bank date, description, their account, and the amount. |

# Tech Stack
Scribe is run on and powered by a LAMP Stack. 
 - Operating System: Linux
 - Database: MySQL
 - Web-Server: Apache2
 - Scripting Languages: php, Bash, Python

Php is used to connect our front and back end together. Each php script either pulls data for our database and presents it on the front-end, or takes user input from the front-end and inserts it into our desired database table. Bash scripting is used to push all working files from master into an appropiate destination on our production server. We use tidy wrapped within a Python script to check that all committed front-end files are up to HTML5 standard.



