<?php
$style = $atts['style'];
if('styleone' == $style ){
?>
    <div class="section_title <?php echo esc_attr( $atts['uid'] ); ?>">
        <h2><?php echo esc_attr($atts['title']);?></h2>
    </div>

<?php } if('styletwo' == $style ){?>
    <div class="section_title <?php echo esc_attr( $atts['uid'] ); ?>">
         <h2><?php echo esc_attr($atts['be_text']);?> <span class="af"><?php echo esc_attr($atts['af_text']);?></span></h2>
     </div>
<?php } ?>

