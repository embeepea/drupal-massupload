<?php

# bid of book to be exported:
$bid = 75;

# write output files into the directory containing this script:
$output_dir = dirname(realpath(__FILE__));

function dumprow($fp, $tag, $row) {
  fwrite($fp, "    <row>\n");
  foreach ($row as $key => $value) {
    fwrite($fp, sprintf("      <%s>%s</%s>\n", $key, encode_value($value), $key));
  }
  fwrite($fp, "    </row>\n");
}

function dumpresults($fp, $tag, $query) {
  $result = db_query($query);
  fwrite($fp, sprintf("  <%s>\n", $tag));
  while ($row = db_fetch_array($result)) {
    dumprow($fp, $tag, $row);
  }
  fwrite($fp, sprintf("  </%s>\n", $tag));
}

function encode_value($value) {
  $value = str_replace("\342\200\246",  "...", $value);
  $value = str_replace("\342\200\223",  "-",   $value);
  $value = str_replace("\342\200\230",  "'",   $value);
  $value = str_replace("\342\200\231",  "'",   $value);
  $value = str_replace("\342\200\234",  '"',   $value);
  $value = str_replace("\342\200\235",  '"',   $value);
  $value = htmlentities($value);
  return $value;
}

$fp = fopen($output_dir . "/book.xml", "w");

fwrite($fp, "<bookdump>\n");
dumpresults($fp, "node",                 "select * from {node} where nid in (select nid from book where bid=$bid)");
dumpresults($fp, "node_revisions",       "select * from {node_revisions} where nid in (select nid from book where bid=$bid)");
dumpresults($fp, "menu_links",           "select * from {menu_links} where mlid in (select mlid from book where bid=$bid)");
dumpresults($fp, "book",                 "select * from {book} where bid=$bid");
dumpresults($fp, "files",                "select * from {files} where fid in (select field_images_fid from content_field_images where nid in (select nid from book where bid=$bid))");
dumpresults($fp, "content_field_images", "select * from {content_field_images} where nid in (select nid from book where bid=$bid)");
fwrite($fp, "</bookdump>\n");

fclose($fp);

printf("wrote XML dump to file '$output_dir/book.xml'\n");

$tarcmd = "( cd sites/default/files ; tar cfz -";
$result = db_query("select filename from files where fid in (select field_images_fid from content_field_images where nid in (select nid from book where bid=$bid))");
while ($row = db_fetch_array($result)) {
  if (file_exists("./sites/default/files/" . $row['filename'])) {
    $tarcmd .= " '" . $row['filename'] . "'";
  }
}
$tarcmd .= ") > $output_dir/files.tgz";
system($tarcmd);

printf("wrote files archive to $output_dir/files.tgz\n");
