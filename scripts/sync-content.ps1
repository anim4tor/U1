<#
.SYNOPSIS
    Bezpečná synchronizace obsahu (public/content) mezi lokálem a větví 'content' na GitHubu.

.DESCRIPTION
    Tento skript zabraňuje nechtěnému přepsání klientského obsahu:
    - PULL: Stáhne nejnovější obsah z větve 'content' (předtím vytvoří lokální zálohu).
    - PUSH: Po výslovném potvrzení nahraje lokální obsah do větve 'content' na GitHubu.
    - STATUS: Zobrazí rozdíly mezi lokálním obsahem a obsahem na serveru/GitHubu.
#>

param (
    [Parameter(Position = 0)]
    [ValidateSet("pull", "push", "status")]
    [string]$Action = "pull"
)

$ErrorActionPreference = "Stop"
$ScriptDir = Split-Path -Parent $MyInvocation.MyCommand.Path
$RootDir   = Split-Path -Parent $ScriptDir
Set-Location $RootDir

$ContentDir = Join-Path $RootDir "public\content"
$BackupDir  = Join-Path $RootDir "site\store\backup"

Write-Host "=================================================" -ForegroundColor Cyan
Write-Host " U1 - Git Content Synchronizer" -ForegroundColor Cyan
Write-Host " Action: $Action | Content: public/content" -ForegroundColor Cyan
Write-Host "=================================================" -ForegroundColor Cyan

function Create-LocalBackup {
    if (-not (Test-Path $ContentDir)) { return }
    if (-not (Test-Path $BackupDir)) {
        New-Item -ItemType Directory -Path $BackupDir -Force | Out-Null
    }
    $timestamp = Get-Date -Format "yyyy-MM-dd_HH-mm-ss"
    $zipFile = Join-Path $BackupDir "content_backup_$timestamp.zip"
    Write-Host "[BACKUP] Vytvářím zálohu lokálního obsahu do: $zipFile" -ForegroundColor Yellow
    Compress-Archive -Path "$ContentDir\*" -DestinationPath $zipFile -Force
    Write-Host "[BACKUP] Záloha byla úspěšně vytvořena." -ForegroundColor Green
}

switch ($Action) {
    "pull" {
        Write-Host "`n[1/3] Stahuji nejnovější metadata větve 'content' z GitHubu..." -ForegroundColor Yellow
        git fetch origin content

        Create-LocalBackup

        Write-Host "`n[2/3] Aplikuji obsah z origin/content do public/content..." -ForegroundColor Yellow
        git checkout origin/content -- public/content

        Write-Host "`n[3/3] Hotovo! Lokální obsah byl aktualizován z GitHubu (větev 'content')." -ForegroundColor Green
    }

    "status" {
        Write-Host "`nZjišťuji stav změn v public/content..." -ForegroundColor Yellow
        git fetch origin content
        Write-Host "`nRozdíly oproti origin/content:" -ForegroundColor Cyan
        git diff --stat origin/content -- public/content
        git status --short public/content
    }

    "push" {
        Write-Host "`n[POZOR] Chystáte se nahrát lokální obsah na GitHub!" -ForegroundColor Red
        Write-Host "Pokud klient prováděl úpravy na serveru, mohlo by dojít k jejich přepsání." -ForegroundColor Red
        $confirm = Read-Host "Opravdu chcete přepsat obsah ve větvi 'content' lokálním obsahem? (napište 'ANO' pro pokračování)"

        if ($confirm -ne "ANO") {
            Write-Host "Operace byla zrušena uživatelem. Žádné změny nebyly odeslány." -ForegroundColor Yellow
            exit 0
        }

        Create-LocalBackup

        $currentBranch = (git branch --show-current).Trim()
        Write-Host "`nAktuální větev: $currentBranch" -ForegroundColor Yellow

        # Add only content
        git add public/content
        $hasChanges = (git status --porcelain public/content)
        if (-not $hasChanges) {
            Write-Host "V public/content nejsou žádné necommitnuté změny." -ForegroundColor Green
        } else {
            $msg = Read-Host "Zadejte commit message (nebo Enter pro výchozí)"
            if ([string]::IsNullOrWhiteSpace($msg)) {
                $msg = "content(local): sync local content changes"
            }
            git commit -m $msg
        }

        # Push to origin/content
        Write-Host "`nOdesílám změny do větve 'content' na GitHubu..." -ForegroundColor Yellow
        git push origin HEAD:content

        Write-Host "`nHotovo! Obsah byl odeslán do větve 'content'." -ForegroundColor Green
    }
}
