
<?php 
        $counter = 0;
        $allItems = "";
        $tester = "";
        $type = "";
        $counterString = "";
        $useSearch = false;
        $searchVal = "";
        $sortDB = "SELECT Type, Product, Brand, Price, Weight, numStock, inStock FROM items ORDER BY Product";

        if (isset($_POST['searchbar']))
        {
            $searchVal = $_POST['searchbar'];
            $useSearch = true;
        }

        if (array_key_exists('az', $_POST) || array_key_exists('za', $_POST) || array_key_exists('inStock', $_POST))
        {
            if (array_key_exists('az', $_POST))
            {
                $type = $_POST['filter'];
                $sortDB = "SELECT Type, Product, Brand, Price, Weight, numStock, inStock FROM items ORDER BY Product";
            }
            else if (array_key_exists('za', $_POST))
            {
                $type = $_POST['filter'];
                $sortDB = "SELECT Type, Product, Brand, Price, Weight, numStock, inStock FROM items ORDER BY Product DESC";
            }
            else if (array_key_exists('inStock', $_POST))
            {
                $type = $_POST['filter'];
                $sortDB = "SELECT Type, Product, Brand, Price, Weight, numStock, inStock FROM items ORDER BY Product, inStock";
            }
        }
        
        // Setting up connection with database Geeks 
        $connection = mysqli_connect("localhost", "root", "", "ofs"); 

        // Check connection 
        if (mysqli_connect_errno()) 
        { 
            echo "Database connection failed."; 
        } 

        // Execute the query and store the result set 
        $result = mysqli_query($connection, $sortDB);

        if (array_key_exists('all', $_POST) || $type == "all" || $useSearch) { 
            while ($row = mysqli_fetch_array($result)) {
                if ($useSearch)
                {
                    if ($row["Product"] != $searchVal)
                        continue;
                }
                $counter = $counter + 1;
                $allItems = $allItems . 
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
            $type = "all";
        }

        else if (array_key_exists('fruit', $_POST) || $type == "fruit") { 
            while ($row = mysqli_fetch_array($result)) {
                if ($row["Type"] == "Fruits")
                {
                    $counter = $counter + 1;
                    $allItems = $allItems . 
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
            }
            $type = "fruit";
        } 

        else if (array_key_exists('vegetable', $_POST) || $type == "vegetable") { 
            while ($row = mysqli_fetch_array($result)) {
                if ($row["Type"] == "Vegetables")
                {
                    $counter = $counter + 1;
                    $allItems = $allItems . 
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
            }
            $type = "vegetable";
        }

        $counterString = "<p style='display:inline-block' value='counter'> " . $counter . " results</p>";

        $_POST['search'] = "";
        $_POST['searchbar'] = "";

        // Connection close  
        mysqli_close($connection);

    ?>