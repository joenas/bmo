

  <!-- primary content -->
  <div class="primary">
     <?php echo $this->helper->RandomImage(); ?>
 
	<article class="articles">
  <?php echo isset($view_article_list) ? $view_article_list : ''; ?>
  <?php echo isset($view_article) ? $view_article : ''; ?>

	</article>
  </div>

  <!-- secondary content -->
  <div class="secondary">
	<?php echo isset($view_article_sidebar) ? $view_article_sidebar : ''; ?>

  </div>
