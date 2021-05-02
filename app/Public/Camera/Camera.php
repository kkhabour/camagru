<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Camera</title>

    <link rel="stylesheet" href="./Public/Css/camera.css" />
    <link rel="stylesheet" href="./Public/Css/user_home_nav.css" />
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
            <div class="main-content-posts-camera">
              <img id="camera_image" />
              <video id="camera_video"></video>
            </div>

            <div class="main-content-posts-photo"></div>

            <div class="main-content-posts-buttons">
              <button id="camera_picture_button">PICTURE</button>
              <button id="camera_restore_button">RESTORE</button>
              <button id="camera_add_button">ADD</button>
              <button id="camera_post_button">POST</button>
            </div>

            <div class="main-content-posts-photos">
              <h3>Previous pictures taken</h3>

              <div class="main-content-posts-photos-wrapper">

                <div class="main-content-posts-photos-wrapper-nophoto">
                  <img src="./Public/Images/posts.svg" alt="" />
                  <h6>No photos taken yet</h6>
                </div>



              </div>
            </div>
          </div>

          <div class="main-content-side"></div>
        </div>
      </main>

      <footer class="main-footer">
            <span>@kkhabour 1337 school, second promo 2020</span>
      </footer>

    </section>




  </body>

  <script src="./Public/js/camera.js"></script>
  <script src="./Public/js/movesticker.js"></script>
  <script src="./Public/js/addstickers.js"></script>
  <script src="./Public/js/cameratools.js"></script>
  <script src="./Public/js/cameraaddphotos.js"></script>
  

  <script src="./Public/js/cameradelimage.js"></script>

</html>
