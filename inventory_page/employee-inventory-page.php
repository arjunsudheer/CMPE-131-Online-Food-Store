<?php include("../main_page/navbar.html"); ?>

<!DOCTYPE HTML>
<html lang="en">
    <link rel="stylesheet" href="employee-inventory-page.css">
    <link rel="stylesheet" href="../main_page/navbar.css">
    <script src="employee-inventory-page.js"></script>
    <body>
        
        <div style="padding-left: 160px; padding-bottom: 10px;">
            <input type="text" class="searchbar">
            <button style="float:right">Save</button>   
        </div>
        <div style="padding-left: 160px">
            <button>Filter #1</button>
            <button>Filter #2</button>
            <button>Filter #3</button>
            <button>Filter #4</button>
            <button style="float:right">Add Item</button>
        </div>
        <div style="padding-left: 160px">
            <p style="display:inline-block"># of Results</p>
            <select style="float:right; margin-top: 15px">
                <option>A-Z</option>
                <option>Z-A</option>
                <option>Cheapest</option>
                <option>In Stock (A-Z)</option>
                <option>In Stock (Z-A)</option>
            </select>
        </div>
        <div style="padding-left: 160px">
            <div class="item">
                <img style="float:left">
                <div class="itemDesc">
                    <p>Price: ----</p>
                    <p>Weight: ----</p>
                    <p>Quantity: ----</p>
                </div>
                <div class="changeItem">
                    <div>
                        <input type="text" class="changer" placeholder="Enter new price">
                        <button>Submit</button>
                    </div>
                    <div>
                        <input type="text" class="changer" placeholder="Enter new weight">
                        <button>Submit</button>
                    </div>
                    <div>
                        <input type="text" class="changer" placeholder="Enter new quantity">
                        <button>Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>