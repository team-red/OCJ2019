<html>

  <body>
  
  <?php
    print_r($_POST);
  ?>

  <form method="POST">

    <fieldset name="xy">

    <input type="text" placeholder="name" name="bla"> 
    <input type="text" placeholder="surname" name="foo">

    </fieldset> 

    <input type="text" placeholder="titre" name="questions[][title]">

    <input type="text" placeholder="texte" name="questions[][body]">

    <input type="text" placeholder="titre" name="questions[][title]">
    
    <input type="text" placeholder="texte" name="questions[][body]">

    <input type="submit">

  </form>


  </body>


</html>
