<?php include("../main_page/navbar.html"); ?>
<style>
<?php include 'employee-inventory-page.css'; ?>
</style>

<!DOCTYPE HTML>
<html lang="en">
    <link rel="stylesheet" href="../main_page/navbar.css">
    <body>
        <div style="padding-left: 11%; padding-bottom: 10px;">
            <input type="text" class="searchbar">
            <button style="float:right">Save</button>   
        </div>
        <div style="padding-left: 11%">
            <button name="addToPage">Fruits</button>
            <button>Vegetables</button>
            <button style="float:right">Add Item</button>
        </div>
        <div style="padding-left: 11%">
            <p style="display:inline-block"># of Results</p>
            <select style="float:right; margin-top: 15px">
                <option>A-Z</option>
                <option>Z-A</option>
                <option>Cheapest</option>
                <option>In Stock (A-Z)</option>
                <option>In Stock (Z-A)</option>
            </select>
        </div>
        <div style="padding-left: 11%">
            <?php

            // Setting up connection with database Geeks 
            $connection = mysqli_connect("localhost", "root", "", "ofs"); 

            // Check connection 
            if (mysqli_connect_errno()) 
            { 
                echo "Database connection failed."; 
            } 

            // query to fetch Username and Password from 
            // the table geek 
            $query = "SELECT Type, Product, Brand, Price, Weight, numStock, inStock FROM items"; 

            // Execute the query and store the result set 
            $result = mysqli_query($connection, $query);
            
            while ($row = mysqli_fetch_array($result)) {
            echo 
            "<div class='item'>
                <div class='itemLeft'>
                    <img src='#' class='image'>
                    <div class='itemDesc1'>
                        <div class='type'>
                            <p>Type:&nbsp</p>
                            <p id='type'>" . $row["Type"] . "</p>
                        </div>
                        <div class ='product'>
                            <p>Product:&nbsp</p>
                            <p id='product'>" . $row["Product"] . "</p>
                        </div>
                        <div class='brand'>
                            <p>Brand:&nbsp</p>
                            <p id='brand'>" . $row["Brand"] . "</p>
                        </div>
                    </div>
                </div>
                <div class='itemRight'>
                    <div class='itemDesc2'>
                        <div class='price'>
                            <div class='priceDesc'>
                                <p>Price:&nbsp</p>
                                <p id='price'>" . $row["Price"] . "</p>
                            </div>
                            <div>
                            <input type='text' class='changer' placeholder='Enter new price'>
                            <br>
                            <button>Submit</button>
                            </div>
                        </div>
                        <div class='weight'>
                            <div class='weightDesc'>
                                <p>Weight:&nbsp</p>
                                <p id='weight'>" . $row["Weight"] . "</p>
                            </div>
                            <div>
                                <input type='text' class='changer' placeholder='Enter new weight'>
                                <br>
                                <button>Submit</button>
                            </div>
                        </div>
                        <div class='quantity'>
                            <div class='quantityDesc'>
                                <p>Quantity:&nbsp</p>
                                <p id='quantity'>" . $row["numStock"] . "</p>
                            </div>
                            <div>
                                <input type='text' class='changer' placeholder='Enter new quantity'>
                                <br>
                                <button>Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>";
            }
            // Connection close  
            mysqli_close($connection);
            ?>
        </div>
    </body>
</html>