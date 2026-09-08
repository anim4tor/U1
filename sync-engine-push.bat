@echo off
chcp 65001 >nul
title Synchronizace Kirby Engine (Push)
powershell -NoProfile -ExecutionPolicy Bypass -File "%~dp0scripts\sync-engine.ps1" push
pause
