<?php
function better_scandir($dir, $sorting_order = SCANDIR_SORT_ASCENDING) {

  /****************************************************************************/
  // Roll through the scandir values.
  $files = array();
  foreach (scandir($dir, $sorting_order) as $file) {
    if ($file[0] === '.') {
      continue;
    }
    $files[$file] = filemtime($dir . '/' . $file);
  } // foreach

  /****************************************************************************/
  // Sort the files array.
  if ($sorting_order == SCANDIR_SORT_ASCENDING) {
    asort($files, SORT_NUMERIC);
  }
  else {
    arsort($files, SORT_NUMERIC);
  }

  /****************************************************************************/
  // Set the final return value.
  $ret = array_keys($files);

  /****************************************************************************/
  // Return the final value.
  return ($ret) ? $ret : false;

}
function search_file($dir) {

  /****************************************************************************/
  // Roll through the scandir values.
  $files = array();
  $i = 0;
  
  foreach (scandir($dir."\$History/") as $file) {
    if ($file[0] === '.' || $file === '$History') {
      continue;
    }
    $files[$i] = $dir."\$History/".$file;
    $i++;
  }
  foreach (scandir($dir) as $file) {
    if ($file[0] === '.' || $file === '$History') {
      continue;
    }
    $files[$i] = $dir.$file;
    $i++;
  } 

  return $files;

}
?> 