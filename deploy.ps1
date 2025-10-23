# -------------------------------
# CONFIGURATION
# -------------------------------
$LocalBranch = "MOODLE_311_STABLE"                  # your local branch
$RemoteName = "origin"                              # your fork or main repo
$ServerUser = "cloud"                               # SSH username
$ServerHost = "vm.smallville.cloud.bme.hu"          # server address
$ServerPort = "6906"                                # SSH port
$ServerPath = "/var/www/html/moodle"                # path to Moodle on server
$CommitMessage = if ($args.Length -gt 0) { $args[0] } else { "Auto commit from script $(Get-Date)" }

# -------------------------------
# STEP 1: Commit and push locally
# -------------------------------
Write-Host "Adding changes..."
git add .

# Only commit if there are changes
$changes = git status --porcelain
if ($changes) {
    Write-Host "Committing changes: $CommitMessage"
    git commit -m "$CommitMessage"
} else {
    Write-Host "No changes to commit."
}

Write-Host "Pushing to $RemoteName/$LocalBranch..."
git push $RemoteName $LocalBranch

# -------------------------------
# STEP 2: SSH into server and pull
# -------------------------------
Write-Host "Connecting to server and pulling changes..."
ssh $ServerUser@$ServerHost -p $ServerPort "cd $ServerPath && sudo git fetch --all && sudo git reset --hard $RemoteName/$LocalBranch && sudo php admin/cli/purge_caches.php && sudo grunt amd --force"

Write-Host "Done!"
