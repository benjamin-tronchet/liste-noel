    <div class="c-santa hidden-xs <?=$_SESSION['santa']?>">
        <img src="img/santa.png" alt="Santa" class="c-santa_img">
        <p class="c-santa_caption">
            <span class="c-santa_caption_text"><?=$santa_text?></span>
            <?php include 'img/bulle-bottom.svg'; ?>
            <button class="c-santa_close" data-action="toggle-santa">
                <span class="icon-close"></span>
                <b class="qmark u-text_bigger">?</b>
            </button>
        </p>
    </div>
    
<?php
    global $class_modal, $modal_title, $modal_text;
?>
    <div class="u-modal <?=$class_modal?>">
<?php
    if(isset($_GET['info']))
    {
?>
        <div class="u-modal_box">
            <button class="u-modal_close" data-close-modal></button>
            <div class="u-modal_content">
                <header class="u-modal_header">
                    <p class="u-title_small u-text_center u-color_secondary">
                        <?=$modal_title?>
                    </p>
                </header>
                <p class="u-text_center">
                    <?=$modal_text?>
                </p>
            </div>
        </div>
<?php
    }
?>
    </div>
    
    <!-- Scripts -->
    <!-- build:js(app) js/script.min.js -->
    <script type="text/javascript" src="js/app.js"></script>
    <script type="text/javascript" src="js/form-mail.js"></script>
    <!-- endbuild -->
  </body>
</html>
