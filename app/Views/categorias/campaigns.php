<div class="container">
    <p>
        <h1>Modulo categorias</h1>
        <strong>Escoge 3 categorias</strong>
    </p>
    <?php
        foreach ($categorias as $categories):
            ?>
            <div class="form-check form-check-inline col-30-custom">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox
                <?php echo $categories['id'] ?>" value="<?php echo $categories['id'] ?>" name="inlineCheckbox[]" <?php
                if(is_array($setCat) || !empty($setCat)){
                    $setCat = str_replace(array("'", "\""), "", $setCat);
                    foreach ((array) $setCat as $setCats){
                        $setCats = str_replace(array("[", "]"), "", $setCats);
                        echo ( $categories['id'] == $setCats ) ? 'checked' : "";
                    }
                }
                ?>>
                <label><?php echo $categories['descripcion'] ?></label>
            </div>
            <?php
        endforeach;
        ?>
    <span id="subcategoria"></span>
</div>
