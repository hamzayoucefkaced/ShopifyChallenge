This was developed using PHP7.3 and tested on the default PHP7.3 webserver. This works on all browsers, but I recommend using it on Firefox, There are some bugs that occur when using Chrome.
I used a JSON "database" to store the values of the products. 

A session with a cart and a marketplace will automatically be created when the index page is accessed.
I used GET REST protocol for this project.

COMMANDS:

http://localhost:8000/shopifyphp?buy=ID

This will add an item with given ID to the cart and print the total amount of the cart. Refer to json database for Product IDs. Usage of invalid IDs will cause the page to tell you that the item does not exist.

http://localhost:8000/shopifyphp?query=all

This will print the values of all the products stored in the database.

http://localhost:8000/shopifyphp?query=available

This will print the values of all the products that are in stock.

Any other value inputted in the "query=" will cause a 400 HTTP error.

http://localhost:8000/shopifyphp?complete=1

This will checkout the cart if it contains some products. It will print a message that the cart is empty if the cart is empty. 

Any other value inputted in the "complete=" will cause a 400 HTTP error.

Any other command will cause a 404 HTTP error.

Navigating to any page that does not exist will throw a 404 HTTP error.

I deliberately coded the index to only allow one get request at a time, hence the usage of if else statements when handling the GET requests. 

http://localhost:8000/shopifyphp?query=available&&nothing=nothing will ONLY process the query request.







 
