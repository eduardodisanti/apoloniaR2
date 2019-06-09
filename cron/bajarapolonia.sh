cd /srv/tmp
mysqldump --password=virgen --user=apolonia --skip-add-drop-table --no-create-info apolonia > apolonia.sql
tar cfz apolonia.tar.gz apolonia.sql
rm apolonia.sql
