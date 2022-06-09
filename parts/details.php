<?php
$detail = get_sub_field('detail');
if( have_rows('detail') ) { ?>
<section class="route-details fw-left">
  <div class="wrapper">
    <div class="flexwrap">
    <?php while( have_rows('detail') ): the_row(); 
      $icon = get_sub_field('icon');
      $dTitle = get_sub_field('detail_title');
      $dDesc  = get_sub_field('detail');
      ?>
      <div class="flexcol">
        <?php if ($icon) { ?>
        <div class="icon">
          <img src="<?php echo $icon['url'] ?>" alt="<?php echo $icon['title'] ?>" />
        </div> 
        <?php } ?>

        <?php if ($dTitle) { ?>
        <div class="title"><?php echo $dTitle ?></div> 
        <?php } ?>

        <?php if ($dDesc) { ?>
        <div class="desc"><?php echo $dDesc ?></div> 
        <?php } ?>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>
<?php } ?>