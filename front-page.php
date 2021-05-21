<?php get_header(); ?>

<main class='container'>
  <?php if(have_posts()){
            while(have_posts()){
                the_post(); ?>
  <h1 class='my-3'><?php the_title(); ?>!!</h1>
  <?php the_content(); ?>

  <?php    }
    }?>
  <!-- añadimos un listado de productos -->
  <div class="lista-productos my-5">
    <h2 class='text-center'>PRODUCTOS</h2>

    <!-- Construcción de un filtro dinámico -->
    <div class="row">
      <div class="col-12">
        <select class='form-control' name="categorias-productos" id="categorias-productos">
          <option value="">Todas las categorías</option>
          <?php $terms = get_terms('categoria-productos', array('hide_empty' => true)) ?>
          <?php foreach ($terms as $term) {
            echo '<option value="'.$term->slug.'">' .$term->name.'</option>';
          } ?>
        </select>
      </div>
    </div>
    <div id='resultado-productos' class="row">
      <?php
        $args = array(
            'post_type' => 'producto', //tipo de contenido que va a traer, debe ser el mismo que pusimos al regisrarlo
            'post_per_page' => -1, //define la cantidad de productos que va a traer. Con -1 nos trae todos. Si no ponemos nada, nos traerá los establecido por defecto en WP
            'order'         => 'ASC', //el orden en el que se va a traer nuestro contenido. Por defecto es descendente por fecha de carga -> DESC
            'orderby'       => 'title' //por defecto es date, pero aquí los ordenamos por título
        );

        $productos = new WP_Query($args); //instancia

        if($productos->have_posts()){
            while($productos->have_posts()){
                $productos->the_post();
                ?>

      <div class="col-4">
        <figure>
          <?php the_post_thumbnail('large'); ?>
        </figure>
        <h4 class='my-3 text-center'>
          <!-- devuelve la url que corresponde a este producto y la imprime -->
          <a href="<?php the_permalink(); ?>">
            <?php the_title();?>
          </a>
        </h4>
      </div>

      <?php }
        }

        ?>
    </div>
  </div>
  <div class="container text-center">
    <div class="row">
      <div class="col-12">
        <h2>Últimas Novedades</h2>
      </div>
    </div>
    <div id="resultado-novedades" class="row">

    </div>
  </div>
</main>

<?php get_footer(); ?>