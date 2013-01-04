<?php

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

$reports_to_ensure = array(
                           'Climate of the Southeast U.S.',
                           'Climate of the U.S. Great Plains',
                           'Climate of the Northeast U.S.',
                           'Climate of the Northwest U.S.',
                           'Climate of the Midwest U.S.',
                           'Climate of the Contiguous U.S.',
                           'Climate of Alaska',
                           'Climate of the Pacific Islands'
                           );

foreach ($reports_to_ensure as $report_title) {
  printf("%s\n", $report_title);
}
