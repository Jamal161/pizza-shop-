<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_users = $conn->prepare("DELETE FROM `admin` WHERE id = ?");
   $delete_users->execute([$delete_id]);
   header('location:admin_accounts.php');

};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>accounts</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>

<?php include 'admin_header.php'; ?>
   
<section class="accounts">

   <h1 class="heading">admin accounts</h1>

   <div class="box-container">

      <div class="box">
         <p>add new admin</p>
         <a href="admin_register.php" class="option-btn">register admin</a>
      </div>

      <?php
         $select_account = $conn->prepare("SELECT * FROM `admin`");
         $select_account->execute();
         while($fetch_account = $select_account->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="box">
         <p> user id : <span><?= $fetch_account['id']; ?></span></p>
         <p> username : <span><?= $fetch_account['name']; ?></span></p>
         <div class="flex-btn">
            <a href="admin_accounts.php?delete=<?= $fetch_account['id']; ?>" onclick="return confirm('delete this admin?');" class="delete-btn">delete</a>
            <?php
               if($fetch_account['id'] == $admin_id){
                  echo '<a href="admin_profile_update.php" class="option-btn">update</a>';
               }
            ?>
         </div>

      </div>
      <?php
      }
      ?>
   </div>

</section>








<script src="js/admin_script.js"></script>

</body>
</html>