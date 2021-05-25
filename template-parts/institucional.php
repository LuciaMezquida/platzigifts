<?php 
$fields = get_fields(); //nos genera un arraycon todos los campos que le hemos puesto
?>
<h1 class='my-3'><?php echo $fields['titulo']; ?></h1>
<img src="<?php echo $fields['imagen'] ?>" alt="">
<hr>