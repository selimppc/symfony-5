## Symfony-5

#### install Symfony CLI.
###### This will help to use command like : symfony

    $ curl -sS https://get.symfony.com/cli/installer | bash
    

### To Run the project we need to run following commands: 
#### Composer Install : 

    $ composer install

#### database migration
    MYSQL  configuration is in .env file

    $ php bin/console doctrine:migrations:execute --up 20200409053223

#### Run the system 

    $ symfony serve
     
#### Run the functional Test

    $ ./bin/phpunit


#### What I did here:

1. Migrated 2 tables named `product` and `sales`
2. Added Bootstrap in base template - used CND
3. Created 3 Controller 
4. Created 2 Entity and 2 Repository 
5. Created 1 service for available product calculation
6. Twig template as per needed 
7. Test cases for controller, service and repository. 

#### Logic I have designed:

1. I kept `purchase price` , `sell price`,
   `product batch/sequence` and `order quantity` 
   in the `sales` table
2. In `product` table  I have `product batch/sequence` and `quantity`

3. When I am selling items then I calculate the available items 
   by pulling order data from `sales` table and checking availability
   by comparing with `product` according to `batch sequence`
   And finally -> adding #1 data(s) into `sales` table
4. For Profit calculation I set a query 
   -> by subtracting `purchase price` and `sell price`
   -> multiplying with `order quantity` and subtract value

#### Conclusion:

There are lots of way solving this problem. I have tried to use very simplest way.
Because I like to make everything be simple. It helps us to minimize code and redundancies. 
My solution will help you to get your expected results. 
Finally I am glad to participate this test assignment.
Thanks!
