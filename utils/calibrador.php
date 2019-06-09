<?php

function dibujarString($texto, $x, $y, $R, $G, $B) {
}

   header ("Content-type: image/png");
   $img_handle = ImageCreate (400, 250) or die ("Cannot Create image");
   $back_color = ImageColorAllocate ($img_handle, 192, 192, 192);
   $txt_color = ImageColorAllocate ($img_handle, 0, 0, 0);
   ImageString ($img_handle, 31, 5, 5,  "AA123456789B123456789C123456789D123456789", $txt_color);
   ImageString ($img_handle, 31, 5, 25, "BA123456789B123456789C123456789D123456789", $txt_color);
   ImageString ($img_handle, 31, 5, 45, "CA123456789B123456789C123456789D123456789", $txt_color);
   ImageString ($img_handle, 31, 5, 65, "DA123456789B123456789C123456789D123456789", $txt_color);
   ImageString ($img_handle, 31, 5, 85, "EA123456789B123456789C123456789D123456789", $txt_color);
   ImageString ($img_handle, 31, 5,105, "FA123456789B123456789C123456789D123456789", $txt_color);
   ImageString ($img_handle, 31, 5,125, "EA123456789B123456789C123456789D123456789", $txt_color);
   ImageString ($img_handle, 31, 5,145, "FA123456789B123456789C123456789D123456789", $txt_color);
   ImageString ($img_handle, 31, 5,165, "GA123456789B123456789C123456789D123456789", $txt_color);
   ImageString ($img_handle, 31, 5,185, "HA123456789B123456789C123456789D123456789", $txt_color);
   ImageString ($img_handle, 31, 5,205, "IA123456789B123456789C123456789D123456789", $txt_color);
   ImageString ($img_handle, 31, 5,225, "JA123456789B123456789C123456789D123456789", $txt_color);

   $rotate = imagerotate($img_handle, 90, 0);
   ImagePng ($rotate);
?> 
