@echo off

goto console

:init
rem Path
if exist "%CD%\cake\console" (
  set "CAKECONSOLE=%CD%\cake\console"
) else (
  if exist "%CD%\..\cake\console" (
    set "CAKECONSOLE=%CD%\..\cake\console"
  ) else (
    echo cake\console��������܂���ł����B
    echo.
    echo cake\console�̃p�X����͂��ĉ������B
    set /p CAKECONSOLE=:
  )
)
set "PATH=%PATH%;%CAKECONSOLE%"
rem Alias
doskey cat=type $*
doskey ls=dir /w $*
doskey ll=dir $*
doskey la=dir /a $*
doskey rm=del $*
exit /b

:console
if "%1" equ "init" (
  call :init
) else (
  prompt $P$_$G$S
  start "" /b %COMSPEC% /k %~f0 init
)
