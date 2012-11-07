<?php

global $glob;
$glob = array('input_dir'           => dirname(realpath(__FILE__)),
              'csvfile'             => "test.csv",

              'image_dir'           => "images/dir/goes/here",

              // drupal user id of user who should own uploaded content:
              'uid'                 => 5,

              'time'                => time()
              );

if (!($fp = fopen(sprintf("%s/%s", $glob['input_dir'], $glob['csvfile']), "r"))) {
  die("could not open CSV input file: " . $glob['csvfile']);
}

function csv_array_to_hash($a) {
  global $glob;
  $hash = array();
  if ($a && count($a)>0) {
    $i = 0;
    if ($i < count($a)) { $hash['id']                           = $a[$i++]; }
    if ($i < count($a)) { $hash['title']                        = $a[$i++]; }
    if ($i < count($a)) { $hash['description']                  = $a[$i++]; }
    if ($i < count($a)) { $hash['region']                       = $a[$i++]; }
    if ($i < count($a)) { $hash['data_type']                    = $a[$i++]; }
    if ($i < count($a)) { $hash['var_type']                     = $a[$i++]; }
    if ($i < count($a)) { $hash['assoc_report']                 = $a[$i++]; }
    if ($i < count($a)) { $hash['image_source']                 = $a[$i++]; }
    if ($i < count($a)) { $hash['data_source_title']            = $a[$i++]; }
    if ($i < count($a)) { $hash['data_source_url']              = $a[$i++]; }
    if ($i < count($a)) { $hash['image_files']                  = $a[$i++]; }
    if ($i < count($a)) { $hash['data_files']                   = $a[$i++]; }
    if ($i < count($a)) { $hash['metadata_files']               = $a[$i++]; }
    if ($i < count($a)) { $hash['doc_files']                    = $a[$i++]; }
  }
  return $hash;
}

function record_massupload_data($tablename, $condition) {
  global $glob;
  db_insert('massupload_data')
    ->fields(array('tablename' => $tablename,
                   'where_condition' => $condition))
    ->execute();
}

function insert_node(&$h) {

  global $glob;

  $h['nid'] = db_insert('node')
    ->fields(array('type'        => 'data_catalog',
                   'language'    => 'und',
                   'title'       => $h['title'],
                   'uid'         => $glob['uid'],
                   'created'     => $glob['time'],
                   'changed'     => $glob['time'],
                   'comment'     => 1,
                   'promote'     => 1
                   ))
    ->execute();
  record_massupload_data('node', 'nid='.$h['nid']);

  $h['vid'] = db_insert('node_revision')
    ->fields(array('nid'       => $h['nid'],
                   'uid'       => $glob['uid'],
                   'title'     => $h['title'],
                   'log'       => '',
                   'timestamp' => $glob['time'],
                   'comment'   => 1,
                   'promote'   => 1
                   ))
    ->execute();
  record_massupload_data('node_revision', 'nid='.$h['nid']);

  db_update('node')
    ->fields(array('vid'        =>  $h['vid']))
    ->condition('nid', $h['nid'])
    ->execute();

}

function insert_field($h, $field, $values, $delta=0) {
  global $glob;
  //
  //  will insert into tables:
  //     field_data_field_$field
  //     field_revision_field_$field
  //
  // example usage:
  //     insert_field($h, "description", array('field_description_value' => $h['description']));
  //
  $a = array('entity_type'              => 'node',
             'bundle'                   => 'data_catalog',
             'deleted'                  => 0,
             'entity_id'                => $h['nid'],
             'revision_id'              => $h['vid'],
             'language'                 => 'und',
             'delta'                    => $delta);
  foreach ($values as $key => $value) {
    $a[$key] = $value;
  }
  db_insert('field_data_field_'.$field)->fields($a)->execute();
  record_massupload_data('field_data_field_'.$field, 'entity_id='.$h['nid']);
  db_insert('field_revision_field_'.$field)->fields($a)->execute();
  record_massupload_data('field_revision_field_'.$field, 'entity_id='.$h['nid']);
}

function get_filemime($filename) {
  if (preg_match('/.jpg$/i', $filename)) { return "image/jpeg"; }
  if (preg_match('/.jpeg$/i', $filename)) { return "image/jpeg"; }
  if (preg_match('/.png$/i', $filename)) { return "image/png"; }
  return "image/jpeg";
}

function get_filesize($filename) {
  // return filesize($filename);
  return 314159;
}

function insert_attached_file($h,$path) {
  global $glob;

  $fid = db_insert('file_managed')
    ->fields(array('uid'       => $glob['uid'],
                   'filename'  => $path,
                   'uri'       => 'public://' . $glob['image_dir'] . '/' . $path,
                   'filemime'  => get_filemime($path),
                   'filesize'  => get_filesize($path),
                   'status'    => 1,
                   'timestamp' => $glob['time']))
    ->execute();
  record_massupload_data('file_managed', 'fid='.$fid);

  db_insert('file_usage')
    ->fields(array('fid'    => $fid,
                   'module' => 'file',
                   'type'   => 'node',
                   'id'     => $h['nid'],
                   'count'  => 1))
    ->execute();
  record_massupload_data('file_usage', 'fid='.$fid);

  return $fid;
}

function process_line($h) {
  global $glob;
  insert_node($h);

  printf("title: %s\n", $h['title']);
  printf("  nid: %s\n", $h['nid']);
  printf("  vid: %s\n", $h['vid']);

  insert_field($h, "description",
               array('field_description_value'  => $h['description'],
                     'field_description_format' => NULL));

  $delta = 0;
  foreach (preg_split("/,\s*/", $h['data_files']) as $file) {
    $fid = insert_attached_file($h, $file);
    insert_field($h, "data_file",
                 array('field_data_file_fid'         => $fid,
                       'field_data_file_display'     => 1,
                       'field_data_file_description' => NULL),
                 $delta++
                 );
  }

  insert_field($h, "associated_report",
               array('field_associated_report_target_id'   => 20));

  insert_field($h, "background_link2",
               array('field_background_link2_url'          => 'www.google.com',
                     'field_background_link2_title'        => 'CMIP3_TTest'));

  insert_field($h, "data_type",
               array('field_data_type_value'   => 'Simulated'));

  insert_field($h, "metadata_file",
               array('field_metadata_file_fid'           => 22,
                     'field_metadata_file_display'       => 1));

  insert_field($h, "region",
               array('field_region_target_id'   => 29));

  insert_field($h, "source",
               array('field_source_value'    => 'Andrew Buddenberg',
                     'field_source_format'   => NULL));

  insert_field($h, "supporting_document",
               array('field_supporting_document_fid'           => 23,
                     'field_supporting_document_display'       => 1));

  insert_field($h, "variable_type",
               array('field_variable_type_tid'   => 21));

}



// clear out previously uploaded stuff, and create massupload_data tables to store record of this massupload run
if (db_table_exists("massupload_data")) {
$result = db_select('massupload_data', 'm')
    ->fields('m', array('tablename','where_condition'))
    ->execute();
  foreach ($result as $record) {
    db_query(sprintf("delete from %s where %s\n",
                     $record->{'tablename'},
                     $record->{'where_condition'}));
  }
  db_query("drop table massupload_data");
}
db_query("create table massupload_data (tablename varchar(256), where_condition varchar(1024))");


// skip first line of file:
fgetcsv($fp);

// process remaining lines:
while ($h = csv_array_to_hash(fgetcsv($fp))) {
  process_line($h);
}
