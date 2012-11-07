<?php

// If the destination site is not at the top level of a domain, enter its relative location here.  If the destination site
// is a the top level, change this to the empty string:
$site_base = "/www.nemac.org/html";

// subdir of sites/default/files where image attachments for 'Book' pages are stored:
$image_dir = "book-page-images";

global $glob;
$glob = array('input_dir'           => dirname(realpath(__FILE__)),
	      'site_root_path'      => realpath('.'),
	      'input_xml_file'      => "book.xml",
	      'input_files_archive' => "files.tgz",
	      'image_dir'           => $image_dir,
	      'image_url_base'      => $site_base . "/sites/default/files/" . $image_dir . "/",
	      'depth'               => 0,
	      'contents'            => array(),
	      'inrow'               => FALSE,
	      'current_type'        => "",
	      'current_object'      => NULL,
	      'page_count'          => 0,
	      'data'                => array('dst_nid_to_src_nid'                    => array(),
					     'src_nid_to_dst_nid'                    => array(),
					     'dst_nid_to_dst_vid'                    => array(),
					     'dst_vid_to_dst_nid'                    => array(),
					     'src_nid_to_src_vid'                    => array(),
					     'src_vid_to_src_nid'                    => array(),
					     'src_mlid_to_dst_mlid'                  => array('0' => '0'),
					     'src_fid_to_dst_fid'                    => array(),
					     'dst_fid_to_filename'                   => array(),
					     'menu_links_p'                          => array(),
					     'extra_node_revision_fields_by_src_nid' => array(),
					     ),
	      );


function dst_uid($src_uid) {
  if ($src_uid ==  3) { return  2; } // cadoughe 
  if ($src_uid == 13) { return 32; } // gdobson  
  if ($src_uid == 18) { return 41; } // hmtrussl 
  if ($src_uid == 19) { return 33; } // jdmorgan 
  if ($src_uid == 14) { return 26; } // jfox     
  if ($src_uid == 16) { return 37; } // jmarches 
  if ($src_uid ==  4) { return 34; } // jrfrimme 
  if ($src_uid == 17) { return 35; } // kmhan    
  if ($src_uid ==  7) { return 30; } // krogers  
  if ($src_uid ==  1) { return 18; } // mbp      
  if ($src_uid ==  5) { return 39; } // mjtahu   
  if ($src_uid == 10) { return 18; } // mphillip (mbp)
  if ($src_uid == 11) { return 31; } // mwhutchi 
  if ($src_uid == 15) { return 29; } // nhall    
  if ($src_uid == 12) { return 28; } // sweather 
  return 18; # mbp
}

function startElement($parser, $name, $attrs)
{
  global $glob;
  if ($name == "ROW") {
    $glob['inrow'] = TRUE;
    $glob['current_object'] = array();
  } else {
    if ($glob['depth'] == 1) {
      $glob['current_type'] = $name;
    }
  }
  $glob['depth']++;
  array_push($glob['contents'], "");
}

function endElement($parser, $name)
{
  global $glob;
  $content = array_pop($glob['contents']);
  if ($glob['inrow']) {
    if ($name == "ROW") {
      $glob['inrow'] = FALSE;
      if ($glob['current_type'] == "NODE") {
	process_node($glob['current_object']);
	++$glob['page_count'];
      }
      if ($glob['current_type'] == "NODE_REVISIONS") {
	process_node_revision($glob['current_object']);
      }
      if ($glob['current_type'] == "BOOK") {
	process_book($glob['current_object']);
      }
      if ($glob['current_type'] == "MENU_LINKS") {
	process_menu_links($glob['current_object']);
      }
      if ($glob['current_type'] == "FILES") {
	process_files($glob['current_object']);
      }
      if ($glob['current_type'] == "CONTENT_FIELD_IMAGES") {
	process_content_field_images($glob['current_object']);
      }
    } else {
      $glob['current_object'][$name] = $content;
    }
  }
  $glob['depth']--;
}

function process_contents($parser, $data) {
  global $glob;
  $glob['contents'][$glob['depth']-1] .= $data;
}


function dump_object($object) {
  foreach ($object as $key => $value) {
    printf("  %s: %s\n", $key, $value);
  }
  printf("  -----------------------------------------------------------------------------------------------\n");
}

function transform_body($body) {
  global $glob;
  $body = preg_replace('|"http://www.nemac.org/sites/default/files/|', '"'.$glob['image_url_base'], $body);
  $body = preg_replace('|"/sites/default/files|',                     '"'.$glob['image_url_base'], $body);
  $body = preg_replace("|'http://www.nemac.org/sites/default/files|", "'".$glob['image_url_base'], $body);
  $body = preg_replace("|'/sites/default/files|",                     "'".$glob['image_url_base'], $body);
  return $body;
}


function process_node($object) {
  global $glob;
  $dst_vid = db_insert('node_revision')
    ->fields(array('nid'       => 0,
		   'uid'       => 0,
		   'title'     => '',
		   'log'       => '',
		   'timestamp' => 0,
		   'status'    => 0,
		   'comment'   => 0,
		   'promote'   => 0,
		   'sticky'    => 0,
		   ))
    ->execute();
  $dst_nid = db_insert('node')
    ->fields(array('vid'         =>  $dst_vid,
		   'type'        =>  $object['TYPE'],
		   'title'       =>  $object['TITLE'],
		   'uid'         =>  dst_uid($object['UID']),
		   'status'      =>  $object['STATUS'],
		   'created'     =>  $object['CREATED'],
		   'changed'     =>  $object['CHANGED'],
		   'comment'     =>  0, # $object['COMMENT'],
		   'promote'     =>  $object['PROMOTE'],
		   'sticky'      =>  $object['STICKY'],
		   'tnid'        =>  $object['TNID'],
		   'translate'   =>  $object['TRANSLATE'],
		   ))
    ->execute();
  db_insert('node_comment_statistics')
    ->fields(array('nid'                    => $dst_nid,
		   'cid'                    => 0,
		   'last_comment_timestamp' => $object['CREATED'],
		   'last_comment_uid'       => dst_uid($object['UID']),
		   'comment_count'          => 0
		   ))
    ->execute();

  $glob['data']['dst_nid_to_src_nid'][$dst_nid]       = $object['NID'];
  $glob['data']['src_nid_to_dst_nid'][$object['NID']] = $dst_nid;
  $glob['data']['dst_nid_to_dst_vid'][$dst_nid]       = $dst_vid;
  $glob['data']['dst_vid_to_dst_nid'][$dst_vid]       = $dst_nid;
  $glob['data']['src_nid_to_src_vid'][$object['NID']] = $object['VID'];
  $glob['data']['src_vid_to_src_nid'][$object['VID']] = $object['NID'];
  $glob['data']['extra_node_revision_fields_by_src_nid'][$object['NID']] = array('status'  => $object['STATUS'],
										 'comment' => $object['COMMENT'],
										 'promote' => $object['PROMOTE'],
										 'sticky'  => $object['STICKY']);
  record_import_node($dst_nid);
  record_import_node_revision($dst_vid);
  #printf("nid = %s, vid = %s\n", $dst_nid, $dst_vid);
}

function process_node_revision($object) {
  global $glob;

  $src_nid = $object['NID'];
  $src_vid = $object['VID'];
  $dst_nid = $glob['data']['src_nid_to_dst_nid'][$src_nid];
  $dst_vid = $glob['data']['dst_nid_to_dst_vid'][$dst_nid];

  db_update('node_revision')
    ->fields(array('nid'        =>  $dst_nid,
		   'uid'        =>  dst_uid($object['UID']),
		   'title'      =>  $object['TITLE'],
		   'log'        =>  $object['LOG'],
		   'timestamp'  =>  $object['TIMESTAMP'],
		   'status'     =>  $glob['data']['extra_node_revision_fields_by_src_nid'][$object['NID']]['status'],
		   'comment'    =>  0, # $glob['data']['extra_node_revision_fields_by_src_nid'][$object['NID']]['comment'],
		   'promote'    =>  $glob['data']['extra_node_revision_fields_by_src_nid'][$object['NID']]['promote'],
		   'sticky'     =>  $glob['data']['extra_node_revision_fields_by_src_nid'][$object['NID']]['sticky'],
		   ))
    ->condition('vid', $dst_vid)
    ->execute();

  db_insert('field_data_body')
    ->fields(array('entity_type'  => 'node',
		   'bundle'       => 'book',
		   'deleted'      => 0,
		   'entity_id'    => $dst_nid,
		   'revision_id'  => $dst_vid,
		   'language'     => 'und',
		   'delta'        => 0,
		   'body_value'   => transform_body($object['BODY']),
		   'body_format'  => 'full_html',
		   ))
    ->execute();
  record_import_field_data_body($dst_nid, $dst_vid);

  db_insert('field_revision_body')
    ->fields(array('entity_type'  => 'node',
		   'bundle'       => 'book',
		   'deleted'      => 0,
		   'entity_id'    => $dst_nid,
		   'revision_id'  => $dst_vid,
		   'language'     => 'und',
		   'delta'        => 0,
		   'body_value'   => transform_body($object['BODY']),
		   'body_format'  => 'full_html',
		   ))
    ->execute();
  record_import_field_revision_body($dst_nid, $dst_vid);
}

function process_book($object) {
  global $glob;

  $dst_mlid = $glob['data']['src_mlid_to_dst_mlid'][$object['MLID']];
  $dst_nid  = $glob['data']['src_nid_to_dst_nid'][$object['NID']];
  $dst_bid  = $glob['data']['src_nid_to_dst_nid']['75'];
  db_insert('book')
    ->fields(array('mlid' => $dst_mlid,
		   'nid'  => $dst_nid,
		   'bid'  => $dst_bid))
    ->execute();
  record_import_book($dst_bid);
  $glob['dst_bid'] = $dst_bid;
}


function process_menu_links($object) {
  global $glob;

  preg_match('|^(\S+)-(\d+)$|', $object['MENU_NAME'], $matches);
  if ($matches) {
    $menu_name = $matches[1] . '-' . $glob['data']['src_nid_to_dst_nid'][$matches[2]];
  } else {
    printf("ERROR: can't parse MENU_NAME:%s\n", $object['MENU_NAME']);
    exit();
  }

  preg_match('|^node/(\d+)$|', $object['LINK_PATH'], $matches);
  if ($matches) {
    $link_path = 'node/' . $glob['data']['src_nid_to_dst_nid'][$matches[1]];
  } else {
    print "ERROR: can't parse LINK_PATH!!!\n";
  }

  $dst_mlid = db_insert('menu_links')
    ->fields(array('menu_name'    => $menu_name,
		   'plid'         => $glob['data']['src_mlid_to_dst_mlid'][$object['PLID']],
		   'link_path'    => $link_path,
		   'router_path'  => 'node/%',
		   'link_title'   => $object['LINK_TITLE'],
		   'options'      => $object['OPTIONS'],
		   'module'       => 'book',
		   'hidden'       => $object['HIDDEN'],
		   'external'     => $object['EXTERNAL'],
		   'has_children' => $object['HAS_CHILDREN'],
		   'expanded'     => $object['EXPANDED'],
		   'weight'       => $object['WEIGHT'],
		   'depth'        => $object['DEPTH'],
		   'customized'   => $object['CUSTOMIZED'],
		   'updated'      => $object['UPDATED'],
		   ))
    ->execute();
  $glob['data']['src_mlid_to_dst_mlid'][$object['MLID']] = $dst_mlid;
  record_import_menu_links($dst_mlid);

  $glob['data']['menu_links_p'][$object['MLID']] = array('P1' => $object['P1'],
							 'P2' => $object['P2'],
							 'P3' => $object['P3'],
							 'P4' => $object['P4'],
							 'P5' => $object['P5'],
							 'P6' => $object['P6'],
							 'P7' => $object['P7'],
							 'P8' => $object['P8'],
							 'P9' => $object['P9']);
}

function process_files($object) {
  global $glob;

  db_delete('file_managed')
    ->condition('uri', 'public://' . $glob['image_dir'] . '/' . $object['FILENAME'])
    ->execute();

  $dst_fid = db_insert('file_managed')
    ->fields(array('uid'       => dst_uid($object['UID']),
		   'filename'  => $object['FILENAME'],
		   'uri'       => 'public://' . $glob['image_dir'] . '/' . $object['FILENAME'],
		   'filemime'  => $object['FILEMIME'],
		   'filesize'  => $object['FILESIZE'],
		   'status'    => $object['STATUS'],
		   'timestamp' => $object['TIMESTAMP']))
    ->execute();
  $glob['data']['src_fid_to_dst_fid'][$object['FID']] = $dst_fid;
  $glob['data']['dst_fid_to_filename'][$dst_fid] = $object['FILENAME'];
  record_import_file_managed($dst_fid);
}

function process_content_field_images($object) {
  global $glob;

  $dst_nid  = $glob['data']['src_nid_to_dst_nid'][$object['NID']];
  $dst_vid  = $glob['data']['dst_nid_to_dst_vid'][$dst_nid];
  $dst_fid  = $glob['data']['src_fid_to_dst_fid'][$object['FIELD_IMAGES_FID']];

  if (!$dst_fid) {
    #printf("ERROR: can't find dst_fid for the following:\n");
    #dump_object($object);
    return;
  }

  $filename = $glob['data']['dst_fid_to_filename'][$dst_fid];
  if (! file_exists($glob['image_dir_path'] . "/" . $filename)) {
    return;
  }
  list ($width,$height) = getimagesize($glob['image_dir_path'] . "/" . $filename);
  #$width    = $glob['image_sizes'][$filename]['width'];
  #$height   = $glob['image_sizes'][$filename]['height'];

  db_insert('field_data_field_book_images')
    ->fields(array(
		   'revision_id'                  => $dst_vid,
		   'entity_id'                    => $dst_nid,
		   'delta'                        => $object['DELTA'],
		   'field_book_images_fid'        => $dst_fid,
		   'entity_type'                  => 'node',
		   'bundle'                       => 'book',
		   'deleted'                      => 0,
		   'language'                     => 'und',
		   'field_book_images_alt'        => '',
		   'field_book_images_title'      => '',
		   'field_book_images_width'      => $width,
		   'field_book_images_height'     => $height))
    ->execute();
  record_import_field_book_images($dst_nid);

  db_insert('file_usage')
    ->fields(array('fid'    => $dst_fid,
		   'module' => 'file',
		   'type'   => 'node',
		   'id'     => $dst_nid,
		   'count'  => 1))
    ->execute();
}



$glob['input_xml_path'] = sprintf("%s/%s", $glob['input_dir'], $glob['input_xml_file']);
if (! file_exists( $glob['input_xml_path'] )) {
  printf("can't read input xml file: %s\n", $glob['input_xml_path']);
  exit(0);
}

$input_files_archive_path = sprintf("%s/%s", $glob['input_dir'], $glob['input_files_archive']);
if (! file_exists( $input_files_archive_path )) {
  printf("can't read input files archive: %s\n", $input_files_archive_path);
  exit(0);
}

$glob['image_dir_path'] = $glob['site_root_path'] . '/sites/default/files/' . $glob['image_dir'];
if (! is_dir($glob['image_dir_path'])) {
  system("mkdir " . $glob['image_dir_path']);
}
system("(cd " . $glob['image_dir_path'] . " ; tar xfz $input_files_archive_path)");
printf("unpacked files archive %s into directory %s\n", $input_files_archive_path, $glob['image_dir_path']);

if (db_table_exists("book_import_node")) {
  db_query("delete from node where nid in ( select nid from book_import_node )");
  db_query("delete from node_comment_statistics where nid in ( select nid from book_import_node )");
  db_query("drop table book_import_node");
}
db_query("create table book_import_node (nid int(10) unsigned)");
function record_import_node($nid) {
  db_insert('book_import_node')
    ->fields(array('nid' => $nid))
    ->execute();
}

if (db_table_exists("book_import_node_revision")) {
  db_query("delete from node_revision where nid in ( select nid from book_import_node_revision )");
  db_query("drop table book_import_node_revision");
}
db_query("create table book_import_node_revision (vid int(10) unsigned)");
function record_import_node_revision($vid) {
  db_insert('book_import_node_revision')
    ->fields(array('vid' => $vid))
    ->execute();
}

if (db_table_exists("book_import_field_data_body")) {
  db_query("delete from field_data_body where (entity_id,revision_id) in ( select nid,vid from book_import_field_data_body )");
  db_query("drop table book_import_field_data_body");
}
db_query("create table book_import_field_data_body (nid int(10) unsigned, vid int(10) unsigned)");
function record_import_field_data_body($nid,$vid) {
  db_insert('book_import_field_data_body')
    ->fields(array('vid' => $vid, 'nid' => $nid))
    ->execute();
}

if (db_table_exists("book_import_field_revision_body")) {
  db_query("delete from field_revision_body where (entity_id,revision_id) in ( select nid,vid from book_import_field_revision_body )");
  db_query("drop table book_import_field_revision_body");
}
db_query("create table book_import_field_revision_body (nid int(10) unsigned, vid int(10) unsigned)");
function record_import_field_revision_body($nid,$vid) {
  db_insert('book_import_field_revision_body')
    ->fields(array('vid' => $vid, 'nid' => $nid))
    ->execute();
}

if (db_table_exists("book_import_menu_links")) {
  db_query("delete from menu_links where mlid in ( select mlid from book_import_menu_links )");
  db_query("drop table book_import_menu_links");
}
db_query("create table book_import_menu_links (mlid int(10) unsigned)");
function record_import_menu_links($mlid) {
  db_insert('book_import_menu_links')
    ->fields(array('mlid' => $mlid))
    ->execute();
}

if (db_table_exists("book_import_book")) {
  db_query("delete from book where bid in ( select bid from book_import_book )");
  db_query("drop table book_import_book");
}
db_query("create table book_import_book (bid int(10) unsigned)");
function record_import_book($mlid) {
  db_insert('book_import_book')
    ->fields(array('bid' => $bid))
    ->execute();
}

if (db_table_exists("book_import_file_managed")) {
  db_query("delete from file_managed where fid in ( select fid from book_import_file_managed )");
  db_query("delete from file_usage where fid in ( select fid from book_import_file_managed )");
  db_query("drop table book_import_file_managed");
}
db_query("create table book_import_file_managed (fid int(10) unsigned)");
function record_import_file_managed($fid) {
  db_insert('book_import_file_managed')
    ->fields(array('fid' => $fid))
    ->execute();
}

if (db_table_exists("book_import_field_book_images")) {
  db_query("delete from field_data_field_book_images where entity_id in ( select entity_id from book_import_field_book_images )");
  db_query("delete from field_revision_field_book_images where entity_id in ( select entity_id from book_import_field_book_images )");
  db_query("drop table book_import_field_book_images");
}
db_query("create table book_import_field_book_images (entity_id int(10) unsigned)");
function record_import_field_book_images($entity_id) {
  db_insert('book_import_field_book_images')
    ->fields(array('entity_id' => $entity_id))
    ->execute();
}

$xml_parser = xml_parser_create();
xml_set_element_handler($xml_parser,        "startElement", "endElement");
xml_set_character_data_handler($xml_parser, "process_contents");
if (!($fp = fopen($glob['input_xml_path'], "r"))) {
  die("could not open XML input file: " . $glob['input_xml_path']);
}

while ($data = fread($fp, 4096)) {
  if (!xml_parse($xml_parser, $data, feof($fp))) {
    die(sprintf("XML error: %s at line %d",
		xml_error_string(xml_get_error_code($xml_parser)),
		xml_get_current_line_number($xml_parser)));
  }
}
xml_parser_free($xml_parser);

foreach ($glob['data']['menu_links_p'] as $src_mlid => $p) {
  $dst_mlid = $glob['data']['src_mlid_to_dst_mlid'][$src_mlid];
  db_update('menu_links')
    ->fields(array('P1' => $glob['data']['src_mlid_to_dst_mlid'][$p['P1']],
		   'P2' => $glob['data']['src_mlid_to_dst_mlid'][$p['P2']],
		   'P3' => $glob['data']['src_mlid_to_dst_mlid'][$p['P3']],
		   'P4' => $glob['data']['src_mlid_to_dst_mlid'][$p['P4']],
		   'P5' => $glob['data']['src_mlid_to_dst_mlid'][$p['P5']],
		   'P6' => $glob['data']['src_mlid_to_dst_mlid'][$p['P6']],
		   'P7' => $glob['data']['src_mlid_to_dst_mlid'][$p['P7']],
		   'P8' => $glob['data']['src_mlid_to_dst_mlid'][$p['P8']],
		   'P9' => $glob['data']['src_mlid_to_dst_mlid'][$p['P9']]
		   ))
    ->condition('mlid', $dst_mlid)
    ->execute();
}

db_query("delete from field_revision_field_book_images");
db_query("insert into field_revision_field_book_images (entity_type,bundle,deleted,entity_id,revision_id,language,delta,field_book_images_fid,field_book_images_alt,field_book_images_title,field_book_images_width,field_book_images_height) select entity_type,bundle,deleted,entity_id,revision_id,language,delta,field_book_images_fid,field_book_images_alt,field_book_images_title,field_book_images_width,field_book_images_height from field_data_field_book_images");

printf("loaded %1d pages into book with bid=%1d\n", $glob['page_count'], $glob['dst_bid']);
