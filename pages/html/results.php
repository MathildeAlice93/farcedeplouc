<form method="POST">
    <table>		
        <?php
            $key=0;
            foreach($dictionary['results'] as $result){
                include "pages/html/".$dictionary['include'];
            }
        ?>
    </table>
</form>

