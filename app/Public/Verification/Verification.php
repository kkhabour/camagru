<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>

    <style> 
    
      .content {
        display : flex;
        flex-direction : column;
        justify-content: center;
        align-items: center;
        height: 40vh;
      }

      .content > div {
        width: 80%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content : center;
      }

      .content > div > * {
        text-align: center;
      }
      
    </style>

  </head>
  <body>

      <div class="content">
        <div>
          <img src="Public/Images/email.svg" width="200">
          <h3>Verify your email address</h3>
          <p>Please click on the link that has just been sent to your email account to verify your email and continue the registration process.</p>
        </div>
      </div>
      

  </body>
</html>