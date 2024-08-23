<?php
if($experiences !== false){
    ?>
    <div class="container">
        <div class="row">
        <?php
        foreach($experiences as $exp){
            ?>
                <div class="col-sm">
                    <div class="card-header">
                        <h5><?php echo $exp['name_camp']; ?></h5>
                    </div>
                    <div class="card-body">
                        <?php echo $exp['Description']; ?>
                    </div>
                </div>
            <?php
        }
        ?>
        </div>
    </div>
    <?php
}
?>