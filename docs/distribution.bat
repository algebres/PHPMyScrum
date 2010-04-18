echo "Start creating distribution archive!"
set SCRIPT=%~0
set CURRENT=%SCRIPT:distribution.bat=%
cd %CURRENT%
rmdir release /S /Q
svn export ../../phpmyscrum release
cd release
rmdir docs /S /Q
echo "End creating distribution archive!"

