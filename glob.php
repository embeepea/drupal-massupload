<?php

global $glob;
$glob = array('input_dir'           => dirname(realpath(__FILE__)),

              //'csvfile'             => "test.csv",
              'csvfile'             => "all.csv",

              'image_src_path'           => dirname(realpath(__FILE__)) . "/Dump-2012-12-21",
              'image_dst_path'           => "a",

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
                                               'Wind speed'                                   => 'Wind'
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

              'report_translations' =>
              array(
                    'CLIMATE OF THE CONTIGUOUS UNITED STATES'
                    => 'Regional Climate Trends and Scenarios for the U.S. National Climate Assessment. Part 9. Climate of the Contiguous United States',

                    'Climate of the Pacific Islands'
                    => 'Regional Climate Trends and Scenarios for the U.S. National Climate Assessment. Part 8. Climate of the Pacific Islands',

                    'Climate of Alaska'
                    => 'Regional Climate Trends and Scenarios for the U.S. National Climate Assessment. Part 7. Climate of Alaska',

                    'CLIMATE OF THE NORTHWEST U.S.'
                    => 'Regional Climate Trends and Scenarios for the U.S. National Climate Assessment. Part 6. Climate of the Northwest U.S.',

                    'CLIMATE OF THE SOUTHWEST U.S.'
                    => 'Regional Climate Trends and Scenarios for the U.S. National Climate Assessment. Part 5. Climate of the Southwest U.S.',

                    'CLIMATE OF THE U.S. GREAT PLAINS'
                    => 'Regional Climate Trends and Scenarios for the U.S. National Climate Assessment. Part 4. Climate of the U.S. Great Plains',

                    'CLIMATE OF THE MIDWEST U.S.'
                    => 'Regional Climate Trends and Scenarios for the U.S. National Climate Assessment. Part 3. Climate of the Midwest U.S.',

                    'CLIMATE OF THE SOUTHEAST U.S.'
                    => 'Regional Climate Trends and Scenarios for the U.S. National Climate Assessment. Part 2. Climate of the Southeast U.S.',

                    'CLIMATE OF THE NORTHEAST U.S.'
                    => 'Regional Climate Trends and Scenarios for the U.S. National Climate Assessment. Part 1. Climate of the Northeast U.S.',

                    ),

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
