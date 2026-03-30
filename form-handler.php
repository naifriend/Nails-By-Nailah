<?php
//var_dump($_SERVER["REQUEST_METHOD"]); {
    //testing to see if web site is usign post method 
/*if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // if user is using a request method = to POST, then the code in the {} can run 
   $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $phonenum = htmlspecialchars($_POST["phonenum"]);
    $message = htmlspecialchars($_POST["message"]);
    //htmlspecialchars- for security, the clients input wont be seen as code, itll be seen as html entities. used to escape HTML in order to prevent XSS attacks.
if (empty($name)) {
    header("Location: ../contact.html");
    exit();
    //checks if variable contains no data. if it returns true, this mean user didnt submit name. exit- script stops and doesnt continue to run. "required in html form action isnt secure, user can alter the code and bypass this. 
    
}
    
    echo "Data user submitted:";
    echo "<br>";
    echo $name;
    echo "<br>";
    echo $email;
    echo "<br>";
    echo $phonenum;
    echo "<br>";
    echo $message;
    
    //QUESTION: how do i get user to return back to contact html and i still see the user output 
    
    //header("Location: ../contact.html");
    //makes sure user goes back to orignal page after submitting 
}

//else{
   // header("Location: ../contact.html");
        //if user types in page user.. theyll still be brought back this page

//if user access this page using a request method that is =to POST, then we allow code to be ran insde the {} */


//-----------------DATABASE CONNECT CODE-----------//
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// if user is using a request method = to POST, then the code in the {} can run 
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phonenum = $_POST["phonenum"];
    $message = $_POST["message"];//htmlspecchar not needed because info is being submitted into database, not out putted into browser.

    try {
       
        $pdo = new PDO('mysql:host=localhost;dbname=nailsbynailah;port=3306;charset=utf8mb4', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//db connection

    
        $query = "INSERT INTO contact (name, email, phonenum, message)
                  VALUES (:name, :email, :phonenum, :message)";// sql query using placeholders

    
        $stmt = $pdo->prepare($query);// prepared statement to query this query into database. submitting query so it can run in database
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phonenum', $phonenum);
        $stmt->bindParam(':message', $message);


        $stmt->execute();//submits data from user and signs them up inside website.

       
        $stmt = null;
        $pdo = null;//null: saying theyre not equal to anything and to free up those resources

        
        header("Location: ../contact.html?success=true");
        exit;

    } catch (PDOException $e) {
//if a block of code is ran, and it fails, itll catch an exception
        die("Query failed: " . $e->getMessage()); //code will stop running and run error message
    }
} else {
    header("Location: ../contact.html");
    exit;
}
?>
