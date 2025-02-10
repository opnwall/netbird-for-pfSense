<?php
require_once("guiconfig.inc");
$pgtitle = [gettext("VPN"), gettext("Netbird")];
include("head.inc");

// Netbird Configuration
$nb_bin = '/usr/local/bin/netbird';
$validActions = ['up', 'down', 'restartsvc', 'statusd'];

// Handle user actions
$action = $_GET['action'] ?? null;
$output = '';
if (in_array($action, $validActions)) {
    switch ($action) {
        case 'up':
            $command = "$nb_bin up";
            break;
        case 'down':
            $command = "$nb_bin down";
            break;
        case 'restartsvc':
            $command = '/usr/sbin/service netbird restart';
            break;
        case 'statusd':
            $command = "$nb_bin status -d";
            break;
    }

    exec($command, $execOutput, $return_var);
    $output = $return_var === 0 ? implode("\n", $execOutput) : 'Error executing command, please check the logs.';
}
?>
<!-- Service Control Panel -->
<div class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title">Service Control</h2>
    </div>
    <div class="form-group">
        <form method="get">
            <button type="submit" name="action" value="up" class="btn btn-success"><i class="fa fa-play"></i>
                Start</button>
            <button type="submit" name="action" value="down" class="btn btn-danger"><i class="fa fa-stop"></i>
                Stop</button>
            <button type="submit" name="action" value="restartsvc" class="btn btn-warning"><i class="fa fa-sync"></i>
                Restart</button>
        </form>
    </div>
</div>

<!-- Node Status -->
<div class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title">Node Status</h2>
    </div>
    <div class="panel-body">
        <div id="node-status">
            <p>Loading node status...</p>
        </div>
    </div>
</div>

<!-- Command Output -->
<div class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title">Status Information</h2>
    </div>
    <div class="form-group">
        <?php if (empty($output)): ?>
            <form method="get">
                <button type="submit" name="action" value="statusd" class="btn btn-info"><i class="fa fa-info-circle"></i>
                    Query</button>
            </form>
        <?php endif; ?>
        <?php if (!empty($output)): ?>
            <pre><?= htmlspecialchars($output); ?></pre>
        <?php endif; ?>
    </div>
</div>

<!-- Dynamic Refresh Node Status -->
<script>
    function fetchNodeStatus() {
        fetch('vpn_netbird_status.php') // Call the status API
            .then(response => response.text())
            .then(data => {
                document.getElementById('node-status').innerHTML = data;
            })
            .catch(error => {
                console.error("Failed to refresh node status:", error);
                document.getElementById('node-status').innerHTML = "<p>Error loading node status.</p>";
            });
    }

    document.addEventListener('DOMContentLoaded', () => {
        fetchNodeStatus(); // Initial load
        setInterval(fetchNodeStatus, 5000); // Refresh every 5 seconds
    });
</script>

<?php include("foot.inc"); ?>
