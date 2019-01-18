<?php

class Marketplace {
	public $inventory;
	public $jsoninventory;
	
    /*
        @Input: N/A
        
        @Purpose:
            constructor to read the inventory from the json database and set product 
            objects thta correspond to the data in the json database
        
        @Output: N/A    
    */    
    public function __construct(){
        $this->jsoninventory = json_decode(file_get_contents("inventory.json"), true);
        
        $this->inventory = array_map(function($item){
		return new Product($item["ID"], $item["price"], $item["title"], $item["stock"]);
        }, $this->jsoninventory);
    }
    
    /*
        @Input: int, int, int, int 
        
        @Purpose: 
        this function is meant to update the json database after every change
        
        @output: void 
    
    */
	public function update($price, $title, $invcount,$id){    
         foreach($this->inventory as $item){ 
		if($item->getId()==$id){		
        $item->setPrice($price);
        $item->setTitle($title);
		$item->setInvCount($invcount);}
		 }
        
		for($x=0;$this->jsoninventory[$x]!=null;$x++){
		if($this->jsoninventory[$x]["ID"]==$id){
        $this->jsoninventory[$x]["price"] = $price;
        $this->jsoninventory[$x]["title"] = $title;
        $this->jsoninventory[$x]["stock"] = $invcount;
		}
		}
        
        $newJsonString = json_encode($this->jsoninventory,JSON_PRETTY_PRINT);
        file_put_contents('inventory.json', $newJsonString);
	}
	
    /*
        @Input: int (?)
        
        @Purpose:
            function meant to query the inventory and return the results, if arg is 0 items 
            in stock are displayed if arg is not 0 all items, including not in stock are displayed
        
        @Output: Product Object if ID of an object in the inventory matches with the given parameter, -1 if there is no match
    */
	public function query($arg){
	foreach($this->inventory as $item){
		if($item->getId()==$arg){
	       return $item;
		   }
	}
			return -1;
    }
	
    /*
        @Input: int 
        
        @Purpose: 
            function to purchase an item from the market place, purchasing an item will 
            print out its title and inventory count after the purchase, and each purchase will 
            update the json database
        
        @Output: 1 if purchase succesful, 0 if item does not exist, -1 if item out of stock
    */
    public function purchase(int $id) {
		$result = $this->query($id);
        if ($result != null) {
			if($result->getInvCount()==0){
				return -1;
			}
		else{
            $result->setInvCount($result->getInvCount()-1);
                        
            $this->update(
                $result->getPrice(),
                $result->getTitle(),
                $result->getInvCount(),
                $id
            );
		return 1;}
        }
        else{
            return 0;
        }
    }
}
?>