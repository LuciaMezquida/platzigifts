<?php 
//Template Name: Página Institucional
get_header(); 
$fields = get_fields(); //nos genera un arraycon todos los campos que le hemos puesto
?>
<main class='container'>
  <h1 class='my-3'><?php echo $fields['titulo']; ?></h1>
  <?php if(have_posts()){
            while(have_posts()){
                the_post(); ?>
  <img src="<?php echo $fields['imagen'] ?>" alt="">
  <hr>
  <?php the_content(); ?>

  <?php }
    }?>
</main>

<?php get_footer(); ?>