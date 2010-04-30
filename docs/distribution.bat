echo "Start creating distribution archive!"
set SCRIPT=%~0
set CURRENT=%SCRIPT:distribution.bat=%
cd %CURRENT%
rmdir release /S /Q
svn export ../../phpmyscrum release
cd release
rmdir docs /S /Q
cd ..
"C:\Program Files\7-Zip\7z.exe" a -tzip -mx=9 -mfb=128 phpmyscrum0.1.zip release
echo "End creating distribution archive!"

