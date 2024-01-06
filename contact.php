<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
   

   
   <link rel="stylesheet" href="css/astyle.css">

</head>

<body class="bg-light">
    <header>
    <div class="logo"><img src="images/EMSI1.png" alt="logo"></div>
        <input type="checkbox" id="nav_check" hidden>
        <nav>
            <ul>
                <li>
                    <a href="index.php" >Home</a>
                </li>
                <li>
                    <a href="dashboard.php">Dashboard</a>
                </li>
                <li>
                    <a href="#" class="active">Contact us</a>
                </li>
                <li>
                    <a href="account.php" >My Account</a>
                </li>
            </ul>
        </nav>
        <label for="nav_check" class="hamburger">
            <div></div>
            <div></div>
            <div></div>
        </label>
    </header>
      

    <section class="contact">

        <div class="row">
     
           <div class="image">
              <img src="images/contact-img.svg" alt="">
           </div>
     
           <form action="" method="post">
              <h3>get in touch</h3>
              <input type="text" placeholder="enter your name" name="name" required maxlength="50" class="box">
              <input type="email" placeholder="enter your email" name="email" required maxlength="50" class="box">
              <input type="number" placeholder="enter your number" name="number" required maxlength="50" class="box">
              <textarea name="msg" class="box" placeholder="enter your message" required maxlength="1000" cols="30" rows="10"></textarea>
              <input type="submit" value="send message" class="inline-btn" name="submit">
           </form>
     
        </div>
     
        <div class="box-container">
     
           <div class="box">
              <i class="fas fa-phone"></i>
              <h3>phone number</h3>
              <a href="tel:0661112233">06 61 11 22 33</a>
              <a href="tel:0661112233">06 61 11 22 33</a>
           </div>
           
           <div class="box">
              <i class="fas fa-envelope"></i>
              <h3>email address</h3>
              <a href="mailto:oussama@gmail.com">oussama@gmail.come</a>
              <a href="mailto:marwa@gmail.com">marwa@gmail.come</a>
           </div>
     
           <div class="box">
              <i class="fas fa-map-marker-alt"></i>
              <h3>address</h3>
              <a href="#">05 lot bouizgaren, Rte de Safi, Marrakech 40000</a>
           </div>
     
        </div>
     
     </section>
     <script>
        document.getElementById('menu-button').addEventListener('click', function() {
          document.querySelector('nav').classList.toggle('show');
        });
      </script>
    
</body>


</html>
