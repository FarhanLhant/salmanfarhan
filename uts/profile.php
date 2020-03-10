<?php
    session_start();
    
    //menambahkan config
    include 'config.php';
    if (!isset($_SESSION["loggedin"])) {
        header("Location: login(complete).php");
        exit;
    }

    //get berdasarkan username
    $uid = $_SESSION["username"] ;
   
    //get data profilenya
    $sql = "select * from profile where username='$uid' ";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result)>0) {
        $data = mysqli_fetch_assoc($result);
    }
    else {
        echo "No data";
    }

    //get data gambarnya
    $sql_img = "select * from photo where username='$uid' ";
    $result_img = mysqli_query($link, $sql_img);
    if (mysqli_num_rows($result_img)>0) {
        $data_img = array();
        while($row = mysqli_fetch_array($result_img)){
            $data_img[]=$row;
        }
    }
    else {
        echo "No photo";
    }

     //mencoba apakah akan ketimpa atau tidak jika digunakan sql yang sama
    //  $sql = "select * from photo where username='$uid' ";
    //  $result = mysqli_query($link, $sql);
    //  if (mysqli_num_rows($result)>0) {
    //      $data = mysqli_fetch_assoc($result);
    //  }
    //  else {
    //      echo "No photo";
    //  }
     // ternyata menggunakan sql yang sama akan menimpa sql yang diatas 
 ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile | Vietgram</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <nav class="navigation">
        <div class="navigation__column">
            <a href="feed.php">
                <img src="images/logo.png" />
            </a>
        </div>
        <div class="navigation__column">
            <i class="fa fa-search"></i>
            <input type="text" placeholder="Search">
        </div>
        <div class="navigation__column">
            <ul class="navigations__links">
                <li class="navigation__list-item">
                    <a href="explore.html" class="navigation__link">
                        <i class="fa fa-compass fa-lg"></i>
                    </a>
                </li>
                <li class="navigation__list-item">
                    <a href="#" class="navigation__link">
                        <i class="fa fa-heart-o fa-lg"></i>
                    </a>
                </li>
                <li class="navigation__list-item">
                    <a href="profile.html" class="navigation__link">
                        <i class="fa fa-user-o fa-lg"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <main id="profile">
        <header class="profile__header">
            <div class="profile__column">
                <img src="<?php echo $data["photoProfile"]; ?>" />
            </div>
            <div class="profile__column">
                <div class="profile__title">
                    <h3 class="profile__username"><?php echo $_SESSION["username"]; ?></h3>
                    <a href="edit-profile.php">Edit profile</a>
                    <i class="fa fa-cog fa-lg"></i>
                </div>
                <ul class="profile__stats">
                    <li class="profile__stat">
                        <span class="stat__number">333</span> posts
                    </li>
                    <li class="profile__stat">
                        <span class="stat__number">1234</span> followers
                    </li>
                    <li class="profile__stat">
                        <span class="stat__number">36</span> following
                    </li>
                </ul>
                <p class="profile__bio">
                    <span class="profile__full-name">
                        <?php echo $data['username']; ?> 
                        <?php echo $data['gender']; ?> <br> 
                    </span> <?php echo $data['bio']; ?> 
                    <a href="#"><?php echo $data["website"]; ?></a>
                </p>
            </div>
        </header>
        <?php foreach ($data_img as $row){ ?>
        <section class="profile__photos">
            <div class="profile__photo">
                <img src="<?php echo $row["url"]; ?>" />
                <div class="profile__photo-overlay">
                    <span class="overlay__item">
                        <i class="fa fa-heart"></i>
                        <?php echo $row["igLike"]; ?>
                    </span>
                    <span class="overlay__item">
                        <i class="fa fa-comment"></i>
                        344
                    </span>
                </div>
            </div>
          
        </section>
        <?php } ?>
         
    </main>
    <footer class="footer">
        <div class="footer__column">
            <nav class="footer__nav">
                <ul class="footer__list">
                    <li class="footer__list-item"><a href="#" class="footer__link">About Us</a></li>
                    <li class="footer__list-item"><a href="#" class="footer__link">Support</a></li>
                    <li class="footer__list-item"><a href="#" class="footer__link">Blog</a></li>
                    <li class="footer__list-item"><a href="#" class="footer__link">Press</a></li>
                    <li class="footer__list-item"><a href="#" class="footer__link">Api</a></li>
                    <li class="footer__list-item"><a href="#" class="footer__link">Jobs</a></li>
                    <li class="footer__list-item"><a href="#" class="footer__link">Privacy</a></li>
                    <li class="footer__list-item"><a href="#" class="footer__link">Terms</a></li>
                    <li class="footer__list-item"><a href="#" class="footer__link">Directory</a></li>
                    <li class="footer__list-item"><a href="#" class="footer__link">Language</a></li>
                </ul>
            </nav>
        </div>
        <div class="footer__column">
            <span class="footer__copyright">© 2017 Vietgram</span>
        </div>
    </footer>
</body>

</html>