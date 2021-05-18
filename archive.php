<?php get_header(); ?>
<div class="container my-4">
  <div class="row">
    <div class="col-12 text-center">
      <h1><?php the_archive_title(); ?></h1>

    </div>
    <?php if(have_posts()){
      while(have_posts(  )) {
        the_post(); ?>
    <div class="col-4 text-center-single-archive">
      <a href="<?php the_permalink(); ?>">
        <?php the_post_thumbnail('medium'); ?>
        <h4><?php the_title(); ?></h4>

      </a>
    </div>
    <?php } ?>
    <?php } ?>
  </div>
</div>

<?php get_footer(); ?>