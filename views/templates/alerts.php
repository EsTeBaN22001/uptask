<?php 

foreach($alerts as $key => $messages):
  foreach($messages as $message): 
?>

  <div class="alert <?= $key; ?>">
    <?= $message; ?>
  </div>

<?php
  endforeach;
endforeach;

?>