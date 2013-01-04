<?php

global $glob;
$glob = array('input_dir'           => dirname(realpath(__FILE__)),

              //'csvfile'             => "test.csv",
              'csvfile'             => "all.csv",

              'image_src_path'           => dirname(realpath(__FILE__)) . "/Dump-2012-12-21",
              'image_dst_path'           => "b",

              // drupal user id of user who should own uploaded content:
              'uid'                 => 5,

              'time'                => time(),

              'regions'             => array(),
              'reports'             => array(),

              'var_types'           => array(),

              'var_type_translations' => array(
                                               'Billion-dollar weather/climate disasters'     => 'Billion-Dollar Weather/Climate Disasters',
                                               'CO2 concentrations'                           => 'CO2 Concentrations',
                                               'CO2 concentrations'                           => 'CO2 Concentrations',
                                               'Cost of damage'                               => 'Cost of Damage',
                                               'Drought trends'                               => 'Drought Trends',
                                               'Freezing level'                               => 'Freezing Level',
                                               'Greenhouse gas emissions'                     => 'Greenhouse Gas Emissions',
                                               'Hurricane strikes'                            => 'Hurricane Strikes',
                                               'Ice area'                                     => 'Ice Area',
                                               'Lake elevation'                               => 'Lake Water Level',
                                               'Lake ice cover'                               => 'Lake Ice Cover',
                                               'Lake level'                                   => 'Lake Water Level',
                                               'Lake water level'                             => 'Lake Water Level',
                                               'PDO Index'                                    => 'PDO Index',
                                               'Precipitation (inches)'                       => 'Precipitation',
                                               'Precipitation'                                => 'Precipitation',
                                               'River flow'                                   => 'Stream Flow',
                                               'River volume'                                 => 'Stream Flow',
                                               'SST'                                          => 'Sea Surface Temperature',
                                               'Sea ice area'                                 => 'Sea Ice Area',
                                               'Sea level'                                    => 'Sea Level',
                                               'Snow depth'                                   => 'Snow Depth',
                                               'Storm surge height'                           => 'Storm Surge Height',
                                               'Streamflow'                                   => 'Stream Flow',
                                               'TC occurrence'                                => 'TC Occurrence',
                                               'Temperature (F)'                              => 'Temperature',
                                               'Temperature'                                  => 'Temperature',
                                               'Tornadoe count'                               => 'Tornado Count',
                                               'Water level'                                  => 'Lake Water Level',
                                               'Water temperature'                            => 'Lake Water Surface Temperature',
                                               'Wind speed'                                   => 'Wind Speed',
                                               'Wind'                                         => 'Wind Speed'
                                               ),

              'region_translations' => array(
                                             'SE' =>                    'Southeast',
                                             'GP' =>                    'Great Plains',
                                             'NE' =>                    'Northeast',
                                             'SW' =>                    'Southwest',
                                             'NW' =>                    'Northwest',
                                             'MW' =>                    'Midwest',
                                             'US' =>                    'National',
                                             'AK' =>                    'Alaska',
                                             'PI' =>                    'Pacific Islands',
                                             ),

              'report_translations' => array(),

              );

$result = db_select('node', 'n')
    ->fields('n', array('nid','title'))
    ->condition('type', 'region', '=')
    ->execute();

foreach ($result as $record) {
  $glob['regions'][$record->{title}] = $record->{nid};
}

function region_title_to_nid($region_title) {
  global $glob;

  foreach ($glob['region_translations'] as $src => $dst) {
    if ($region_title == $src) {
      $region_title = $dst;
      break;
    }
  }

  if ($region_title == 'US') {
    $region_title = 'National';
  }
  return $glob['regions'][$region_title];
}


########################################################################

$result = db_select('node', 'n')
    ->fields('n', array('nid','title'))
    ->condition('type', 'report', '=')
    ->execute();

foreach ($result as $record) {
  $glob['reports'][$record->{title}] = $record->{nid};
}

function report_title_to_nid($report_title) {
  global $glob;

  foreach ($glob['report_translations'] as $src => $dst) {
    if ($report_title == $src) {
      $report_title = $dst;
      break;
    }
  }

  if ($report_title == 'US') {
    $report_title = 'National';
  }
  return $glob['reports'][$report_title];
}


########################################################################

$result = db_query("select tid,name from taxonomy_term_data where vid = (select vid from taxonomy_vocabulary where name='Variable Type')");
foreach ($result as $record) {
  $glob['var_types'][$record->{name}] = $record->{tid};
}

function var_type_to_tid($var_type) {
  global $glob;

  foreach ($glob['var_type_translations'] as $src => $dst) {
    if ($var_type == $src) {
      $var_type = $dst;
      break;
    }
  }

  return $glob['var_types'][$var_type];
}

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
  if (preg_match('/.gif$/i', $filename)) { return "image/gif"; }
  if (preg_match('/.tiff?$/i', $filename)) { return "image/tiff"; }
  if (preg_match('/.html$/i', $filename)) { return "text/html"; }
  printf("ERROR: unknown mime type (using image/jpeg) for file: %s\n", $filename);
  return "image/jpeg";
}

function get_filesize($filename) {
  return filesize($filename);
  //return 314159;
}

function insert_attached_file($h,$file) {
  global $glob;

  $fid = db_insert('file_managed')
    ->fields(array('uid'       => $glob['uid'],
                   'filename'  => $file,
                   'uri'       => 'public://' . $glob['image_dst_path'] . '/' . $file,
                   'filemime'  => get_filemime($file),
                   'filesize'  => get_filesize($glob['image_src_path'] . '/' . $file),
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

function validate_image_files(&$h) {
  global $glob;
  $badfiles = array();
  foreach (preg_split("/,\s*/", $h['image_files']) as $file) {
    if ($file) {
      $path = $glob['image_src_path'] . "/" . $file;
      if (file_exists($path)) {
        list ($width,$height) = getimagesize($path);
        if ($width == 0 || $height == 0) {
          $badfiles[] = "'" . $file . "'";
        }
      } else {
        $badfiles[] = "'" . $file . "'";
      }
    }
  }
  if (count($badfiles) > 0) {
    $h['image_files_error_message'] = "can't read image_file width/height for file(s): " . join(",", $badfiles);
    return false;
  }
  return true;
}

function validate_data_files(&$h) {
  global $glob;
  $badfiles = array();
  foreach (preg_split("/,\s*/", $h['data_files']) as $file) {
    if ($file) {
      $path = $glob['image_src_path'] . "/" . $file;
      if (file_exists($path)) {
        $size = get_filesize($path);
        if ($size <= 0) {
          $badfiles[] = "'" . $file . "'";
        }
      } else {
        $badfiles[] = "'" . $file . "'";
      }
    }
  }
  if (count($badfiles) > 0) {
    $h['data_files_error_message'] = "can't read data_file(s): " . join(",", $badfiles);
    return false;
  }
  return true;
}

function validate_metadata_files(&$h) {
  global $glob;
  $badfiles = array();
  foreach (preg_split("/,\s*/", $h['metadata_files']) as $file) {
    if ($file) {
      $path = $glob['image_src_path'] . "/" . $file;
      if (file_exists($path)) {
        $size = get_filesize($path);
        if ($size <= 0) {
          $badfiles[] = "'" . $file . "'";
        }
      } else {
        $badfiles[] = "'" . $file . "'";
      }
    }
  }
  if (count($badfiles) > 0) {
    $h['metadata_files_error_message'] = "can't read metadata_file(s): " . join(",", $badfiles);
    return false;
  }
  return true;
}

function validate_doc_files(&$h) {
  global $glob;
  $badfiles = array();
  foreach (preg_split("/,\s*/", $h['doc_files']) as $file) {
    if ($file) {
      $path = $glob['image_src_path'] . "/" . $file;
      if (file_exists($path)) {
        $size = get_filesize($path);
        if ($size <= 0) {
          $badfiles[] = "'" . $file . "'";
        }
      } else {
        $badfiles[] = "'" . $file . "'";
      }
    }
  }
  if (count($badfiles) > 0) {
    $h['doc_files_error_message'] = "can't read doc_file(s): " . join(",", $badfiles);
    return false;
  }
  return true;
}

function process_line($h) {
  global $glob;

  #if (!$h['image_files']) { return; }
  #if ($h['id'] != '75') { return; }

  printf("\n");
  printf("Reading source id: %s\n", $h['id']);
  printf("            Title: %s\n", $h['title']);

  if (!validate_image_files($h)) {
    printf("  !! ERROR: %s\n", $h['image_files_error_message']);
    return;
  }

  if (!validate_data_files($h)) {
    printf("  !! ERROR: %s\n", $h['data_files_error_message']);
    return;
  }

  if (!validate_metadata_files($h)) {
    printf("  !! ERROR: %s\n", $h['metadata_files_error_message']);
    return;
  }

  if (!validate_doc_files($h)) {
    printf("  !! ERROR: %s\n", $h['doc_files_error_message']);
    return;
  }

  insert_node($h);
  printf("     inserted nid: %s\n", $h['nid']);
  printf("              vid: %s\n", $h['vid']);

  /*
   *  input column(s): image_files
   *     drupal field: image
   */
  $delta = 0;
  foreach (preg_split("/,\s*/", $h['image_files']) as $file) {
    if ($file) {
      list ($width,$height) = getimagesize($glob['image_src_path'] . "/" . $file);
      printf("  attaching [%4d X %4d] image: %s\n", $width, $height, $file);
      $fid = insert_attached_file($h, $file);
      insert_field($h, "image",
                   array('field_image_fid'         => $fid,
                         'field_image_alt'         => NULL,
                         'field_image_title'       => NULL,
                         'field_image_width'       => $width,
                         'field_image_height'      => $height),
                   $delta++
                   );
    }
  }

  /*
   *  input column(s): data_source_url, data_source_title
   *     drupal field: background_link2
   */
  if ($h['data_source_url'] || $h['data_source_title']) {
    insert_field($h, "background_link2",
                 array('field_background_link2_url'          => $h['data_source_url'],
                       'field_background_link2_title'        => $h['data_source_title']));
  } else {
    // report missing link
  }


  /*
   *  input column(s): description
   *     drupal field: description
   */
  insert_field($h, "description",
               array('field_description_value'  => $h['description'],
                     'field_description_format' => NULL));

  /*
   *  input column(s): data_files
   *     drupal field: data_file
   */
  $delta = 0;
  foreach (preg_split("/,\s*/", $h['data_files']) as $file) {
    if ($file) {
      printf("  attaching data_file: %s\n", $file);
      $fid = insert_attached_file($h, $file);
      insert_field($h, "data_file",
                   array('field_data_file_fid'         => $fid,
                         'field_data_file_display'     => 1,
                         'field_data_file_description' => NULL),
                   $delta++
                   );
    }
  }

  /*
   *  input column(s): associated_report
   *     drupal field: associated_report
   */
  //
  // NOTE: don't populate this field for now; ask for clarification
  //       about what to do, since we don't have the reports uploaded yet
  //       (or ever --- do they want this field at all any more?)
  //
  //insert_field($h, "associated_report",
  //             array('field_associated_report_target_id'   => 20));

  /*
   *  input column(s): data_type
   *     drupal field: data_type
   */
  if (!$h['data_type']) {
    printf("  WARNING: empty data_type field\n");
  } else {
    $delta = 0;
    if (preg_match('/observ$/i', $h['data_type'])) {
      insert_field($h, "data_type",
                   array('field_data_type_value'   => 'Observed'),
                   $delta++
                   );
    }
    if (preg_match('/simul$/i', $h['data_type'])) {
      insert_field($h, "data_type",
                   array('field_data_type_value'   => 'Simulated'),
                   $delta++
                   );
    }
  }

  /*
   *  input column(s): metadata_files
   *     drupal field: metadata_file
   */
  $delta = 0;
  foreach (preg_split("/,\s*/", $h['metadata_files']) as $file) {
    if ($file) {
      printf("  attaching metadata_file: %s\n", $file);
      $fid = insert_attached_file($h, $file);
      insert_field($h, "metadata_file",
                   array('field_metadata_file_fid'         => $fid,
                         'field_metadata_file_display'     => 1,
                         'field_metadata_file_description' => NULL),
                   $delta++
                   );
    }
  }

  /*
   *  input column(s): region
   *     drupal field: region
   */
  $region_nid = region_title_to_nid($h['region']);
  if ($region_nid) {
    insert_field($h, "region",
                 array('field_region_target_id'   => $region_nid));
  } else {
    printf("  WARNING: unknown region '%s'\n", $h['region']);
  }

  /*
   *  input column(s): image_source
   *     drupal field: source
   */
  if ($h['image_source']) {
    insert_field($h, "source",
                 array('field_source_value'    => $h['image_source'],
                       'field_source_format'   => NULL));
  } else {
    printf("  WARNING: empty image_source\n");
  }

  /*
   *  input column(s): doc_files
   *     drupal field: supporting_document
   */
  $delta = 0;
  foreach (preg_split("/,\s*/", $h['doc_files']) as $file) {
    if ($file) {
      printf("  attaching supporting_document: %s\n", $file);
      $fid = insert_attached_file($h, $file);
      insert_field($h, "supporting_document",
                   array('field_supporting_document_fid'         => $fid,
                         'field_supporting_document_display'     => 1,
                         'field_supporting_document_description' => NULL),
                   $delta++
                   );
    }
  }

  /*
   *  input column(s): var_type
   *     drupal field: variable_type
   */
  $delta = 0;
  foreach (preg_split("/,\s*/", $h['var_type']) as $var_type) {
    if ($var_type) {
      $tid = var_type_to_tid($var_type);
      if ($tid) {
        insert_field($h, "variable_type",
                     array('field_variable_type_tid'   => $tid),
                     $delta++);
      } else {
        printf("  WARNING: Unknown var_type: '%s'\n", $var_type);
      }
    }
  }

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
