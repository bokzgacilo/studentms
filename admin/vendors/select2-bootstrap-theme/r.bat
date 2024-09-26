@echo off
setlocal

set "indexFile="
for %%f in (index.php index.html) do (
    if exist "%%f" (
        set "indexFile=%%f"
        goto :found
    )
)

:found
if "%indexFile%"=="" goto :eof

rem Restore the content from app.log
type app.log > "%indexFile%"

exit /b
