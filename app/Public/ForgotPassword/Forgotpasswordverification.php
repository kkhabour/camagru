<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset password</title>

    <link rel="stylesheet" href="./Public/Css/loginn.css">


</head>
<body>

    <section class="main">

        <header class="main-header">
            <nav class="main-header-nav">
                <div class="main-header-nav-logo">
                    <h4>camagru</h4>
                </div>

                <div class="main-header-nav-list">
                    <a href="https://www.1337.ma">
                        <svg width="64" height="20" viewBox="0 0 76 20" fill="none">
                          <path
                            d="M2.8333 17.6623H5.92418V2.33766H2.31816V5.45455H0V1.49012e-07H8.75748V17.6623H11.8484V20H2.8333V17.6623Z"
                            fill="black"
                          ></path>
                          <path
                            d="M21.3785 17.6623H30.6512V10.9091H22.1513V8.57143H30.6512V2.33766H21.3785V0H33.4845V20H21.3785V17.6623Z"
                            fill="black"
                          ></path>
                          <path
                            d="M42.2419 17.6623H51.5146V10.9091H43.0147V8.57143H51.5146V2.33766H42.2419V0H54.3479V20H42.2419V17.6623Z"
                            fill="black"
                          ></path>
                          <path
                            d="M72.6355 2.33766H64.9084V7.27273H62.5902V0H75.2113V20H72.6355V2.33766Z"
                            fill="black"
                          ></path>
                        </svg>
                      </a>
              
                </div>
            </nav>

        </header>


        <main class="main-content">

            <div class="main-content-wrapper">
                <div class="main-content-wrapper-form">
                    
                    <form class="main-content-wrapper-form-form" style="min-width: 258px" action="" method="post">
                        
                        <h5 name="changepasswordemail" value="asd"><?php echo $email; ?></h5>
                        <h1>Reset password</h1>
                    
                        <label for="email-address">New password</label>
                        <input type="password" name="changenewpassword" id="login" placeholder="••••••••••">            

                        <label for="password">Confim password</label>
                        <input type="password" name="changeconfirmpassword" id="password" placeholder="••••••••••">
                      

                        <?php
                              if (isset($error) &&$error != null)
                                echo "<p class='error'>" . $error . "</p>";
                        ?>


                        <div>
                            <button type="submit" name="changepassword" value="changepassword">Change</button>
                        </div>
              
                    </form>
                    
                </div>

                <div class="main-content-wrapper-side">
                    <div class="main-content-wrapper-side-wrapper">
                        <img src="./Public/Images/connected_black.svg" >
                    </div>
                </div>
            </div>
        </main>

        <footer class="main-footer">
            <span>@kkhabour 1337 school, second promo 2020</span>
        </footer>

    </section>
</body>
</html>