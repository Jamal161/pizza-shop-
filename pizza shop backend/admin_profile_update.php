<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['update'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   $update_profile = $conn->prepare("UPDATE `admin` SET name = ? WHERE id = ?");
   $update_profile->execute([$name, $admin_id]);

   $user_pass = $_POST['user_pass'];
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $confirm_pass = sha1($_POST['confirm_pass']);
   $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);
   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';

   if($old_pass != $empty_pass){
      if($user_pass != $old_pass){
         $message[] = 'old password not matched!';
      }elseif($new_pass != $confirm_pass){
         $message[] = 'confirm password not matched!';
      }else{
         if($new_pass != $empty_pass){
            $update_pass = $conn->prepare("UPDATE `admin` SET password = ?        WHERE id = ?");
            $update_pass->execute([$confirm_pass, $admin_id]);
            $message[] = 'password updated successfully!';
         }else{
            $message[] = 'please enter a new password!';
         }
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update admin profile</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>

<?php include 'admin_header.php'; ?>
   
<section class="form-container">

   <form action="" method="post">
      <h3>update profile</h3>
      <input type="hidden" name="user_pass" value="<?= $fetch_profile['password']; ?>">
      <input type="text" name="name" required class="box" placeholder="enter your username" maxlength="20" value="<?= $fetch_profile['name']; ?>" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="old_pass" class="box" placeholder="enter your old password" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" class="box" placeholder="enter a new password" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="confirm_pass" class="box" placeholder="confirm your new password" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="update" name="update" class="btn">
   </form>

</section>








<script src="js/admin_script.js"></script>

</body>
</html>