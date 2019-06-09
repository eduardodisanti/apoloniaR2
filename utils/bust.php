<?php
/*
LICENSE
=======
Copyright (C) 2005 Martijn Loots, Cosix Automatisering, NL

PhpCodeBuster is a PHP code obfuscator, written in PHP.

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
02110-1301, USA.

A copy of the GNU General Public License is available at
http://www.gnu.org/copyleft/gpl.html
*/

// I use this script as a UNIX command line program. It
// sends the resulting busted code to standard output:
//
//   Usage: bust.php <name_of_inputfile>

// Include PhpCodeBuster class
require_once ('phpcodebuster.class.php');

// Create a new object 
$buster = new PhpCodeBuster();

// "Best bust" settings
$buster->StripComments  = true;
$buster->StripEOL       = true;
$buster->BustNames      = true;
$buster->BustVars       = true;

// Debug "code to be busted"
//
// These settings changes all names, but keeps the result
// human-readable. It only prepends some text to each name,
// instead of using MD5 replacements
$buster->StripEOL       = false;
$buster->BustPlain      = true;

// Create busted code
echo $buster->PhpBustCode($_SERVER['argv'][1]);
?>
