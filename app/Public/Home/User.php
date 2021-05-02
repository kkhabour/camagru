<?php 

    $user = SessionHelper::get_user();
    $host = getenv('REQUEST_SCHEME') . '://' . getenv('http_host') . '/';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="./Public/Css/home.css">
    <link rel="stylesheet" href="./Public/Css/user_home_nav.css">

    <link rel="stylesheet" href="./Public/Css/homesidebar.css">

</head>
<body>
    <section class="section">

        <header class="header">
            <nav class="header-nav">
                <div class="header-nav-logo">
                    <h4>camagru</h4>
                </div>
                <div class="header-nav-list">
                    <a href="home">
                    <img src="./Public/Images/icons/HomeMajor.svg" />
                    </a>

                    <a href="camera">
                    <img src="./Public/Images/icons/CameraMajor.svg" />
                    </a>

                    <a href="profile">
                    <img src="./Public/Images/icons/CustomersMajor.svg" />
                    </a>

                    <a href="logout">
                    <img src="./Public/Images/icons/LogOutMinor.svg" />
                    </a>
                </div>
            </nav>
        </header>

        <main class="main">
            <div class="main-content">
                <div class="main-content-posts">                    


                <?php 
                    require_once "./Server/Home/getarticles.php";
                    print_articles();
                ?>

                
                </div>
                <div class="main-content-side">
                    <div class='main-content-side-content'>

                        <div class='user-profile'>
                            <div class='user-profile-img'>
                                <div 
                                style=" background-image: url(
                                <?php
                                    if(is_null($user->get_image()) == false && $user->get_image() != 'null')
                                        echo $user->get_image();
                                    else
                                        echo "./Public/Images/avatar.png";
                                ?>);"></div>

                            </div>
                            <div class='user-profile-data'>
                                <span><?php echo $user->get_username()?></span>
                                <span><?php echo $user->get_firstname() . ' ' . $user->get_lastname(); ?></span>
                            </div>


                        </div>


                        <h5>Last recent likes</h5>


                        <div class='bar-users'>


                            <?php

                                require_once "Server/Home/SideBar.php";
                                lastlikes($user->get_id());
                            ?>



                        

                        </div>
                    </div>


                    <footer>
                        <span>&copy; 2021 CAMAGRU FROM KKHABOUR</span>
                    </footer>
                </div>
            </div>
        </main>
    
    </section>






    <script src="Public/js/addcomment.js"></script>    
    <script src="Public/js/like.js"></script>
    <script src="Public/js/pagination.js"></script>    


</body>

</html>