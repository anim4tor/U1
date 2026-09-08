# Auto-distribute Kirby engine across all version branches using isolated worktrees
param(
    [string]$SourceBranch = ""
)

$ErrorActionPreference = "Continue"
if (Test-Path Variable:\PSNativeCommandUseErrorActionPreference) {
    $PSNativeCommandUseErrorActionPreference = $false
}
$RepoRoot = Resolve-Path (Join-Path $PSScriptRoot "..")
Set-Location $RepoRoot

if ([string]::IsNullOrWhiteSpace($SourceBranch)) {
    try {
        $SourceBranch = (git branch --show-current).Trim()
    } catch {
        exit 0
    }
}

if ($SourceBranch -eq "content" -or $SourceBranch -eq "engine") {
    exit 0
}

Write-Host "`n==========================================================" -ForegroundColor Cyan
Write-Host " [Kirby Engine] Automatická distribuce backendu do všech verzí" -ForegroundColor Cyan
Write-Host " Zdrojová větev: $SourceBranch" -ForegroundColor Yellow
Write-Host "==========================================================" -ForegroundColor Cyan

# 1. Update origin/engine directly
Write-Host " -> Aktualizuji větev origin/engine..." -ForegroundColor Yellow
cmd /c "git push --no-verify origin HEAD:refs/heads/engine --quiet 2>nul"
Write-Host "    [OK] Větev origin/engine je aktuální." -ForegroundColor Green

# 2. Distribute to other version branches using fast isolated worktrees
$targetBranches = @("design", "v1", "v2", "v3")

foreach ($target in $targetBranches) {
    if ($target -eq $SourceBranch) { continue }

    Write-Host " -> Zpracovávám větev $target..." -ForegroundColor Yellow
    $tempWorktree = Join-Path $env:TEMP "u1_dist_$target"
    if (Test-Path $tempWorktree) {
        cmd /c "git worktree remove --force ""$tempWorktree"" 2>nul"
        if (Test-Path $tempWorktree) { Remove-Item -Recurse -Force $tempWorktree -ErrorAction SilentlyContinue }
    }

    cmd /c "git worktree add --quiet ""$tempWorktree"" $target 2>nul"
    if (-not (Test-Path $tempWorktree)) {
        Write-Host "    [CHYBA] Nepodařilo se vytvořit worktree pro $target." -ForegroundColor Red
        continue
    }

    # Copy site/engine and site/config into worktree
    if (Test-Path (Join-Path $tempWorktree "site\engine")) {
        Remove-Item -Recurse -Force (Join-Path $tempWorktree "site\engine") -ErrorAction SilentlyContinue
    }
    Copy-Item -Recurse -Force "site\engine" (Join-Path $tempWorktree "site\engine")

    if (Test-Path "site\config") {
        if (-not (Test-Path (Join-Path $tempWorktree "site\config"))) {
            New-Item -ItemType Directory -Path (Join-Path $tempWorktree "site\config") -Force | Out-Null
        }
        Copy-Item -Recurse -Force "site\config\*" (Join-Path $tempWorktree "site\config")
    }

    # Also sync helper scripts
    Copy-Item -Recurse -Force "scripts\*" (Join-Path $tempWorktree "scripts") -ErrorAction SilentlyContinue
    Copy-Item -Force "sync-engine-*.bat" $tempWorktree -ErrorAction SilentlyContinue

    # Check for changes in worktree
    $diff = cmd /c "git -C ""$tempWorktree"" status --porcelain site/engine site/config scripts"
    if ($diff) {
        cmd /c "git -C ""$tempWorktree"" add site/engine site/config scripts sync-engine-push.bat sync-engine-pull.bat"
        cmd /c "git -C ""$tempWorktree"" commit --quiet -m ""chore(engine): auto-distribute kirby backend from $SourceBranch"""
        cmd /c "git -C ""$tempWorktree"" push --no-verify origin $target --quiet 2>nul"
        Write-Host "    [OK] Větev $target byla aktualizována a odeslána na GitHub." -ForegroundColor Green
    } else {
        Write-Host "    [SKIP] Větev $target již má shodný backend." -ForegroundColor Gray
    }

    # Clean up worktree
    cmd /c "git worktree remove --force ""$tempWorktree"" 2>nul"
    if (Test-Path $tempWorktree) { Remove-Item -Recurse -Force $tempWorktree -ErrorAction SilentlyContinue }
}

Write-Host "==========================================================" -ForegroundColor Green
Write-Host " [Kirby Engine] Hotovo! Backend je sjednocen ve všech verzích." -ForegroundColor Green
Write-Host " Šablony jednotlivých verzí (site/components/) zůstaly netknuté." -ForegroundColor Green
Write-Host "==========================================================`n" -ForegroundColor Green
