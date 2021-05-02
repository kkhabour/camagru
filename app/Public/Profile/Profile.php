<?php
    $user = SessionHelper::get_user();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <link rel="stylesheet" href="./Public/Css/profile.css">
    <link rel="stylesheet" href="./Public/Css/user_home_nav.css">
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
                        <img src="./Public/Images/icons/HomeMajor.svg">
                    </a>
                    
                    <a href="camera">
                        <img src="./Public/Images/icons/CameraMajor.svg">
                    </a>

                    <a href="profile">
                        <img src="./Public/Images/icons/CustomersMajor.svg">
                    </a>

                    <a href="logout">
                        <img src="./Public/Images/icons/LogOutMinor.svg" >
                    </a>
                </div>
            </nav>
        </header>

        <main class="main">
            <div class="main-content">
                <div class="main-content-user-data">
                    <div class="main-content-user-data-img">
                        <img id="profile-img" 
                            <?php 
                                if ($user->get_image() != "null" && !is_null($user->get_image()))
                                    echo "src='http://" . getenv('http_host') . "/" . $user->get_image() . "'";
                                else
                                    echo 'src="./Public/Images/avatar.png"';
                            ?>
                        />
                    </div>
                    <input type="file" id="img-open" name="profile_image">
                    <div class="main-content-user-data-full-name">
                        <?php echo strtoupper($user->get_firstname() . " " . $user->get_lastname()); ?>
                    </div>
                    <div class="main-content-user-data-username">
                        <?php echo "@" . $user->get_username(); ?>
                    </div>
                </div>

                <div class="main-content-user">
                    <form class="main-content-user-form" action="profile" method="post">
                        <div>
                            <div>
                                <label for="firstname">Firstname</label>
                                <input type="text" name="firstname" 
                                    <?php echo "value=\"" . $user->get_firstname() ."\""; ?>
                                >
                            </div>
                            <div>
                                <label for="firstname">Lastname</label>
                                <input type="text" name="lastname"
                                    <?php echo "value=\"" . $user->get_lastname() ."\""; ?>
                                >
                            </div>
                        </div>
    
                        <div>
                            <label for="username">Username</label>
                            <input type="text" name="username"
                                <?php echo "value=\"" . $user->get_username() ."\""; ?>
                            >
                        </div>
    
                        <div>
                            <label for="email">Email address</label>
                            <input type="text" name="email"
                                <?php echo "value=\"" . $user->get_email() ."\""; ?>
                            >
                        </div>
    
                        <div>
                            <label for="oldpassword">Old password</label>
                            <input type="password" name="oldpassword" placeholder="••••••••••">
                        </div>
    
                        <div>
                            <label for="newpassowrd">New password</label>
                            <input type="password" name="newpassowrd" placeholder="••••••••••">
                        </div>

                        <div id="form-checkbox">
                            <input type="checkbox" name="comment" 
                                <?php
                                    if ($user->get_comment())
                                        echo 'checked';
                                ?>
                            >
                            <span class="checkmark">comment notify email</span>
                        </div>


                        <?php
                            if ($error != null)
                              echo "<p class='error'>" . $error . "</p>";
                        ?>

                        <div>
                            <button type="submit" name="update" value="update">UPDATE</button>
                        </div>

                    </form>
                </div>

            </div>
        </main>
    
    </section>

</body>

    <script src="./Public/js/profile.js"></script>
</html>