<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>VerifyEmail</title>

    <style>
      .content {
        display: flex;
        justify-content: center;
        align-items: center;
      }

      .content > div {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
      }

      .content > div > a {
        background-color: black; /* Green */
        border: none;
        color: white;
        padding: 15px 64px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 4px;
        margin-top: 16px;
      }
    </style>
  </head>
  <body>
    <div class="content">
      <div>
        <h2>Congratulations <?php echo $user->get_firstname();?> </php></h2>
        <p>
          Your email <?php echo $user->get_email(); ?> has been successfully verified, you can login now enjoy
          Camagru.
        </p>

        <a href="/login">Login page</a>
      </div>
    </div>
  </body>
</html>
