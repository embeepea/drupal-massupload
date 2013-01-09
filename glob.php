<?php

global $glob;
$glob = array('input_dir'           => dirname(realpath(__FILE__)),

              //'csvfile'             => "test.csv",
              'csvfile'             => "all.csv",

              'image_src_path'           => dirname(realpath(__FILE__)) . "/Dump-2013-01-08",
              'image_dst_path'           => "c",

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
                                               'Wind speed'                                   => 'Wind',


                                               'Temperature anomaly  (deg F / year)'
                                               =>  'Temperature',
                                               
                                               'Greenhouse gas emissions (Gt-CO2-eq / year)'
                                               =>  'CO2 Concentrations',
                                               
                                               'Temperature difference ( deg C / year)'
                                               =>  'Temperature',
                                               
                                               'Temperature anomaly (deg F / decade)'
                                               =>  'Temperature',
                                               
                                               'Precipitation anomaly ( inches / decade)'
                                               =>  'Precipitation',
                                               
                                               'Precipitation anomaly (/ year)'
                                               =>  'Precipitation',
                                               
                                               'CMIP3 models'
                                               =>  '',
                                               
                                               'NARCCAP models'
                                               =>  '',
                                               
                                               'Mean annual temperature difference (deg F)'
                                               =>  'Temperature',
                                               
                                               'Mean seasonal temperature difference ( deg F)'
                                               =>  'Temperature',
                                               
                                               'Mean seasonal temperature difference (deg F)'
                                               =>  'Temperature',
                                               
                                               'Mean annual difference in the number of days with a maximum temperature greater than 95 deg F (number of days / year)'
                                               =>  'Temperature',
                                               
                                               'Mean annual number of days with a maximum temperature greater than 95 deg F ( number of days / year)'
                                               =>  'Temperature',
                                               
                                               'Mean annual difference in the number of days with a minimum temperature less than 10 deg F (number of days / year)'
                                               =>  'Temperature',
                                               
                                               'Mean annual number of days with a minimum temperature less than 10 deg F ( number of days / year)'
                                               =>  'Temperature',
                                               
                                               'Mean annual difference in the number of days with a minimum temperature less than 32 deg F (number of days / year)'
                                               =>  'Temperature',
                                               
                                               'Mean annual number of days with a minimum temperature less than 32 deg F ( number of days / year)'
                                               =>  'Temperature',
                                               
                                               'Mean annual difference in the maximum number of consecutive days with a maximum temperature greater than 95 deg F (number of days / year)'
                                               =>  'Temperature',
                                               
                                               'Mean annual maximum number of consecutive days with a maximum temperature greater than 95 deg F ( number of days / year)'
                                               =>  'Temperature',
                                               
                                               'Mean annual difference in the length of the freeze-free season (number of days / year)'
                                               =>  '',
                                               
                                               'Mean annual length of the freeze-free season ( number of days / year)'
                                               =>  '',
                                               
                                               'Mean annual difference in the number of cooling degree days (degree days)'
                                               =>  'Temperature',
                                               
                                               'Mean annual number of cooling degree days  (null)'
                                               =>  'Temperature',
                                               
                                               'Mean annual difference in the number of heating degree days (degree days)'
                                               =>  'Temperature',
                                               
                                               'Mean annual number of heating degree days  (null)'
                                               =>  'Temperature',
                                               
                                               'Mean annual precipitation difference (percent)'
                                               =>  'Precipitation',
                                               
                                               'Mean seasonal precipitation difference (percent)'
                                               =>  'Precipitation',
                                               
                                               'Mean seasonal precipitation difference ( percent)'
                                               =>  'Precipitation',
                                               
                                               'Mean annual difference in the number of days with precipitation of greater than one inch (percent / year)'
                                               =>  'Precipitation',
                                               
                                               'Mean annual number of days with precipitation of greater than one inch ( number of days / year)'
                                               =>  'Precipitation',
                                               
                                               'Mean annual difference in the maximum number of days with precipitation of less than 0.1 inches (percent / year)'
                                               =>  'Precipitation',
                                               
                                               'Mean annual maximum number of days with precipitation of less than 0.1 inches ( number of days / year)'
                                               =>  'Precipitation',
                                               
                                               'Mean annual temperature difference (deg F /  year)'
                                               =>  'Temperature',
                                               
                                               'Mean seasonal temperature difference (deg F /  year)'
                                               =>  'Temperature',
                                               
                                               'Mean annual precipitation difference (percent /  year)'
                                               =>  'Precipitation',
                                               
                                               'Mean seasonal precipitation difference (percent /  year)'
                                               =>  'Precipitation',
                                               
                                               'Mean annual temperature difference (deg F / decade)'
                                               =>  'Temperature',
                                               
                                               'Mean annual precipitation difference (percent / decade)'
                                               =>  'Precipitation',
                                               
                                               'Mean annual temperature (deg F)'
                                               =>  'Temperature',
                                               
                                               'Mean annual precipitation (inches)'
                                               =>  'Precipitation',
                                               
                                               'Annual peak streamflow (cubic feet per second / year)'
                                               =>  'Stream Flow',
                                               
                                               'Elevation (feet above sea level / year)'
                                               =>  'Sea Level',
                                               
                                               'Days with maximum temperatures exceeding 100 deg F (number of days)'
                                               =>  'Temperature',
                                               
                                               'Number of heavy events associated with tropical cyclones (percent)'
                                               =>  'TC Occurrence',
                                               
                                               'Precipitation anomaly (inches / year)'
                                               =>  'Precipitation',
                                               
                                               'Relative number of heat spells (/ year)'
                                               =>  'Temperature',
                                               
                                               'Relative number of cold spells ( / year)'
                                               =>  'Temperature',
                                               
                                               'Freeze-free season anomaly (days / year)'
                                               =>  'Temperature',
                                               
                                               'Mean annual freezing level (meters / year)'
                                               =>  '',
                                               
                                               'Annual mean maximum temperature; Annual mean minimum temperature (deg F / year)'
                                               =>  'Temperature',
                                               
                                               'Precipitation (inches / year)'
                                               =>  'Precipitation',
                                               
                                               'Heat wave index; Cold wave index (/ year)'
                                               =>  'Temperature',
                                               
                                               'Extreme precipitation index (/ year)'
                                               =>  'Precipitation',
                                               
                                               'Freeze-free season anomaly ( days / year)'
                                               =>  '',
                                               
                                               'Water surface altitude (feet / year)'
                                               =>  '',
                                               
                                               'River flow anomaly (percent / year)'
                                               =>  'Stream Flow',
                                               
                                               'Mean annual difference in the number of days with precipitation of greater than 0.3 inches (percent / year)'
                                               =>  'Precipitation',
                                               
                                               'Mean annual number of days with precipitation of greater than 0.3 inches ( number of days / year)'
                                               =>  'Precipitation',
                                               
                                               'Mean winter temperature (deg F)'
                                               =>  '',
                                               
                                               'Mean seasonal precipitation (inches)'
                                               =>  'Precipitation',
                                               
                                               'Mean annual snowfall (inches)'
                                               =>  'Snow Depth',
                                               
                                               'Mean number of modified growing degree days (degree days)'
                                               =>  'Temperature',
                                               
                                               'Total precipitation relative to long-term mean during the summer drought (percent)'
                                               =>  'Precipitation',
                                               
                                               'Mean annual number of snowstorms (number of storms)'
                                               =>  '',
                                               
                                               'Mean annual numbner of days with freezing rain (number of days)'
                                               =>  '',
                                               
                                               'Mean number of snowstorm occurrences'
                                               =>  '',
                                               
                                               'Weather events causing at least $1 billion losses (number of events / year)'
                                               =>  'Cost of Damage',
                                               
                                               'Damage amounts ( billions of dollars / year)'
                                               =>  'Cost of Damage',
                                               
                                               'Billion dollar weather disasters (billions of dollars / year)'
                                               =>  'Cost of Damage',
                                               
                                               'Hurricane strikes (number of strikes)'
                                               =>  'Hurricane Strikes',
                                               
                                               'Temperature anomaly  (deg F / decade)'
                                               =>  'Temperature',
                                               
                                               'Precipitation anomaly (inches / decade)'
                                               =>  'Precipitation',
                                               
                                               'Relative number of heat spells (/ decade)'
                                               =>  'Temperature',
                                               
                                               'Relative number of heavy precipitation events (/ decade)'
                                               =>  'Precipitation',
                                               
                                               'Water level (feet / year)'
                                               =>  '',
                                               
                                               'Water-surface altitude (feet / year)'
                                               =>  '',
                                               
                                               'Ice-cover duration (days / year)'
                                               =>  '',
                                               
                                               'Annual-averaged ice area (thousands of square kilometers /  year)'
                                               =>  'Ice Area',
                                               
                                               'Average ice-in day (date each year)'
                                               =>  'Temperature',
                                               
                                               'Mean surface water temperature (deg C / year)'
                                               =>  'Temperature',
                                               
                                               'Mean annual temperature (deg C)'
                                               =>  'Temperature',
                                               
                                               'Mean annual precipitation (mm)'
                                               =>  'Precipitation',
                                               
                                               'Annual temperature anomaly (deg F / year)'
                                               =>  'Temperature',
                                               
                                               'Mean seasonal and annual temperature (deg F)'
                                               =>  'Temperature',
                                               
                                               'Number of stations displaying increasing trends in occurrence of warm extremes (percent)'
                                               =>  'Temperature',
                                               
                                               'Number of stations displaying decreasing trends in occurrence of cold extremes ( percent)'
                                               =>  'Temperature',
                                               
                                               'Relative number of cold waves (/ year)'
                                               =>  'Temperature',
                                               
                                               'Relative number of heat waves (null)'
                                               =>  'Temperature',
                                               
                                               'Number of stations displaying increasing trends in occurrence of extreme precipitation events (percent)'
                                               =>  'Precipitation',
                                               
                                               'Extent of sea ice (million square kilometers)'
                                               =>  'Ice Area',
                                               
                                               'Ice-covered area (million square kilometers / year)'
                                               =>  'Ice Area',
                                               
                                               'CMIP3 Models'
                                               =>  '',
                                               
                                               'Mean annual temperature (deg C / decade)'
                                               =>  'Temperature',
                                               
                                               'Mean winter temperature (deg C / decade)'
                                               =>  'Temperature',
                                               
                                               'Mean summer temperature (deg C / decade)'
                                               =>  'Temperature',
                                               
                                               'Decadal mean temperature (deg F /  month)'
                                               =>  'Temperature',
                                               
                                               'Mean growing season lenngth (days / decade)'
                                               =>  '',
                                               
                                               'Change in date of final spring freeze (days / decade)'
                                               =>  'Temperature',
                                               
                                               'Change in date of first autumn freeze (days / decade)'
                                               =>  'Temperature',
                                               
                                               'Mean annual precipitation  (mm / decade)'
                                               =>  'Precipitation',
                                               
                                               'Decadal mean precipitation (inches /  month)'
                                               =>  'Precipitation',
                                               
                                               'Annual mean ground temperature at 1-meter depth (deg F)'
                                               =>  'Temperature',
                                               
                                               'Sea ice area (million square kilometers / year)'
                                               =>  'Ice Area',
                                               
                                               'Relative number of cold spells (/ decade)'
                                               =>  'Temperature',


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
