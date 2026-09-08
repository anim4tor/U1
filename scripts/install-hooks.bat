@echo off
chcp 65001 >nul
echo Instalace Git hooku pro automatickou synchronizaci Kirby Engine...

powershell -NoProfile -Command "Copy-Item -Path '%~dp0pre-push' -Destination '%~dp0..\.git\hooks\pre-push' -Force"

echo.
echo Git hook byl úspěšně nainstalován do .git/hooks/pre-push!
echo Kdykoliv provedete běžný 'git push', změny v site/engine se automaticky odešlou i do větve 'engine'.
pause
