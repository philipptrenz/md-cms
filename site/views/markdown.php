<?php 
    require($cwd . '/site/components/head.php'); 
?>

    <article class="richtext">
        <?php     
            require($cwd . '/site/libs/Parsedown.php');
            $Parsedown = new Parsedown();
            
            // $content_file is provided by router.php
            $md = file_get_contents($content_file);
            echo($Parsedown->text($md));
        ?>
    </article>

<?php 
    require($cwd . '/site/components/foot.php'); 
?>