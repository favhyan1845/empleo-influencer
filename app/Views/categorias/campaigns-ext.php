<div class="container">
    <p>
        <h1>Beneficio</h1>
        <strong>Escoge 1 categoria</strong>
    </p>
    <?php
        foreach ($categorias_ext as $categories):
            ?>
            <div class="form-check form-check-inline col-30-custom">
                <input type="checkbox" id="inlineCheckboxExt
                <?php echo $categories['id'] ?>" value="<?php echo $categories['id'] ?>" name="inlineCheckboxExt[]">
                <label><?php echo $categories['titulo'] ?></label>
            </div>
            <?php
        endforeach;
        ?>
</div>
