
<nav class='navbar navbar-expand-lg navbar-light bg-light' id='Unsignined'> 
            <a class='navbar-brand' href='index.php'>Artworks  |<small>    With the lights out, it's less dangerous.</small></a>
            <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'> 
                <span class='navbar-toggler-icon'></span>
            </button> 
         
            <div class='collapse navbar-collapse'> 
                <ul class='navbar-nav mr-auto'> 
                    <li class='nav-item'>
                        <a class='nav-link' href='index.php'>Home <span class='sr-only'>(current)</span></a> 
                    </li> 
                    <li class='nav-item'>
                        <a class='nav-link' href='login.php'>Log in</a> 
                    </li> 
                    <li class='nav-item'>
                        <a class='nav-link' href='sign.php'>Sign in</a> 
                    </li>
                    </li>
                    <li class='nav-item' >
                        <a class='nav-link disabled' href='#'>Cart</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link disabled' href='#'>Personal Info</a>
                    </li> 
                </ul> 
                <form class='form-inline my-2 my-lg-0' action='search.php' method='GET'>
                    <input class='form-control mr-sm-2' type='search' placeholder='Search' aria-label='Search' name='search'> 
                    <button class='btn btn-outline-success my-2 my-sm-0' type='submit'>Search</button> 
                </form> 
            </div> 
        </nav>

<nav class='navbar navbar-expand-lg navbar-light bg-light' id='Signined'> 
        <a class='navbar-brand' href='index.php'>Artworks  |<small>    With the lights out, it's less dangerous.</small></a>
        <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'> 
                <span class='navbar-toggler-icon'></span>
            </button> 
     
        <div class='collapse navbar-collapse'> 
                <ul class='navbar-nav mr-auto'>
                    <li class='nav-item'>
                        <a class='nav-link active' href='personalInformationChange.php' id="usernaame"></a>
                    </li>
                        <li class='nav-item'>
                                <a class='nav-link' href='index.php'>Home <span class='sr-only'>(current)</span></a> 
                            </li> 
                        <li class='nav-item'>
                                <a class='nav-link' href='upload.php'>Upload</a>
                            </li> 
                        <li class='nav-item'>
                                <a class='nav-link' onclick='logout()' href='index.php'>Log out</a>
                            </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='cart.php'>Cart</a>
                    </li>
                        <li class='nav-item'>
                                <a class='nav-link' href='personalInfo.php'>Personal Info</a>
                            </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='message.php'>message</a>

                    </li>
                    <li>
                        <?php
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "pj2";
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        $user=$_COOKIE["username"];
                        $sql="SELECT * FROM users WHERE name='$user'";
                        $result=$conn->query($sql);
                        $usert = $result->fetch_assoc();
                        $userID = $usert["userID"];
                        $sql=$conn->query("SELECT COUNT(*) AS tot FROM message WHERE toUser=$userID AND mark=0");
                        $res=$sql->fetch_assoc();
                        if ($res["tot"]>0) echo "<span class=\"badge badge-danger\">".$res["tot"]."</span>";
                        ?>
                    </li>
                    </ul> 
                <form class='form-inline my-2 my-lg-0' action='search.php' method='get'>
                        <input class='form-control mr-sm-2' type='search' placeholder='Search' aria-label='Search' name='search'> 
                        <button class='btn btn-outline-success my-2 my-sm-0' type='submit' id='searchSubmit'>Search</button> 
                    </form> 
            </div> 
    </nav>
<script>
    document.getElementById("usernaame").innerText="Current user: "+getCookie("username");
</script>