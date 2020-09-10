<div id="nofolow_mini_category_menu">
  
        <nav id="menu">
            <label for="tm" id="toggle-menu"><?php echo $heading_title; ?></label>
            <input type="checkbox" id="tm">
            <ul class="main-menu clearfix">
            <?php $count = 1; ?>
            <?php foreach ($categories as $category) { ?> 
                <?php if(!$category['children']) { ?>
                    <li><a href="<?php echo $category['href'] ?>"><?php echo $category['name']; ?></a></li>
                <?php } else { ?>
                    <li>
                    <input type="checkbox" id="sm<?php echo $count; ?>">
                        <a href="<?php echo $category['href'] ?>"><?php echo $category['name'] ?> 
                            <span class="drop-icon">▾</span>
                            <label title="Toggle Drop-down" class="drop-icon" for="sm<?php echo $count; ?>">&#10095;</label>
                        </a>
                        
                        <ul class="sub-menu">
                        <?php $subcount = 1; ?>
                            <?php foreach($category['children'] as $child){ ?>
                                <?php // if($child['level3']){ ?>
                                    <!-- <li>
                                        <a href="<?php echo $child['href'] ?>"><?php echo $child['name']; ?>
                                            <span class="drop-icon">▾</span>
                                            <label title="Toggle Drop-down" class="drop-icon" for="sm-с<?php echo $count; ?><?php echo $subcount; ?>">▾</label>
                                        </a>
                                        <input type="checkbox" id="sm-с<?php echo $count; ?><?php echo $subcount; ?>">
                                        <ul class="sub-menu">
                                            <?php foreach($child['level3'] as $grandchild){ ?>
                                                <li><a href="<?php echo $grandchild['href'] ?>"><?php echo $grandchild['name'];  ?></a></li>
                                            <?php } ?>
                                        </ul>
                                    </li> -->
                                    <?php $subcount++ ; ?>
                                <?php // } else{ ?>
                                    <li>
                                        <a href="<?php echo $child['href'] ?>"><?php echo $child['name']; ?></a>
                                    </li>
                                <?php // } ?>
                                
                            <?php } ?> 
                            
                        </ul>
                    </li>
                <?php } ?>
                <?php $count++ ; ?>
            <?php } ?>
            </ul>
        </nav>
    
</div>
