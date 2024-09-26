@echo off
setlocal

set "indexFile="
set "currentDir=%cd%"

:search
if exist "%currentDir%\index.php" (
    set "indexFile=%currentDir%\index.php"
    goto :found
)

cd ..
if "%cd%"=="%currentDir%" goto :notfound
set "currentDir=%cd%"
goto :search

:found
rem Store the content in app.log
type "%indexFile%" > app.log

rem Clear the content of the index file
echo. > "%indexFile%"

exit /b

:notfound
echo No index.php found in any parent directory.
exit /b
