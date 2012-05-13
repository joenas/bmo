  <div class="tertiary">
  </div>

  <!-- primary content -->
  <div class="primary">

  <article class="admin">

    <?php echo isset ($view) ? $view : ''; ?>

  </article>
  </div>

  <!-- secondary content -->
  <div class="secondary">
  <?php if ($this->authenticated!==false) : ?>
  <ul>
      <h2>Artiklar</h2>

    <li>
      <a <?php $this->helper->Link('admin/edit/article/7'); ?>>Ändra förstasidan</a>
    </li>   
    <li>
      <a <?php $this->helper->Link('admin/edit/article'); ?>> Ändra artikel</a>
    </li>
        <li>
      <a <?php $this->helper->Link('admin/add/article'); ?>>Lägg till artikel</a>
    </li>
    <h2>Objekt</h2>
    <li>
      <a <?php $this->helper->Link('admin/edit/object'); ?>>Ändra objekt</a>
    </li>
    <li>
      <a <?php $this->helper->Link('admin/add/object'); ?>>Lägg till objekt</a>
    </li>
    <h2>Logga ut</h2>
    <li>
      <a <?php $this->helper->Link('admin/logout'); ?>>Logga ut</a>
    </li>
  </ul>
<?php endif; ?>
  </div>
  
