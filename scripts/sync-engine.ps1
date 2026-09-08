# PowerShell Script pro synchronizaci Kirby Engine (blueprints, controllers, collections, models, plugins)
param (
    [Parameter(Position = 0)]
    [ValidateSet("push", "pull", "status", "all")]
    [string]$Action = "push",

    [Parameter(Position = 1)]
    [switch]$NoPropagate = $false
)

$ErrorActionPreference = "Stop"
$RepoRoot = Resolve-Path (Join-Path $PSScriptRoot "..")
Set-Location $RepoRoot

Write-Host "================================================" -ForegroundColor Cyan
Write-Host " Kirby Engine Sync Tool: $Action" -ForegroundColor Cyan
Write-Host "================================================" -ForegroundColor Cyan

# Check if git is available
try {
    $currentBranch = (git branch --show-current).Trim()
} catch {
    Write-Error "Git není k dispozici nebo složka není git repozitář."
    exit 1
}

Write-Host "Aktuální větev: $currentBranch" -ForegroundColor Yellow

if ($Action -eq "status") {
    git fetch origin engine 2>$null
    Write-Host "`nKontrola změn v site/engine a site/config oproti origin/engine..." -ForegroundColor Gray
    git diff --stat origin/engine -- site/engine site/config
    exit 0
}

if ($Action -eq "pull") {
    Write-Host "`nStahuji aktuální stav enginu z větve 'origin/engine'..." -ForegroundColor Cyan
    git fetch origin engine
    git checkout origin/engine -- site/engine site/config
    Write-Host "✅ Složka site/engine byla úspěšně aktualizována na stav z větve engine!" -ForegroundColor Green
    Write-Host "Nezapomeňte provést git commit, pokud chcete změny uložit do větve $currentBranch." -ForegroundColor Gray
    exit 0
}

if ($Action -eq "push" -or $Action -eq "all") {
    Write-Host "`n1. Kontrola lokálních změn v site/engine a site/config..." -ForegroundColor Cyan

    # Stage engine files in current branch
    git add site/engine site/config
    $hasEngineDiff = (git status --porcelain site/engine site/config)

    if ($hasEngineDiff) {
        $commitMsg = Read-Host "Zadejte popis změn v enginu (stiskněte Enter pro výchozí)"
        if ([string]::IsNullOrWhiteSpace($commitMsg)) {
            $commitMsg = "chore(engine): update kirby engine & blueprints"
        }
        git commit -m $commitMsg
        Write-Host "Lokální změny byly commitnuty do větve $currentBranch." -ForegroundColor Green
    }

    # Push current branch
    Write-Host "`n2. Odesílám větev $currentBranch na GitHub..." -ForegroundColor Cyan
    git push origin $currentBranch

    # Push to origin/engine
    Write-Host "`n3. Aktualizuji centrální větev 'origin/engine'..." -ForegroundColor Cyan
    git push origin "$($currentBranch):refs/heads/engine"

    if (-not $NoPropagate) {
        Write-Host "`n4. Propaguji nový engine do ostatních verzí (v1, v2, v3, design)..." -ForegroundColor Cyan
        $targetBranches = @("design", "v1", "v2", "v3")

        foreach ($b in $targetBranches) {
            if ($b -eq $currentBranch) { continue }
            Write-Host " -> Aktualizuji větev $b..." -ForegroundColor Yellow

            try {
                git checkout $b 2>$null
                git checkout $currentBranch -- site/engine site/config scripts sync-engine-push.bat sync-engine-pull.bat
                $diff = (git status --porcelain site/engine site/config scripts sync-engine-push.bat sync-engine-pull.bat)
                if ($diff) {
                    git add site/engine site/config scripts sync-engine-push.bat sync-engine-pull.bat
                    git commit -m "chore(engine): sync backend and tooling from $currentBranch"
                    git push origin $b
                    Write-Host "    [OK] Větev $b aktualizována a odeslána na GitHub." -ForegroundColor Green
                } else {
                    Write-Host "    [SKIP] Větev $b již má shodný engine." -ForegroundColor Gray
                }
            } catch {
                Write-Host "    [CHYBA] Nepodařilo se aktualizovat větev $b : $($_.ToString())" -ForegroundColor Red
            }
        }

        # Return to original branch
        git checkout $currentBranch 2>$null
    }

    Write-Host "`n================================================" -ForegroundColor Green
    Write-Host " ✅ Synchronizace enginu byla úspěšně dokončena!" -ForegroundColor Green
    Write-Host " Centrální větev 'engine' i všechny verze mají sjednocený backend." -ForegroundColor Green
    Write-Host " Šablony a frontendové soubory jednotlivých verzí zůstaly netknuté." -ForegroundColor Green
    Write-Host "================================================" -ForegroundColor Green
    exit 0
}
