param([string]$Repo)
$ErrorActionPreference = 'Stop'
Set-Location $Repo
$base = 'http://127.0.0.1:8000/api/v1/projects'
$pid1 = '01924b1e-7f32-7a81-9b12-45e8a1234567'
$h = @{ Authorization = 'Bearer mock-token' }
$results = @()

function Start-Srv { $p = Start-Process php -ArgumentList 'artisan','serve' -PassThru -WindowStyle Hidden; for($i=0;$i -lt 30;$i++){ try { Invoke-WebRequest http://127.0.0.1:8000 -UseBasicParsing -TimeoutSec 1 | Out-Null; return $p } catch { Start-Sleep -Milliseconds 300 } }; throw 'server tidak naik' }
function Stop-Srv($p) { Get-CimInstance Win32_Process | Where-Object { $_.CommandLine -match 'artisan.*serve|-S 127.0.0.1:8000' } | ForEach-Object { Stop-Process -Id $_.ProcessId -Force -ErrorAction SilentlyContinue }; Start-Sleep 1 }
function Call($id, $method, $url, $headers, $body, $expect, $check) {
  try {
    $args = @{ Uri = $url; Method = $method; Headers = $headers; UseBasicParsing = $true }
    if ($body) { $args.Body = ($body | ConvertTo-Json -Compress); $args.ContentType = 'application/json' }
    $r = Invoke-WebRequest @args; $code = [int]$r.StatusCode; $content = $r.Content
  } catch { $resp = $_.Exception.Response; $code = [int]$resp.StatusCode; $sr = New-Object IO.StreamReader($resp.GetResponseStream()); $content = $sr.ReadToEnd() }
  $json = $null; try { $json = $content | ConvertFrom-Json } catch {}
  $ok = ($code -eq $expect)
  $note = ''
  if ($ok -and $check) { $note = & $check $json; if ($note -like 'GAGAL*') { $ok = $false } }
  $script:results += [pscustomobject]@{ ID = $id; Status = $code; Harap = $expect; Hasil = $(if($ok){'LULUS'}else{'GAGAL'}); Catatan = $note }
  return $json
}

Stop-Srv
Remove-Item storage/app/workflow_state.json -ErrorAction SilentlyContinue
$srv = Start-Srv

$need = 'Digitalisasi pengelolaan pengadaan dan persediaan barang'
$c1 = 'Pencatatan pengadaan dan stok masih manual pada spreadsheet terpisah'
$c2 = 'Pencatatan pengadaan dan stok masih manual; laporan bulanan sering terlambat'

$o0 = Call 'B-00 (awal)' GET "$base/$pid1/overview" $h $null 200 { param($j) "status=$($j.state.initialAnalysis.status)" }
$b1 = Call 'B-01 Buat' POST "$base/$pid1/initial-analysis" $h @{ projectNeed=$need; projectCondition=$c1 } 200 $null
$o1 = Call 'B-02 Lihat' GET "$base/$pid1/overview" $h $null 200 { param($j) $a=$j.state.initialAnalysis; if($a.projectCondition -eq $c1){"analysisId=$($a.analysisId); status=$($a.status)"}else{"GAGAL: kondisi=$($a.projectCondition)"} }
$created = $o1.state.initialAnalysis.createdAt; $upd1 = $o1.state.initialAnalysis.updatedAt
Start-Sleep 2
$b3 = Call 'B-03 Ubah' POST "$base/$pid1/initial-analysis" $h @{ projectNeed=$need; projectCondition=$c2 } 200 $null

Stop-Srv; $srv = Start-Srv

$o4 = Call 'B-04 Lihat ulang (setelah restart)' GET "$base/$pid1/overview" $h $null 200 { param($j) $a=$j.state.initialAnalysis; if($a.projectCondition -eq $c2 -and $a.createdAt -eq $created -and $a.updatedAt -ne $upd1){"analysisId=$($a.analysisId); createdAt tetap; updatedAt berubah"}else{"GAGAL: kondisi=$($a.projectCondition); createdAt=$($a.createdAt) vs $created; updatedAt=$($a.updatedAt) vs $upd1"} }
$upd4 = $o4.state.initialAnalysis.updatedAt
Start-Sleep 2
Call 'B-05 Kasus valid' POST "$base/$pid1/initial-analysis" $h @{ projectNeed=$need; projectCondition=$c2 } 200 $null | Out-Null
$o5 = Call 'B-05b Lihat' GET "$base/$pid1/overview" $h $null 200 $null
$upd5 = $o5.state.initialAnalysis.updatedAt
Call 'B-06 Kasus ditolak' POST "$base/$pid1/initial-analysis" $h @{ projectNeed=$need; projectCondition='' } 422 { param($j) if($j.code -eq 'VALIDATION_ERROR' -and $j.errors.projectCondition -and -not $j.errors.projectNeed){"$($j.code): $($j.errors.projectCondition)"}else{"GAGAL: $($j | ConvertTo-Json -Compress)"} } | Out-Null
Call 'B-07 Cek data setelah ditolak' GET "$base/$pid1/overview" $h $null 200 { param($j) $a=$j.state.initialAnalysis; if($a.projectCondition -eq $c2 -and $a.updatedAt -eq $upd5){"data tidak berubah"}else{"GAGAL: kondisi=$($a.projectCondition); updatedAt=$($a.updatedAt) vs $upd5"} } | Out-Null

Call 'K-01 planning-references' GET "$base/$pid1/planning-references" $h $null 200 { param($j) "baselineId=$($j.baselineId); planId=$($j.planId)" } | Out-Null
Call 'K-02 execution-readiness' GET "$base/$pid1/execution-readiness" $h $null 200 { param($j) "status=$($j.status); readyForExecution=$($j.readyForExecution)" } | Out-Null
Call 'K-03 UUID v7 tidak dikenal' GET "$base/01924b1e-7f32-7a81-9b12-45e8a9999999/planning-references" $h $null 404 { param($j) "$($j.code)" } | Out-Null
Call 'K-04 bukan UUID v7' GET "$base/abc-123/planning-references" $h $null 400 { param($j) "$($j.code)" } | Out-Null
Call 'K-05 tanpa Authorization' GET "$base/$pid1/planning-references" @{} $null 401 { param($j) "$($j.code)" } | Out-Null

$results | Format-Table -AutoSize -Wrap | Out-String -Width 200
