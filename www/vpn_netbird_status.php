<?php
require_once("guiconfig.inc");

// Netbird Configuration
$nb_bin = '/usr/local/bin/netbird';

// Get node status
$peers = [];
exec("$nb_bin status --json", $peerOutput, $peerReturn);
if ($peerReturn === 0) {
    $peers = json_decode(implode('', $peerOutput), true)['peers']['details'] ?? [];
}
?>

<?php if (!empty($peers)): ?>
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Node Name</th>
            <th>IP Address</th>
            <th>Connection Type</th>
            <th>Direct</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($peers as $peer): ?>
        <tr class="<?= $peer['status'] === 'Connected' ? 'table-success' : 'table-danger'; ?>">
            <td><?= htmlspecialchars($peer['fqdn'] ?? 'Unknown'); ?></td>
            <td><?= htmlspecialchars($peer['netbirdIp'] ?? 'Unknown'); ?></td>
            <td><?= htmlspecialchars($peer['connectionType'] ?? 'Unknown'); ?></td>
            <td><?= $peer['direct'] ? 'Yes' : 'No'; ?></td>
            <td><?= $peer['status'] === 'Connected' ? 'Online' : 'Offline'; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p>No available node information at the moment.</p>
<?php endif; ?>
