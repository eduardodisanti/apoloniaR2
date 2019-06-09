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
class PhpCodeBuster {
  // What to strip
  var $StripComments, $StripEOL;

  // What to bust
  var $BustNames, $BustVars;

  // Use plain names instead of md5 code (useful for debugging busted code)
  var $BustPlain;
  
  // Private storage
  var $Busts, $Names, $Vars;

  var $Debug = false;
  
  // Show me current version
  function PhpBustVersion() { return "PhpCodeBuster v0.92"; }
  
  // Class constructor
  function PhpCodeBuster() {
    $this->StripComments = $this->StripEOL = 
    $this->BustNames     = $this->BustVars =
    $this->BustPlain     = false;

    $this->Busts = $this->Names = $this->Vars = array();
  }

  // Returns busted name (and saves relation with original name for future use)
  function PhpBustHasher(&$storage, $prefix, $text) {
    $cod = $prefix . (($this->BustPlain) ? $text : substr(md5($text), 0, 8));
    
    $this->Busts[$cod] = $text;
    $storage[$text]    = $cod;

    return $cod;
  }

  // Returns busted name. Deals with different types.  
  function PhpBustEncode($type, $text, $skip = 0) {
    $text = substr($text, $skip);
    $prfx = ($skip) ? '$' : '';
    
    switch ($type) {
      case 'N': return $this->PhpBustHasher($this->Names, 'n', $text);
      case 'V': return $prfx . $this->PhpBustHasher($this->Vars, 'v', $text);
      default : return false;
    }
  }

  // Returns busted code.
  // Input parameter $input contains filename (default) or
  // "code to be busted" ($file = false)
  function PhpBustCode ($input, $file = true) {
    $fdelim = array(T_WHITESPACE, T_COMMENT, T_ML_COMMENT);
    $vdefin = array("_SERVER", "_ENV", "_COOKIE", "_GET", "_POST", "_FILES",
                    "_SESSION", "_REQUEST", "GLOBALS", "php_errormsg", "this",
                    "HTTP_SERVER_VARS", "HTTP_ENV_VARS", "HTTP_COOKIE_VARS",
                    "HTTP_GET_VARS", "HTTP_POST_VARS", "HTTP_FILES_VARS",
                    "HTTP_SESSION_VARS");

    $funfnd = $clsfnd = $newfnd = $objfnd = false;
    $busted = '';
    $tobust = ($file) ? @file_get_contents($input) : $input;

    if ($tobust !== false) {
      $tokens = token_get_all($tobust);
      $tokeys = array_keys($tokens);
      $tovals = array_values($tokens);
      $tokcnt = count($tokens);

      $ti = 0;
      while ($ti < $tokcnt) {
        $token = $tovals[$ti++];

        if (is_string($token)) {
          $funfnd = false;
          $clsfnd = false;
          $newfnd = false;
          $busted .= $token;
        }
        else {
          list($tok, $txt) = $token;
          
          if ($this->Debug) echo sprintf("%30s : %s\n", token_name($tok), $txt);
          
          switch ($tok) {
            case T_FUNCTION       : $funfnd = true; $busted .= $txt; break;
            case T_NEW            : $newfnd = true; $busted .= $txt; break;
            case T_CLASS          : $clsfnd = true; $busted .= $txt; break;
            case T_OBJECT_OPERATOR: $objfnd = true; $busted .= $txt; break;

            case T_STRING:
              if ($funfnd) {
                $txt = ($this->BustNames) ?$this->PhpBustEncode('N',$txt) :$txt;
                $funfnd = false;
              }
              elseif ($clsfnd || $newfnd) {
                $txt = ($this->BustNames) ?$this->PhpBustEncode('N',$txt) :$txt;
                $clsfnd = $newfnd = false;
              }
              elseif ($objfnd) {
                for ($tj = $ti; $tj < $tokcnt; $tj++) {
                  $nxttoken = $tovals[$tj];
                  
                  if (is_string($nxttoken)) {
                    if ($nxttoken == '(') {
                      if ($this->BustNames)
                        $txt= $this->PhpBustEncode('N', $txt);
                    }
                    elseif ($this->BustVars)
                      $txt = $this->PhpBustEncode('V', $txt);
                    
                    $objfnd = false;
                    break;
                  }
                  else {
                    list($nxttok, $nxttxt) = $nxttoken;

                    if (! in_array($nxttok, $fdelim)) {
                      if ($this->BustVars) $txt= $this->PhpBustEncode('V',$txt);
                      $objfnd = false;
                      break;
                    }
                  }
                }
              }
              else {
                for ($tj = $ti; $tj < $tokcnt; $tj++) {
                  $nxttoken = $tovals[$tj];
                  
                  if (is_string($nxttoken)) {
                    if ($nxttoken == '(') {
                      if ($this->BustNames && !is_callable($txt))
                        $txt = $this->PhpBustEncode('N', $txt);
                    }
                    break;
                  }
                  else {
                    list($nxttok, $nxttxt) = $nxttoken;

                    if (! in_array($nxttok, $fdelim)) break;
                  }
                }
              }
              $busted .= $txt;
              break;

            case T_VARIABLE:
              if ($this->BustVars && ! in_array(substr($txt,1), $vdefin))
                $txt = $this->PhpBustEncode('V', $txt, 1);
              $busted .= $txt;
              break;

            case T_COMMENT:
            case T_ML_COMMENT:
              if (ereg("(.)*$", $txt, $cmt)) {
                if (! $this->StripComments) $busted .= $cmt;
                if (! $this->StripEOL) $busted .= "\n";
              }
              elseif (! $this->StripComments) $busted .= $txt;
              break;

            case T_WHITESPACE:
              if ($this->StripEOL)
                $busted  = trim($busted) . ' ' . trim($txt);
              else
                $busted .= $txt;
              break;

            default:
              $busted .= $txt;
              break;
          }
        }
      }
      
      return $busted;
    }
  
    return false;
  }
}
?>
