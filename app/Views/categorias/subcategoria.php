
<div class="container">
        <p>
            <strong>Escoge 1 sub categoria</strong>
        </p>
        <?php
            foreach ($subcategorias as $subcategories):
                ?>
                <div class="form-check form-check-inline col-30-custom">
                    <input class="form-check-input" type="checkbox" id="inlineCheckboxSub<?php echo $subcategories['id'] ?>" name="inlineCheckboxSub[]" value="<?php echo $subcategories['id'] ?>"
                    <?php
                    if($setSubCat):
                        $setSubCat = str_replace(array("'", "\""), "", $setSubCat);
                        foreach ($setSubCat as $setSubCats):
                        $setSubCat = str_replace(array("[", "]"), "", $setSubCat);
                        echo ( $subcategories['id'] == $setSubCats ) ? 'checked' : "";
                        endforeach;
                    endif;
                    ?>
                    >
                    <label><?php echo $subcategories['descripcion'] ?></label>
                </div>
                <?php
            endforeach;
            ?>
</div>
