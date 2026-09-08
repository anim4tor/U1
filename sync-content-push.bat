@echo off
title U1 - Synchronizace obsahu (PUSH na server)
chcp 65001 >nul
powershell -NoProfile -ExecutionPolicy Bypass -File "%~dp0scripts\sync-content.ps1" push
echo.
pause
