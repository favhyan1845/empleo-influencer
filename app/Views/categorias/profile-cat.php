<div class="container">
    <?php
        foreach ($categorias as $categories):
            if(!$categories){?>
            <div class="form-check form-check-inline col-30-custom">
                <?php
                if(is_array($setCat) || !empty($setCat)){
                    $setCat = str_replace(array("'", "\""), "", $setCat);
                    foreach ((array) $setCat as $setCats){
                        $setCats = str_replace(array("[", "]"), "", $setCats);
                        if ( $categories['id'] == $setCats ){
                        ?>
                        <h3 class="form-check-label" for="inlineCheckbox<?php echo $categories['id'] ?>"><?php echo $categories['descripcion'] ?></h3>
                        <?php
                        }
                    }
                }
                ?>

            </div>
            <?php
            }
        endforeach;
        ?>
</div>
