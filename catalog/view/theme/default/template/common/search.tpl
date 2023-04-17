<div id="search" class="input-group">

    <input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $text_search; ?>" class="form-control input-search" />

    <button type="button" class="search-close">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none">
        <path fill="#000" d="m12.94 12 2.864-2.858a.669.669 0 0 0-.946-.946l-2.857 2.864-2.858-2.864a.669.669 0 1 0-.946.946l2.864 2.857-2.864 2.858a.666.666 0 0 0 .217 1.092.666.666 0 0 0 .729-.146L12 12.939l2.857 2.864a.666.666 0 0 0 1.092-.217.666.666 0 0 0-.146-.729L12.94 12Z"/>
      </svg>
    </button>

  <span class="input-group-btn">
    <button type="button" class="btn btn-violet"><?php echo $text_find; ?></button>
  </span>
</div>