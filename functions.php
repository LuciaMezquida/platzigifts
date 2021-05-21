<?php 

function init_template(){

    add_theme_support('post-thumbnails');
    add_theme_support( 'title-tag');
    register_nav_menus(
      array(
          'top_menu' => 'Menú Principal'
      )
  );

}
add_action('after_setup_theme','init_template');


function assets(){
  wp_register_style('bootstrap','https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css', '', '4.4.1','all');
  wp_register_style('montserrat', 'https://fonts.googleapis.com/css?family=Montserrat&display=swap','','1.0', 'all');
  wp_enqueue_style('estilos', get_stylesheet_uri(), array('bootstrap','montserrat'),'1.0', 'all');
  wp_register_script('popper','https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js','','1.16.0', true);
  wp_enqueue_script('boostraps', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js', array('jquery','popper'),'4.4.1', true);
  wp_enqueue_script('custom', get_template_directory_uri().'/assets/js/custom.js', '', '1.0', true);
  wp_localize_script('custom', 'pg', array(
    'ajaxurl' => admin_url('admin-ajax.php'),
    'apiurl' => home_url('/wp-json/pg/v1/')
  ) //nos permite enviar info desde php en un objeto a un archivo JS determinado
); 
}

add_action('wp_enqueue_scripts','assets');

function sidebar(){
  register_sidebar(
      array(
          'name' => 'Pie de pagina',
          'id' => 'footer',
          'description' => 'Zona de Widgets para pie de pagina',
          'before_title' => '<p>',
          'after_title' => '</p>',
          'before_widget' => '<div id="%1$s" class= "%2$s">',
          'after_widget'  => '</div>',
      )    
      );
  
}

add_action('widgets_init', 'sidebar');

// Registrar un Post Type

function productos_type(){
  $labels = array(
      'name' => 'Productos',
      'singular_name' => 'Producto',
      'menu_name' => 'Productos',
  );

  $args = array(
      'label'  => 'Productos', 
      'description' => 'Productos de Platzi',
      'labels'       => $labels,
      'supports'   => array('title','editor','thumbnail', 'revisions'), //(revisions es para tener un histórico de las modificaciones que hagamos en el post type)
      'public'    => true,
      'show_in_menu' => true,
      'menu_position' => 5, //arriba del todo, las posiciones van de 5 en 5
      'menu_icon'     => 'dashicons-cart', //puede ser una url o sacadas de predeterminadas de wordpress -> developer.wordpress.org/resource/dashicons
      'can_export' => true,
      'publicly_queryable' => true,
      'rewrite'       => true, //para que tenga gutemberg
      'show_in_rest' => true //para que tenga gutemberg

  );    
  register_post_type('producto', $args);
}

add_action('init', 'productos_type');

//Registrar una taxonomía personalizada

function pgRegisterTax() {
  $args = array(
    'hierarchical' => true,
    'labels' => array(
      'name' => 'Categorías de Productos', //en plural
      'singular_name' => 'Categoría de Productos'
    ),
    'show_in_nav_menu' => true,
    'show_admin_column' => true,
    'rewrite' => array('slug' =>'categoria-productos')
  );
  register_taxonomy('categoria-productos', array('producto'), $args);
}
add_action('init', 'pgRegisterTax');

function pgFiltroProductos() {
  $args = array(
    'post_type' => 'producto',
    'posts_per_page' => -1,
    'order' => 'ASC',
    'orderby' => 'title',
  );
  
  if($_POST['categoria']) {
    $args['tax_query'] = array(
      array(
        'taxonomy' => 'categoria-productos',
        'field' => 'slug',
        'terms' => $_POST['categoria'] 
      )
    );
  }
  $productos = new WP_Query($args);

  if($productos->have_posts()){
    $return = array();
    while($productos->have_posts()) {
      $productos->the_post();
      $return[] = array(
        'imagen' => get_the_post_thumbnail(get_the_id(), 'large'),
        'link' => get_the_permalink(),
        'titulo' => get_the_title()
      );
    }
    wp_send_json($return);
  }
}

add_action('wp_ajax_pgFiltroProductos', 'pgFiltroProductos');
add_action('wp_ajax_nopriv_pgFiltroProductos', 'pgFiltroProductos');

function novedadesAPI(){
  register_rest_route('pg/v1', 
  '/novedades/(?P<cantidad>\d+)', //regex para denominar una cantidad que será un número
  array(
    'methods' => 'GET',
    'callback' => 'pedidoNovedades' //nombre de la funcion
  ));
}
add_action('rest_api_init', 'novedadesAPI');

function pedidoNovedades($data){
  $args = array(
      'post_type' => 'post', //usado para cargar nuestras novedades
      'posts_per_page' => $data['cantidad'], //la cantidad que le pasamos por el endpoint
      'order'     => 'ASC',
      'orderby' => 'title'
  );
  $novedades = new WP_Query($args);

  if ($novedades -> have_posts()){
      $return = array();
      while ($novedades -> have_posts()) {
          $novedades -> the_post();
          $return[] = array(
              'imagen' => get_the_post_thumbnail(get_the_ID(), 'large'),
              'link' => get_the_permalink(),
              'titulo' => get_the_title()
          );
      }
      return $return;
  }
}