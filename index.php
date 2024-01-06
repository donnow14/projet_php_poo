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
                    <a class="active" href="#" >Home</a>
                </li>
                <li>
                    <a href="dashboard.php" >Dashboard</a>
                </li>
                <li>
                    <a href="contact.php" >Contact us</a>
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

        
        <img style="display:block;margin-left: auto;margin-right:auto;width:70%" src="https://png.pngtree.com/png-clipart/20230209/original/pngtree-website-under-construction-concept-png-image_8949640.png" alt="website under construction">
     
     </section>
     <script>
        window.location.href = 'dashboard.php';

        document.getElementById('menu-button').addEventListener('click', function() {
          document.querySelector('nav').classList.toggle('show');
        });
      </script>
    
</body>


</html>
