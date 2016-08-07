<?php
/* Information needed across files
 * This includes class def, etc
 */

//sqlite DB access class
class MyDB extends SQLite3{
    function __construct(){
      $this->open('db/lights.db');
    }
}

?>
