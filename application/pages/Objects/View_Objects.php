  <div class="tertiary">
      <?php echo isset($view_sidebar) ? $view_sidebar : ""; ?>
      <?php ViewHelper::Instance()->searchField(); ?>
  </div>

  <!-- primary content -->
  <div class="primary">
  <article>
    <?php echo isset($view_object) ? $view_object : ""; ?>
  </article>
  </div>

  <!-- secondary content -->
  <div class="secondary">
  </div>
