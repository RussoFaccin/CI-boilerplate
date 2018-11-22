<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap-reboot.min.css">
  <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
</head>
<body>
    <div class="pageMessage">
        <p><?= $message ?></p>
    </div>
  <form action="<?php echo base_url('users/auth'); ?>" class="m-userLogin pure-form pure-form-stacked" method="post">
    <label for="fld_login">Login:</label>
    <input type="text" name="fld_user">
    <label for="fld_senha">Senha:</label>
    <input type="password" name="fld_pass">
    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
    <input type="submit" class="pure-button pure-button-primary" value="Log in">
  </form>
</body>
</html