<?php

$result = db_select('massupload_data', 'm')
    ->fields('m', array('tablename','where_condition'))
    ->execute();
  foreach ($result as $record) {
    printf("delete from %s where %s\n",
           $record->{'tablename'},
           $record->{'where_condition'});
  }
