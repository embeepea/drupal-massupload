<?php

include 'glob.php';

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

$line = 0;
// skip first line of file:
fgetcsv($fp); ++$line;

// process remaining lines:

$regions = array();
$reports = array();
$data_types = array();
$var_types = array();
$number_of_reportless_entries = 0;
while ($h = csv_array_to_hash(fgetcsv($fp))) {
  ++$line;
  //printf("line %4d: (id=%s) %s\n", $line, $h['id'], $h['region']);
  $regions[$h['region']] = 1;
  $reports[$h['assoc_report']] = 1;
  $data_types[$h['data_type']] = 1;
  foreach (preg_split("/\s*,\s*/", $h['var_type']) as $var_type) {
    $var_types[$var_type] = 1;
  }
  if (! $h['assoc_report']) {
    ++$number_of_reportless_entries;
  }
}

//
// REGIONS
//

$result = db_select('node', 'n')
    ->fields('n', array('nid','title'))
    ->condition('type', 'region', '=')
    ->execute();
printf("\nRegions in Drupal (Nodes of Type 'Region'):\n");
printf("    %30s    %5s\n", "Name", "NID");
foreach ($result as $record) {
  printf("    %30s    %5s\n", $record->{title}, $record->{nid});
}

printf("=============================================\nRegions in csv file:\n");
printf("  %5s  %s\n", "NID", "TITLE");
foreach (array_keys($regions) as $region) {
  $nid = region_title_to_nid($region);
  printf("  %5s  %s\n", $nid, $region);
  if (!$nid) {
    printf("WARNING: previous region has no nid!!!\n");
  }
}


//
// REPORTS
//

$result = db_select('node', 'n')
    ->fields('n', array('nid','title'))
    ->condition('type', 'report', '=')
    ->execute();
printf("\nReports in Drupal (Nodes of Type 'Report'):\n");
printf("   %5s   %s\n", "NID", "Name");
foreach ($result as $record) {
  printf("   %5s   %s\n", $record->{nid}, $record->{title});
}

printf("=============================================\nReports in csv file:\n");
foreach (array_keys($reports) as $report) {
  $nid = report_title_to_nid($report);
  printf("   %5s   %s\n", $nid, $report);
  if (!$nid) {
    printf("WARNING: previous report has no nid!!!\n");
  }
}
printf("\nNumber of entries with no report: %1d\n", $number_of_reportless_entries);


//
// DATA TYPES
//

printf("=============================================\nData Types in csv file:\n");
foreach (array_keys($data_types) as $data_type) {
  printf("  %s\n", $data_type);
}

//
// VAR TYPES
//

$result = db_query("select tid,name from taxonomy_term_data where vid = (select vid from taxonomy_vocabulary where name='Variable Type')");
printf("\nVar Types in Drupal (Taxonomy Vocabulary 'Variable Type'):\n");
printf("    %30s    %5s\n", "Name", "TID");
foreach ($result as $record) {
  printf("    %30s    %5s\n", "'".$record->{name}."'", $record->{tid});
}

printf("=============================================\nVar Types in csv file:\n");
printf("  %5s  %s\n", "TID", "VAR_TYPE");
$new_var_types = array();
foreach (array_keys($var_types) as $var_type) {
  $tid = var_type_to_tid($var_type);
  printf("  %5s  %s\n", $tid, $var_type);
  if (!$tid) {
    $new_var_types[$var_type] = 1;
  }
}
printf("  Var Types in CSV file that are NOT in Drupal:\n");
foreach (array_keys($new_var_types) as $var_type) {
  if ($glob['var_type_translations'][$var_type]) {
    $var_type = $glob['var_type_translations'][$var_type];
  }
  printf("'%s'\n", $var_type);
}
