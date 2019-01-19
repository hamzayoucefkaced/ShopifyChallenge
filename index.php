<?php
require("Marketplace.php");

require("Product.php");

require("Cart.php");

session_start();
if (!isset($_SESSION['cart'])) {
	//creates new cart if cart does not exist
    $_SESSION['cart'] = new Cart();
}

if (!isset($_SESSION['marketplace'])) {
	//creates new marketplace if marketplace does not exist
    $_SESSION['marketplace'] = new Marketplace();
}

$marketplace = $_SESSION['marketplace'];

if (isset($_GET['buy'])) {
    if(is_numeric($_GET['buy'])){
    //checks if the value is numeric, if not throw a 400 HTTP error code
    $query = $marketplace->query($_GET['buy']);
    // if a get request by the key buy is made, it will add to the cart in the session depending on the value if it is in stock, if not it will inform you it is not in stock and will not add it
    //EXAMPLE:
    // URL: http://localhost:8000/shopifyphp/index.php?buy=Playstation will result in You have added a playstation to your cart! your total is now: 500
    if ($query != -1) {
	//query will return -1 if id does not exist in database
        if ($query->getInvCount() != 0) {
            $_SESSION['cart']->addtocart($query);
            echo "You have added a ", $query->getTitle(), " to your cart! Your total now is: ", $_SESSION['cart']->getTotal();
        } else {
            echo $query->getTitle(), " is out of stock!";
        }
    } else {
        echo "No such item!";
    }
    
    echo "<br />";}
    else {    
    http_response_code(400);
    include('errors/my_400.php');
	}
}

else if (isset($_GET['query'])) {
    
    // if a get request by the key query is made, it will set th value as the parameter of query function, which
    // if key is "all" it will result in it displaying all products
	// if key is "available" it will result in it displaying only products that are available
	// if key is anything else it will result in a 400 error
    // EXAMPLE:
    // http://localhost:8000/shopifyphp/index.php?query=all
    // Playstation has 120 products left
    // Gameboy has 30 products left
    // http://localhost:8000/shopifyphp/index.php?query=available
    // Nintendo Switch has 0 products left
    // Playstation has 120 products left
    // Gameboy has 30 products left
    if ($_GET['query'] == "all" || $_GET['query'] == "available") {
        for ($x = 0; $marketplace->query($x) != -1; $x++) {
            if ($_GET['query'] == "available" && $marketplace->query($x)->getInvCount() == 0) {
				//If get parameter is "available", it will skip printing the items that are not in stock
                continue;
            }
            echo $marketplace->query($x)->getTitle(), " has ", $marketplace->query($x)->getInvCount(), " remaining items. <br/>";
        }
    } else {
        http_response_code(400);
        include('errors/my_400.php');
    }
    
}

else if (isset($_GET['complete'])) {        
        // this is meant for completing the cart, it will iterate through the cart contents that are saved in the session and will
        // purchase them if they are in stock in the marketplace, and then clear the cart afterwards
        // EXAMPLE:
        // http://localhost:8000/shopifyphp/index.php?complete=1
        // Your total is: 2000
        // You have purchased 1 Playstation! There remains 200 
        // You have purchased 1 Nintendo! There remains 47
        // Item out of stock! Cannot purchase!
        // You have purchased 1 Gameboy! There remains 69
        // You have purchased 1 Gameboy! There remains 68
		// Your purchase total is: 1500
    if ($_GET['complete'] == 1) {
		
        $cart          = $_SESSION['cart'];
		if($cart->getTotal()>0){
		//if cart is not empty
        $purchasetotal = 0;
        echo "Your total is: ", $cart->getTotal(), "<br/>";
        foreach ((array) $cart->getContents() as $product) {
            $result = $marketplace->purchase($product->getID());
            if ($result == 1) {
				//Purchase succesful, print Product item and remaining stock
                $purchasetotal = $purchasetotal + $product->getPrice();
                echo "You have purchased 1 ", $product->getTitle(), "! There remains: ",
		    $marketplace->query($product->getID())->getInvCount(),"<br/>";
            } else if ($result == -1) {
				//Purchase unsuccesful: Item out of stock!
                echo "Item out of stock! Cannot purchase!<br/>";
            } else {
				//Purchase unsuccesful: Item with ID inputted does not exist
                echo "Item does not exist!<br/>";
            }
        }
        echo "Your purchase total is: ", $purchasetotal, "<br/>";
        
        $cart->clear();
		}
		else{
			echo "Your cart is empty!";
		}
    } else {
        http_response_code(400);
        include('errors/my_400.php');
    }
    
} else {
    http_response_code(404);
    include('errors/my_404.php');
}

?>
