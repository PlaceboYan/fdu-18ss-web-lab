<?php

    function outputOrderRow($file, $title, $quantity, $price) {
        echo "<tr>";
        //TODO
        echo "<td><image src='images/books/tinysquare/".$file."'></td><td style=\"text-align: left\">".$title."</td><td>".$quantity."</td><td>$".number_format($price,2,'.','')."</td><td>$".number_format($quantity*$price,2,'.','')."</td>";
        echo "</tr>";
    }
?>