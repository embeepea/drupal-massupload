<?php


$result = db_query("select tid,name from taxonomy_term_data where vid = (select vid from taxonomy_vocabulary where name='Variable Type')");
foreach ($result as $record) {
  printf("%10s  %s\n", $record->{tid}, $record->{name});
}
