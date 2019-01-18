<?php
include_once ("Product.php");

class Cart

{
	private $contents;

	private $total;
	
	public function getContents(){
		return $this->contents;
	}
	
	public function setContents($content){
		$this->contents=$content;
	}
	
	public function getTotal(){
		return $this->total;
	}
	
	public function setTotal($total){
		$this->total=$total;
	}
 
    /*
        @Input: Product object 
        
        @Purpose: 
        Adds a product to the cart, and adds its price to the total
        
        @output: void 
    
    */
	public function addtocart($product){
		$this->contents[] = $product;
		$this->total = $this->total + $product->getPrice();
	}

    /*
        @Input: Product object 
        
        @Purpose: 
        Removes all objects from the cart, and sets the total to 0
        
        @output: void 
    
    */
	public function clear()
	{
		$this->contents = [];
		$this->total = 0;
	}
}

?>
