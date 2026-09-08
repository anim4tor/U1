@echo off
title U1 - Synchronizace obsahu (PULL ze serveru)
chcp 65001 >nul
powershell -NoProfile -ExecutionPolicy Bypass -File "%~dp0scripts\sync-content.ps1" pull
echo.
pause
