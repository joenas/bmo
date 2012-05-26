  <div class="tertiary">
      <?php echo isset($view_article_sidebar) ? $view_article_sidebar : ''; ?>

      <?php $this->helper->searchField(); ?>
  </div>

  <!-- primary content -->
  <div class="primary">
     <?php //echo $this->helper->RandomImage(); ?>
 
	<article class="articles">
  <?php echo isset($view_article_list) ? $view_article_list : ''; ?>
  <?php echo isset($view_article) ? $view_article : ''; ?>
     <?php echo isset($view_images) ? $view_images : ''; ?>

	</article>
  </div>

  <!-- secondary content -->
  <div class="secondary">
     <?php //echo $this->helper->RandomImage(); ?>
  </div>
