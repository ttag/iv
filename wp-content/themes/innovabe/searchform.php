<form method="get" id="searchform" action="<?php bloginfo('home'); ?>/">
<div><input type="text" class='rounded' value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" />
<input type="submit" class="button ie6fix" id="searchsubmit" value="." />
</div>
</form>
