mysqldump -uuser -p --default-character-set=utf8 phpmyscrum > phpmyscrum.dump
mysqldump -uuser -p -d --default-character-set=utf8 phpmyscrum > ..\app\config\sql\tables.sql
