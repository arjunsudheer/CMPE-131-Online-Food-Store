
<?php 
        $counter = 0;
        $allItems = "";
        $tester = "";
        $type = "";
        $counterString = "";
        $useSearch = false;
        $searchVal = "";
        $sort = "";
        $sortDB = "SELECT Type, Product, Brand, Price, Weight, numStock, inStock FROM items ORDER BY Product";
        $inStock = false;

        if (isset($_POST['searchbar']))
        {
            $searchVal = $_POST['searchbar'];
            $useSearch = true;
        }

        if (isset($_POST['add']))
        {
            if ($_POST['addType'] != "" && $_POST['addProduct'] != "" && $_POST['addBrand'] != "" && $_POST['addPrice'] != "" && $_POST['addWeight'] != "" && $_POST['addQuantity'] != "")
            {
                if ($_POST['addQuantity'] >= 1)
                    $inStock = true;
                $sortDB = "INSERT INTO items (Type, Product, Brand, Price, Weight, numStock, inStock) VALUES ('" . $_POST['addType'] . "', '" . $_POST['addProduct'] . "', '" . 
                $_POST['addBrand'] . "', '" . $_POST['addPrice'] . "', '" . $_POST['addWeight'] . "', '" . $_POST['addQuantity'] . "', '" . $inStock . "');" . 
                "SELECT Type, Product, Brand, Price, Weight, numStock, inStock FROM items ORDER BY Product";
            }
            else 
            {
                echo "unable to add";
            }
        }

        if (isset($_POST['del']))
        {
            $type = "all";
            $sortDB = "DELETE FROM items WHERE Brand='" . $_POST['delVal'] . "';" . "SELECT Type, Product, Brand, Price, Weight, numStock, inStock FROM items ORDER BY Product";
        }

        if (isset($_POST['price']))
        {
            $type = "all";
            $sortDB = "UPDATE items SET Price= '" . $_POST['price'] . "' WHERE Brand='" . $_POST['newPrice'] . "';" . "SELECT Type, Product, Brand, Price, Weight, numStock, inStock FROM items ORDER BY Product";
        }

        else if (isset($_POST['weight']))
        {
            $type = "all";
            $sortDB = "UPDATE items SET Weight= '" . $_POST['weight'] . "' WHERE Brand='" . $_POST['newWeight'] . "';" . "SELECT Type, Product, Brand, Price, Weight, numStock, inStock FROM items ORDER BY Product";
        }

        else if (isset($_POST['quant']))
        {
            $type = "all";
            $sortDB = "UPDATE items SET numStock= '" . $_POST['quant'] . "' WHERE Brand='" . $_POST['newQuant'] . "';" . "SELECT Type, Product, Brand, Price, Weight, numStock, inStock FROM items ORDER BY Product";
        }

        if (isset($_POST['az']) || isset($_POST['za']) || isset($_POST['inStock']))
        {
            if (isset($_POST['az']))
            {
                $type = $_POST['filter'];
                $sortDB = "SELECT Type, Product, Brand, Price, Weight, numStock, inStock FROM items ORDER BY Product";
                $sort = "az";
            }
            else if (isset($_POST['za']))
            {
                $type = $_POST['filter'];
                $sortDB = "SELECT Type, Product, Brand, Price, Weight, numStock, inStock FROM items ORDER BY Product DESC";
                $sort = "za";
            }
            else if (isset($_POST['inStock']))
            {
                $type = $_POST['filter'];
                $sortDB = "SELECT Type, Product, Brand, Price, Weight, numStock, inStock FROM items ORDER BY Product, inStock";
                $sort = "inStock";
            }
        }

        // Setting up connection with database 
        $connection = mysqli_connect("localhost", "root", "", "ofs"); 

        // Check connection 
        if (mysqli_connect_errno()) 
        { 
            echo "Database connection failed."; 
        } 

        // Execute the query and store the result set 
        mysqli_multi_query($connection, $sortDB);

        if (mysqli_more_results($connection))
        {
            mysqli_next_result($connection);
        }

        $result = mysqli_store_result($connection);

        if (isset($_POST['all']) || $type == "all" || $useSearch) { 
            $type = "all";
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
                                <form method='post'>
                                    <input type='text' class='changer' name='price' placeholder='Enter new price' />
                                    <br>
                                    <input type='submit' class='editInputs' value='Submit' />
                                    <input type='hidden' name='newPrice' value='" . $row["Brand"] . "' />
                                </form>
                            </div>
                            <div class='weight'>
                                <div class='weightDesc'>
                                    <p>Weight:&nbsp</p>
                                    <p id='weight'>" . $row["Weight"] . "</p>
                                </div>
                                <form method='post'>
                                    <input type='text' class='changer' name='weight' placeholder='Enter new weight' />
                                    <br>
                                    <input type='submit' class='editInputs' value='Submit' />
                                    <input type='hidden' name='newWeight' value='" . $row["Brand"] . "' />
                                </form>
                            </div>
                            <div class='quantity'>
                                <div class='quantityDesc'>
                                    <p>Quantity:&nbsp</p>
                                    <p id='quantity'>" . $row["numStock"] . "</p>
                                </div>
                                <form method='post'>
                                    <input type='text' class='changer' name='quant' placeholder='Enter new quantity' />
                                    <br>
                                    <input type='submit' class='editInputs' value='Submit' />
                                    <input type='hidden' name='newQuant' value='" . $row["Brand"] . "' />
                                </form>
                            </div>
                            <form method='post'>
                                <input type='submit' class='editInputs' name='del' value='Remove' />
                                <input type='hidden' name='delVal' value='" . $row["Brand"] . "' />
                            </form>
                        </div>
                    </div>
                </div>";
            }
        }

        else if (isset($_POST['fruit']) || $type == "fruit") { 
            $type = "fruit";
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
                                    <form method='post'>
                                        <input type='text' class='changer' name='priceText" . $row["Brand"] . "' placeholder='Enter new price' />
                                        <br>
                                        <input type='submit' class='editInputs' name='priceButton" . $row["Brand"] . "' value='Submit' />
                                    </form>
                                </div>
                                <div class='weight'>
                                    <div class='weightDesc'>
                                        <p>Weight:&nbsp</p>
                                        <p id='weight'>" . $row["Weight"] . "</p>
                                    </div>
                                    <form method='post'>
                                        <input type='text' class='changer' name='weightText" . $row["Brand"] . "' placeholder='Enter new weight' />
                                        <br>
                                        <input type='submit' class='editInputs' name='weightButton" . $row["Brand"] . "' value='Submit' />
                                    </form>
                                </div>
                                <div class='quantity'>
                                    <div class='quantityDesc'>
                                        <p>Quantity:&nbsp</p>
                                        <p id='quantity'>" . $row["numStock"] . "</p>
                                    </div>
                                    <form method='post'>
                                        <input type='text' class='changer' name='quantText" . $row["Brand"] . "' placeholder='Enter new quantity' />
                                        <br>
                                        <input type='submit' class='editInputs' name='quantButton" . $row["Brand"] . "' value='Submit' />
                                    </form>
                                </div>
                                <form method='post'>
                                    <input type='submit' class='editInputs' name='del" . $row["Brand"] . "' value='Remove' />
                                </form>
                            </div>
                        </div>
                    </div>";
                }
            }
        } 

        else if (isset($_POST['vegetable']) || $type == "vegetable") { 
            $type = "vegetable";
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
        }

        $counterString = "<p style='display:inline-block' value='counter'> " . $counter . " results</p>";

        $_POST['search'] = "";
        $_POST['searchbar'] = "";

        // Connection close  
        mysqli_close($connection);

    ?>