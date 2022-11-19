## CLI Restful API Product App


This CLI program is built on the LARAVEL FRAMEWORK. The program is built to implement a REST API endpoint that given a list of products, applies some discounts to them and can be filtered. 
The program uses Two (2) file options to read and create products.

<li> Config Shopping list file - The file contains 5 listed product items in the assessment docs </li>

<li> Product.csv file - The file contains randomly generated 20,000 product items stored in the public path  </li>


## Repository Overview 

The repository contains source code on how to run the execute the Product Restful API and command. 

Specifications in the clone include

<li> The program reads users' I/O  and then displays options and success status in the CLI. The console command file can be found within the console > commands directory with the name <b> CreateProductCommand </b>. </li> </br>

![Screenshot of read write operation via the CLI](https://github.com/LarrySul/cli-restful-api-product-app/blob/feature/public/screenshots/process.png)

<li>  When commands get executed, jobs get triggered in the background, and queue workers pick them up for dispatch and records get populated in the database</li>

![Screenshot of background jobs](https://github.com/LarrySul/cli-restful-api-product-app/blob/feature/public/screenshots/job.png)

![Screenshot of database records](https://github.com/LarrySul/cli-restful-api-product-app/blob/feature/public/screenshots/database.png)


<li>To excute the command, users need to run the artisan command `php artisan command:read-and-create-product` in the CLI </li>

<li> Writing of errors to logfile </li>

<li> Single CLI command to automate the read and write process with easy to read instructions </li>

<li> The project has a total of 3 test cases (2 Unit and 1 Feature) that executes in 0.06seconds. </li>

![Screenshot of test cases ](https://github.com/LarrySul/cli-restful-api-product-app/blob/feature/public/screenshots/test.png)

<li> The project is also dockerized, pushed to dockerhub where it is available to be pulled </li>

![Screenshot of dockerized project ](https://github.com/LarrySul/cli-restful-api-product-app/blob/feature/public/screenshots/docker.png)

## Requirements 

<li> Download <a href="https://www.php.net/downloads.php"> PHP V8.1 </a> and above. </li>

<li> Install <a href="https://getcomposer.org/download/"> Composer </a> </li>

<li> If you'll like to use docker you should <a href="https://www.docker.com/products/docker-desktop/" >download docker desktop </a> and pull the image </li>


## Explanation

The application covers the following use case

<li> Products in the boots category have a 30% discount.</li>
<li> The product with sku = 000003 has a 15% discount. </li>
<li> When multiple discounts collide, the biggest discount must be applied. </li>
<li> Read up to 20,000 records in CSV and process in bus batch </li>
<li> Tests </li>
<li> List products with pagination </li>

![Screenshot of pagination product list ](https://github.com/LarrySul/cli-restful-api-product-app/blob/feature/public/screenshots/list.png)
<li > Filter by category and price less than </li>

![Screenshot of query result ](https://github.com/LarrySul/cli-restful-api-product-app/blob/feature/public/screenshots/query.png)

## Steps to run locally 

<li> Clone this repository: </li>

<pre> git clone https://github.com/LarrySul/cli-restful-api-product-app </pre> or pull image via docker

<pre>  docker pull olanrewaju1992/cli-restful-api-product-app:latest </pre>

<li> Install dependencies: </li>

<pre> composer install </pre>

<li> Open the CLI in preferred editor and run the command: </li>

<pre> php artisan command:read-and-create-product </pre>

<li> To retrieve the paginated list of products  </li>

<pre>
    GET /products 

    (optional) paginate - 10 
    (optional) query - 'boots' 
    (optional) query - 50 (priceLessThan)
</pre>
Once the command is done you'll get a success message in the CLI and in Postman respectively :) 
