<?php

?>
<html lang="cs">
    <?php include 'layout/header.phtml'?>
    <body>
        <main>
            <!--     <?php //include 'layout/navigation.phtml'?>
            <section>
                <?php
                #if($_SERVER['REQUEST_URI'] !== "/")
                #    require_once ("./pages" . strtok($_SERVER['REQUEST_URI'], '?') . ".phtml");
                #else
                #    require_once ("./pages/index.phtml");
                #?>
            </section>-->
        </main>
            <?php include 'layout/footer.phtml'; ?>
          
    </body>
</html>





