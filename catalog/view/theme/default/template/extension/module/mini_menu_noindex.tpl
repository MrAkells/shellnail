<div id="nofolow_mini_category_menu">
    <div class="dropdown">
            <a id="dLabel" role="button" data-toggle="dropdown" class="mini-menu"><div class="burger"><span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span></div>
                <span class="title-mini-menu"><?php echo $heading_title; ?></span>
            </a>
            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                <?php foreach ($categories as $category) { ?> 
                    
                   
                    <li><a href="<?php echo $category['href'] ?>" rel="nofolow"><?php echo $category['name']; ?></a></li>
                   
                    
                <?php } ?>

            </ul>
        </div>
    
</div>
