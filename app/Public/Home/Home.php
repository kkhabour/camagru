<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="./Public/Css/home.css">
    <link rel="stylesheet" href="./Public/Css/default_home_nav.css">

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
                    <a href="login">Login</a>
                    <a href="register">Register</a>
                </div>
            </nav>
        </header>

        <main class="main">
            <div class="main-content">
                <div class="main-content-posts">


                    


                <?php 
                    require_once "Server/Home/getarticles.php";
                    print_articles();
                ?>

                
                </div>
                <div class="main-content-side">
                    <div class='main-content-side-content'>


                        <h5>Last recent new users</h5>
                        <div class='bar-users'>


                            <?php

                                require_once "Server/Home/SideBar.php";
                                last_users();
                            ?>

                        </div>
                    </div>


                    <footer>
                    <span>&copy; 2021 CAMAGRU FROM KKHABOUR</span>
                    </footer>

                                                

                </div>
            </div>
        </main>

    
        <footer class="footer">
            <span>@kkhabour 1337 school, second promo 2020</span>
        </footer>
    </section>

    <script src="Public/js/pagination.js"></script>    

    
</body>


</html>