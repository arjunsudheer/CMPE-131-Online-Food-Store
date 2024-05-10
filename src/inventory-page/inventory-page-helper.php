
<?php 
    $counter = 0;
    $allItems = "";
    $tester = "";
    $type = "";
    $counterString = "";
    $useSearch = false;
    $searchVal = "";
    $sort = "A-Z";
    $specFilter = false;
    $sortDB = "SELECT * FROM items ORDER BY Product, Brand";
    $inStock = false;
    $initial = false;
    $imgWidth = 0;
    $imgHeight = 0;

    //print_r($_POST);

    if (isset($_POST['searchbar']))
    {
        $sortDB = "SELECT * FROM items Where Product LIKE '%" . $_POST['searchbar'] . "%' ORDER BY Product, Brand";
        $searchVal = $_POST['searchbar'];
    }

    if (isset($_POST['add']))
    {
        addNewItem($_POST);
    }

    if (isset($_POST['del']) || isset($_POST['price']) || isset($_POST['weight']) || isset($_POST['quant']))
    {
        checkEdits($_POST);
    }

    function throwError()
    {
        echo "
                <script type='text/javascript'> 
                        alert('unable to edit'); 
                </script>
                ";
    }

    if (isset($_POST['az']) || isset($_POST['za']) || isset($_POST['inStock']))
    {
        checkFilter($_POST);
    }

    // Setting up connection with database 
    $connection = mysqli_connect("localhost", "root", "", "ofs"); 

    // Check connection 
    if (mysqli_connect_errno()) 
    { 
        echo "Database connection failed."; 
    } 

    try {
        // Execute the query and store the result set 
        mysqli_multi_query($connection, $sortDB);
    } catch (\Throwable $th) {
        $sortDB = "SELECT * FROM items ORDER BY Product, Brand";
        mysqli_multi_query($connection, $sortDB);
        echo "
                <script type='text/javascript'> 
                        alert('unable to add'); 
                </script>
                ";
        
    }

    if (mysqli_more_results($connection))
    {
        mysqli_next_result($connection);
    }

    $result = mysqli_store_result($connection);

    if (isset($_POST['all']) || $type == "all" || $useSearch) 
    {
        $type = "all";
    }

    else if (isset($_POST['fruit']) || $type == "fruit")
    {
        $type = "fruit";
        $specFilter = true;
    }

    else if (isset($_POST['vegetable']) || $type == "vegetable")
    {
        $type = "vegetable";
        $specFilter = true;
    }

    else if (isset($_POST['meat']) || $type == "meat")
    {
        $type = "meat";
        $specFilter = true;
    }

    else if (isset($_POST['dairy']) || $type == "dairy")
    {
        $type = "dairy";
        $specFilter = true;
    }

    else if (isset($_POST['sweet']) || $type == "sweet")
    {
        $type = "sweet";
        $specFilter = true;
    }

    addItems($_POST, $result, $type, $specFilter);

    $counterString = $counter . " results";

    $_POST['search'] = "";
    $_POST['searchbar'] = "";

    // Connection close  
    mysqli_close($connection);

    function AddItems($request, $result, $type, $specFilter)
    {
        global $counter, $allItems, $useSearch;

        if ($useSearch)
            $type = "all";

        while ($row = mysqli_fetch_array($result)) 
        {
            if ($specFilter)
            {
                if ($type == "fruit")
                    if ($row["Type"] != "Fruits")
                        continue;
                if ($type == "vegetable")
                    if ($row["Type"] != "Vegetables")
                        continue;
                if ($type == "meat")
                    if ($row["Type"] != "Meat")
                        continue;
                if ($type == "dairy")
                    if ($row["Type"] != "Dairy")
                        continue;
                if ($type == "sweet")
                    if ($row["Type"] != "Sweet")
                        continue;
            }

            $stockStatus = "";
            if ($row['inStock'] == 0)
            {
                $stockStatus = "(Sold Out!)";
            }

            $counter = $counter + 1;
            $allItems = $allItems . 
            "<div class='item' id='" . $row["Product"] . "-" . $row["Brand"] . "'>
                <div class='top-item'>
                    <img src='../../../../OFS_Binary/" . $row["Image"] . "' class='image'>
                    <div class='itemDesc1'>
                        <p>
                            Type: " . $row["Type"] . " <br>
                            Product: " . $row["Product"] . " <br>
                            Brand: " . $row["Brand"] . " " . $stockStatus . "
                        </p>
                        <form method='post'>
                            <input type='submit' class='remove' name='del' value='Remove' />
                            <input type='hidden' name='delVal' value='" . $row["Brand"] . "' />
                        </form>
                    </div>
                </div>
                <div class='itemDesc2'>
                    <div class='edit'>
                        <div class='price'>
                            <div class='priceDesc'>
                                <p>Price: " . $row["Price"] . "</p>
                            </div>
                            <form method='post'>
                                <input type='text' class='changer' name='price' placeholder='Enter' />
                                <br>
                                <input type='submit' class='editInputs' value='Submit' />
                                <input type='hidden' name='newPrice' value='" . $row["Brand"] . "' />
                            </form>
                        </div>
                        <div class='weight'>
                            <div class='weightDesc'>
                                <p>Weight: " . $row["Weight"] . "</p>
                            </div>
                            <form method='post'>
                                <input type='text' class='changer' name='weight' placeholder='Enter' />
                                <br>
                                <input type='submit' class='editInputs' value='Submit' />
                                <input type='hidden' name='newWeight' value='" . $row["Brand"] . "' />
                            </form>
                        </div>
                        <div class='quantity'>
                            <div class='quantityDesc'>
                                <p>Quantity: " . $row["numStock"] . "</p>
                            </div>
                            <form method='post'>
                                <input type='text' class='changer' name='quant' placeholder='Enter' />
                                <br>
                                <input type='submit' class='editInputs' value='Submit' />
                                <input type='hidden' name='newQuant' value='" . $row["Brand"] . "' />
                            </form>
                        </div>
                    </div>
                </div>
            </div>";
        }
    }

    function throwAddError($error)
    {
        switch ($error)
        {
            case 1:
                echo 
                "
                    <script type='text/javascript'> 
                            alert('unable to add image (Common cause: image is not 1:1 resolution)'); 
                    </script>
                ";
                break;
            case 2:
                echo 
                "
                    <script type='text/javascript'> 
                            alert('unable to add item (Common cause: Empty text/image field)'); 
                    </script>
                ";
                break;
            case 3:
                echo 
                "
                    <script type='text/javascript'> 
                            alert('unable to add item (Price value invalid)'); 
                    </script>
                ";
                break;
            case 4:
                echo 
                "
                    <script type='text/javascript'> 
                            alert('unable to add item (Weight value invalid)'); 
                    </script>
                ";
                break;
            case 5:
                echo 
                "
                    <script type='text/javascript'> 
                            alert('unable to add item (Quantity value invalid)'); 
                    </script>
                ";
                break;
        }
    }

    function addNewItem($request)
    {
        global $sortDB;

        $addImage = $request['addImage'];
        $addType = 0;
        $addProduct = $request['addProduct'];
        $addBrand = $request['addBrand'];
        $addPrice = $request['addPrice'];
        $addWeight = $request['addWeight'];
        $addQuantity = $request['addQuantity'];
        $inStock = true;

        switch ($request['addType'])
        {
            case 1:
                $addType = "Fruits";
                break;
            case 2:
                $addType = "Vegetables";
                break;
            case 3:
                $addType = "Meat";
                break;
            case 4:
                $addType = "Dairy";
                break;
            case 5:
                $addType = "Sweet";
                break;
        }
        
        $image_path = "D:/SJSU/CMPE_131/OFS_Binary/" . $addImage;

        list($imgWidth, $imgHeight) = getimagesize($image_path);
        if ($imgWidth % $imgHeight != 0)
        {
            throwAddError(1);
            return;
        }

        if ($addProduct == "" || $addProduct == "")
        {
            throwAddError(2);
            return;
        }

        if (!(is_double($addPrice)) && (double)$addPrice <= 0)
        {
            throwAddError(3);
            return;
        }

        if (!(is_double($addWeight)) && (double)$addWeight <= 0) 
        {
            throwAddError(4);
            return;
        }

        if (!(is_int($addQuantity)) && fmod((double)$addQuantity, 1) != 0)
        {
            throwAddError(5);
            return;
        }

        if ($addQuantity == 0)
            $inStock = false;
            
        $sortDB = "INSERT INTO items (Type, Product, Brand, Price, Weight, numStock, inStock, Image) VALUES ('" . $addType . "', '" . $addProduct . "', '" . 
        $addBrand . "', '" . $addPrice . "', '" . $addWeight . "', '" . $addQuantity . "', '" . $inStock . "', '" . $addImage . "');" . 
        "SELECT * FROM items ORDER BY Product, Brand";  
        return; 
    }

    function checkEdits($request)
    {
        global $type, $sortDB;

        $type = "all";

        if (isset($request['del']))
        {
            $sortDB = "DELETE FROM items WHERE Brand ='" . $_POST['delVal'] . "';" 
            . "SELECT * FROM items ORDER BY Product, Brand";
            return;
        }
    
        else if (isset($request['price']))
        {
            if (is_double((double)$request['price']))
                if ((double)$request['price'] > 0)
                {
                    $sortDB = "UPDATE items SET Price = '" . $_POST['price'] . "' WHERE Brand = '" . $_POST['newPrice'] . "';" 
                    . "SELECT * FROM items ORDER BY Product, Brand";
                    return;
                }
        }
    
        else if (isset($request['weight']))
        {
            if (is_double((double)$request['weight']))
                if ((double)$request['weight'] > 0)
                {
                    $sortDB = "UPDATE items SET Weight = '" . $_POST['weight'] . "' WHERE Brand = '" . $_POST['newWeight'] . "';" 
                    . "SELECT * FROM items ORDER BY Product, Brand";
                    return;
                }
        }
    
        else if (isset($request['quant']))
        {
            if (is_int((int)$request['quant']) && fmod((double)$request['quant'], 1) == 0)
            {
                if ((int)$request['quant'] > 0)
                {
                    $sortDB = "UPDATE items SET numStock = '" . $_POST['quant'] . "', inStock = '1' WHERE Brand = '" . $_POST['newQuant'] . "';" 
                    . "SELECT * FROM items ORDER BY Product, Brand";
                    return;
                }
                else if ($request['quant'] == 0)
                {
                    $sortDB = "UPDATE items SET numStock = '0', inStock = '0' WHERE Brand = '" . $_POST['newQuant'] . "';" 
                    . "SELECT * FROM items ORDER BY Product, Brand";
                    return;
                }
            }
        }

        throwError();
    }

    function checkFilter($request)
    {
        global $type, $sortDB, $sort;
        
        $type = $request['filter'];
        if (isset($request['az']))
        {
            $sortDB = "SELECT * FROM items ORDER BY Product, Brand";
            $sort = "A-Z";
        }
        else if (isset($_POST['za']))
        {
            $sortDB = "SELECT * FROM items ORDER BY Product DESC, Brand DESC";
            $sort = "Z-A";
        }
        else if (isset($_POST['inStock']))
        {
            $sortDB = "SELECT * FROM items ORDER BY inStock DESC, Product";
            $sort = "In Stock";
        }
    }

?>