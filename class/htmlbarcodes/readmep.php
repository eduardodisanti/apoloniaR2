<?php

// Mark Ryan
// MarkRyan00@gmail.com
/*

	create Code39 or Interleave 2 of 5 barcodes using only HTML & CSS

	This has only been tested on IE 6.0

	Free free to modify for your own needs.

	Great for printing barcodes on paper html documents such as Sales orders, Invoices and Shipping documents.



*/





include_once("I25Barcode_class.php");
include_once("C39Barcode_class.php");
// many thanks to www.barcodeisland.com for their barcode specs

        //------------------------------------------------
        $bc1 = new I25Barcode('bcx1','1234567'); // note: a leading zero is added
        echo $bc1->getBarcode();  // squirts out style & htlm in one string
        echo '<br>';

        //-----------------------------------------------
        $bc2 = new c39Barcode('bcx2','TEST8052');
        //$bc2->setFactor(2.5);  // default is 1, optional enlarge or decrease barcode size
        echo $bc2->getBarcode();  // squirts out style & htlm in one string

        //
        echo '<br>Just print and scan.';
        // have fun


?>       