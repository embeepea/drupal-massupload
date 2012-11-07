select
	i.id,
	i.title,
	i.description,
 	doc.abbr as region,
  	group_concat(distinct ds.type order by ds.type separator ', ') data_type,
	i.attributes as var_type,
 	doc.name as assoc_report,
	who.name as image_source,	
	group_concat(distinct ds.name order by ds.name separator ', ') data_source_title,
 	group_concat(distinct ds.url order by ds.name separator ', ') data_source_url,
	group_concat(distinct image_files.file order by image_files.file separator ', ') image_files,
 	group_concat(distinct data_files.file order by data_files.file separator ', ') data_files,
	group_concat(distinct metadata_files.file order by metadata_files.file separator ', ') metadata_files,
	group_concat(distinct doc_files.file order by doc_files.file separator ', ') doc_files
from image i
left outer join document doc on i.document_id = doc.id
left outer join image_dataset on i.id = image_dataset.image_id
left outer join dataset ds on image_dataset.dataset_id = ds.id
left outer join image_creator im_who on im_who.image_id = i.id
left outer join who on who.id = im_who.who_id
left outer join (
	select
		image_id,
		file_type,
		concat(dir, file) file
	from file 
	where file.image_id = 75
		and file_type = 'IMAGE'
) image_files on image_files.image_id = i.id

left outer join (
	select
		image_id,
		file_type,
		concat(dir, file) file
	from file 
	where file.image_id = 75
		and file_type = 'DATA'
) data_files on data_files.image_id = i.id
left outer join (
	select
		image_id,
		file_type,
		concat(dir, file) file
	from file 
	where file.image_id = 75
		and file_type = 'METADATA'
) metadata_files on metadata_files.image_id = i.id
left outer join (
	select
		image_id,
		file_type,
		concat(dir, file) file
	from file 
	where file.image_id = 75
		and file_type = 'DOC'
) doc_files on doc_files.image_id = i.id
where i.id = 75
