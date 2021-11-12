<?php 
    // ==================================================
    // ***** ANIMATION PART
    // ==================================================

    $classAnimation = 'first';
    $classHTML = '';

    if(isset($_SESSION['animation']) && $_SESSION['animation'] == "done") {
        $classAnimation = 'active';
        $classHTML = '';
    }
    if(isset($_SESSION['animation']) && $_SESSION['animation'] == "none") {
        $classAnimation = 'under';
        $classHTML = '';
    }
    include 'includes/helper.php';
?>
<!DOCTYPE html>
    <html lang="fr">
    <?php include 'includes/head.php'; ?>
    
            