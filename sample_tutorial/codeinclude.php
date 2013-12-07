<button type="button" class="btn btn-success btn-sm" data-toggle="collapse" data-target="#<?php echo $fshort; ?>">
  <?php echo "Show/Hide " . $f; ?>
</button>
<div id="<?php echo $fshort; ?>" class="collapse">
  <h4><a href="<?php echo $dir . $f; ?>"><?php echo $f; ?></a></h4>
  <?php echo "<pre><code>".htmlspecialchars(file_get_contents($dir . $f))."</code></pre>" ?>
  <button type="button" class="btn btn-success btn-sm" data-toggle="collapse" data-target="#<?php echo $fshort ?>">
    <?php echo "Show/Hide " . $f; ?>
  </button>              
</div> <!-- end collapse -->
