<?php

   function pagination($buses)
       {
         echo '  <div class="row liste_footer">
                            <p>';

 $value = ($buses->currentPage() -1) * $buses->perPage()  +1;

       echo $value .' à ';
if((($buses->currentPage() -1)  * $buses->perPage() + $buses->perPage()) > $buses->total())
    {
        echo   $buses->total() .' sur ';
    }else{
echo  ($buses->currentPage() -1)  * $buses->perPage() + $buses->perPage() .' sur ';
     }

         echo   $buses->total() .' résultats';
           echo '</p>';


         echo '<div class="pagination_liste">';

      echo $buses->render();
echo '</div>
</div>';
    }
pagination($buses);








