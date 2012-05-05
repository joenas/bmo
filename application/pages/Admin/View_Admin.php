

  <!-- primary content -->
  <div class="primary">

  <article>

    <?php echo isset ($loginView) ? $loginView : ''; ?>

    <?php echo isset($editView) ? $editView : ''; ?>

  </article>
  </div>

  <!-- secondary content -->
  <div class="secondary">
  <?php if ($this->authenticated!==false) : ?>
  <ul>
    <li>
      <a <?php $this->helper->Link('admin/edit/article/home'); ?>>Ändra förstasidan</a>
    </li>   
    <li>
      <a <?php $this->helper->Link('admin/edit/object'); ?>>Ändra objekt</a>
    </li>
    <li>
      <a <?php $this->helper->Link('admin/edit/article'); ?>> Ändra artikel</a>
    </li>
    <li>
      <a <?php $this->helper->Link('admin/logout'); ?>>Logga ut</a>
    </li>
  </ul>
<?php endif; ?>
  </div>
